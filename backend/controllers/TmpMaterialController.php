<?php

namespace backend\controllers;

use Yii;
use common\models\TmpMaterial;
use backend\base\BaseBackPublicController;
use backend\helpers\Error;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/* 临时素材管理控制器
 * 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
 * 图片（image）: 1M，支持JPG格式
 * 语音（voice）：2M，播放长度不超过60s，支持AMR\MP3格式
 * 视频（video）：10MB，支持MP4格式
 * 缩略图（thumb）：64KB，支持JPG格式
 */
class TmpMaterialController extends BaseBackPublicController
{
    private $tmpMaterialTypes = ['image','voice','video','thumb'];
    private $tmpMaterialSizes = ['image' => 1024,'voice' => 2048,'video' => 10240,'thumb' => 64];
    private $allowTypes = ['image' => ['jpg','jpeg'],'voice' => ['amr','mp3'],'video' => ['mp4'],'thumb' => ['jpeg','jpg']];
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'create' => ['post'],
                ],
            ],
        ];
    }

    //列表页
    public function actionIndex()
    {
        $query = TmpMaterial::find()->where(['public_id' => $this->pid]);
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
        if (!empty($id)) {
           $model = $this->findModel($id);
        }
        return $this->render('form', [
            'model' => $model,
            'material_types' => $this->tmpMaterialTypes
        ]);
    }

    //新增一个临时素材
    public function actionCreate() {
        $type = Yii::$app->request->post('type',null);
        if (empty($type) || !in_array($type,$this->tmpMaterialTypes))
           throw new NotFoundHttpException(Yii::t('yii','素材类型有误，请在 [' .implode(',',$this->tmpMaterialTypes). '] 中选取一种'));
        
        $name = Yii::$app->request->post('name',null);
        if (empty($name))
           throw new NotFoundHttpException(Yii::t('yii','素材名称不能为空'));
        
        //获取POST数据
        $post = Yii::$app->request->post();
        $ret = $this->upload($post);
        if ($ret === false)
           throw new NotFoundHttpException(Yii::t('yii','创建临时素材失败'));

        $post['media_id'] = $ret['media_id'];//保存微信API返回的素材ID
        $post['public_id'] = $this->pid;
        $post['create_time'] = time();
        $model = new TmpMaterial();
        if ($model->load(['TmpMaterial' => $post]) && $model->save()) {
            $model->order_id = $model->id;
            $model->save();
            return $this->redirect(['tmp-material/index','pid' => $this->pid]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii','An internal server error occurred.'));
        }
    }

    //执行上传
    private function upload($post = []) {
        if (empty($post) || empty($_FILES['FileData']))
            return false;
        //实例化上传组件
        $uploader = Yii::createObject([
                'class' => 'common\components\Uploader',
                'savePath' => '@upload/' .$post['type']. '/',
                'allowExts' => $this->allowTypes[$post['type']],//暂时用扩展来判断类型
        ]);
        //执行上传
        $ret = $uploader->upload($_FILES['FileData']);
        if ($ret === false) {
            return false;
        }
        //用返回的信息拼接图片路径，将图片上传到
        
           
        
        
        return ['media_id' => 'zhouxingxing'];
    }

    //删除临时素材（此处提供的删除只是软删除，只是把数据库保存的关联记录删除掉，实际上每个临时素材最多在微信服务器上保存3天时间，自动会被删除）
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        if (!intval($id))
           Error::output(Error::ERR_NOID);
        //首先获取该临时素材模型
        $model = $this->findModel($id);
        if ($model->delete()) {
           Error::output(Error::SUCCESS);
        }else{
           Error::output(Error::ERR_FAIL);
        }
    }

    //加载模型
    protected function findModel($id)
    {
        if (($model = TmpMaterial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
