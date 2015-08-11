<?php
namespace backend\controllers;
use Yii;
use common\models\MembersGroup;
use common\models\PublicNumber;
use common\helpers\Out;
use common\helpers\Common;
use backend\base\BaseBackController;
use backend\helpers\Error;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

//用户分组控制器
class MembersGroupController extends BaseBackController
{
    //操作类型控制
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'create' => ['post'],
                    'update' => ['post'],
                ],
            ],
        ];
    }

    //显示列表
    public function actionIndex() {
        $query = MembersGroup::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 20]);
        $models = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->orderBy(['order_id' => SORT_DESC]) //倒序排列
                        ->all();
        $data = [];
        if (!empty($models)) {
           foreach($models AS $k => $v) {
               $data[$k] = $v->attributes;
               $data[$k]['create_time'] = date('Y-m-d H:s',$v['create_time']);
               $data[$k]['public_number_name'] = $v->publicNumber->name;
           }
        }
        return $this->render('index', [
              'models' => $data,
              'pages' => $pages,
        ]);
    }

    //表单页
    public function actionForm() {
        $id = Yii::$app->request->get('id');
        $model = null;
        if (!empty($id))
            $model = $this->findModel($id);
        
        //查询出当前系统存在的公众号
        $publicNumbers = PublicNumber::find()
                           ->orderBy(['order_id' => SORT_DESC]) //倒序排列
                           ->asArray() //转换成数组
                           ->all();
        return $this->render('form', [
            'model' => $model,
            'public_numbers' => $publicNumbers
        ]);
    }

    //添加一个分组
    public function actionCreate() {
        $post = Yii::$app->request->post();
        //判断名称
        if (empty($post['name'])) {
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '分组名称']));
        }

        //所属公众号
        if (!intval($post['public_id'])) {
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '请选择所属公众号']));
        }

        //取出对应的公众号相关信息
       $publicNumber = PublicNumber::find()
                           ->where(['id' => intval($post['public_id'])])
                           ->asArray()
                           ->one();
       if (empty($publicNumber))
            throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '该公众号不存在']));

        //获取到该公众号appid以及appsecret以及token来实例化$wechat
        $wechat = Yii::createObject([
            'class' => 'weixin\components\WeChat',
            'options' => [
    	                      'token'         => $publicNumber['token'], //填写你设定的key
    	                      'appid'         => $publicNumber['appid'], //填写高级调用功能的app id
    	                      'appsecret'     => $publicNumber['appsecret'],  //填写高级调用功能的密钥
    	                      'encodingaeskey'=> $publicNumber['encoding_aes_key'], //填写加密用的EncodingAESKey
		                   ]
        ]);
        $ret = $wechat->createGroup($post['name']);
        if ($ret === false)
           throw new NotFoundHttpException(Yii::t('yii','创建分组失败'));
        $post['create_time'] = time();
        $post['update_time'] = time();
        $post['group_id'] = $ret['group']['id'];//这个需要到微信平台申请
        $model = new MembersGroup();
        if ($model->load(['MembersGroup' => $post]) && $model->save()) {
            $model->order_id = $model->id;
            $model->save();
            return $this->redirect(['members-group/form','id' => $model->id]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii','An internal server error occurred.'));
        }
    }

    //更新分组（只能更新本公众号内的名称）
    public function actionUpdate() {
        $id = Yii::$app->request->post('id',0);
        if (empty($id))
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => 'ID']));
        $post = Yii::$app->request->post();
        //判断名称
        if (empty($post['name'])) {
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '分组名称']));
        }
        
        //用户名处理一下
        $post['name'] = trim($post['name']);
        $model = $this->findModel($id);
        //如果用户真正更新用户名才会更新
        if ($model->name == trim($post['name']))
            return $this->redirect('index');
        
        //调用微信api更新name
       $publicNumber = PublicNumber::find()
                           ->where(['id' => intval($model->public_id)])
                           ->asArray()
                           ->one();
       if (empty($publicNumber))
            throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '该公众号不存在']));

        //获取到该公众号appid以及appsecret以及token来实例化$wechat
        $wechat = Yii::createObject([
            'class' => 'weixin\components\WeChat',
            'options' => [
    	                      'token'         => $publicNumber['token'], //填写你设定的key
    	                      'appid'         => $publicNumber['appid'], //填写高级调用功能的app id
    	                      'appsecret'     => $publicNumber['appsecret'],  //填写高级调用功能的密钥
    	                      'encodingaeskey'=> $publicNumber['encoding_aes_key'], //填写加密用的EncodingAESKey
		                   ]
        ]);
        
        //更新用户组名称
        $ret = $wechat->updateGroup($model->group_id,$post['name']);
        if ($ret === false)
            throw new NotFoundHttpException(Yii::t('yii','更新分组失败'));
  
        $post['update_time'] = time();
        unset($post['id']);
        if ($model->load(['MembersGroup' => $post]) && $model->save()) {
            return $this->redirect('index');
        } else {
            throw new NotFoundHttpException(Yii::t('yii','An internal server error occurred.'));
        }
    }

    //删除一条分组
    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        if (!intval($id))
           Error::output(Error::ERR_NOID);
        
        //首先获取该分组模型
        $model = $this->findModel($id);
        //调用微信api删除分组
        $publicNumber = PublicNumber::find()
                           ->where(['id' => intval($model->public_id)])
                           ->asArray()
                           ->one();
        if (empty($publicNumber))
            Error::output(Error::ERR_PUBLIC_NUMBER_NOT_EXIST);

        //获取到该公众号appid以及appsecret以及token来实例化$wechat
        $wechat = Yii::createObject([
            'class' => 'weixin\components\WeChat',
            'options' => [
    	                      'token'         => $publicNumber['token'], //填写你设定的key
    	                      'appid'         => $publicNumber['appid'], //填写高级调用功能的app id
    	                      'appsecret'     => $publicNumber['appsecret'],  //填写高级调用功能的密钥
    	                      'encodingaeskey'=> $publicNumber['encoding_aes_key'], //填写加密用的EncodingAESKey
		                   ]
        ]);
        $ret = $wechat->deleteGroup($model->group_id);
        if ($ret === false)
           //Error::output(Error::ERR_FAIL);删除这里有点特殊，微信接口返回的貌似有问题
        if ($model->delete()) {
           Error::output(Error::SUCCESS);
        }else{
           Error::output(Error::ERR_FAIL);
        }
    }

    //加载模型
    protected function findModel($id) {
        if (($model = MembersGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii','Page not found.'));
        }
    }
}
