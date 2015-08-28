<?php

namespace backend\controllers;

use Yii;
use common\models\ForeverMaterial;
use common\models\Material;
use backend\base\BaseBackPublicController;
use backend\helpers\Error;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

//永久素材控制器
class ForeverMaterialController extends BaseBackPublicController
{
    private $forevelMaterialTypes = ['image','voice','video','thumb'];
    private $forevelMaterialSizes = ['image' => 1048576,'voice' => 2097152,'video' => 10485760,'thumb' => 65536];
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

    //永久素材列表页
    public function actionIndex()
    {
        $query = ForeverMaterial::find()->where(['public_id' => $this->pid]);
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
            'material_types' => $this->forevelMaterialTypes
        ]);
    }

    //创建永久素材
    public function actionCreate()
    {
        $type = Yii::$app->request->post('type',null);
        if (empty($type) || !in_array($type,$this->forevelMaterialTypes))
           throw new NotFoundHttpException(Yii::t('yii','素材类型有误，请在 [' .implode(',',$this->forevelMaterialTypes). '] 中选取一种'));
        
        $name = Yii::$app->request->post('name',null);
        if (empty($name))
           throw new NotFoundHttpException(Yii::t('yii','素材名称不能为空'));
        
        //获取POST数据
        $post = Yii::$app->request->post();
        $ret = $this->upload($post);
        $post['media_id'] = $ret['media_id'];//保存微信API返回的素材ID
        $post['public_id'] = $this->pid;
        $post['material_id'] = $ret['material_id'];      
        $post['create_time'] = $ret['created_at'];
        $model = new ForeverMaterial();
        if ($model->load(['ForeverMaterial' => $post]) && $model->save()) {
            $model->order_id = $model->id;
            $model->save();
            return $this->redirect(['forevel-material/index','pid' => $this->pid]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii','An internal server error occurred.'));
        }
    }

    //执行上传
    private function upload($post = []) {
        if (empty($post) || empty($_FILES['FileData']))
            throw new NotFoundHttpException(Yii::t('yii','没有上传文件'));
        //实例化上传组件
        $uploader = Yii::createObject([
                'class' => 'common\components\Uploader',
                'savePath' => '@upload/' .$post['type']. '/',
                'allowExts' => $this->allowTypes[$post['type']],//暂时用扩展来判断类型
                'maxSize' => $this->forevelMaterialSizes[$post['type']],
        ]);
        //执行上传
        $ret = $uploader->upload($_FILES['FileData']);
        if ($ret === false)
            throw new NotFoundHttpException(Yii::t('yii',$uploader->errorMsg));
        //用返回的信息拼接图片路径，将图片上传到微信
        $filePath = $uploader->uploadFileInfo['savepath'] . $uploader->uploadFileInfo['savename'];
        if (class_exists('\CURLFile')) {
           $data = ['media' => new \CURLFile($filePath)];
        }else{
           $data = ['media' => '@' . $filePath];
        }
        $uploadRet = $this->wechat->uploadMedia($data,$post['type']);
        if ($uploadRet == false || empty($uploadRet))
            throw new NotFoundHttpException(Yii::t('yii','上传素材到微信失败'));
            
        //将素材信息保存到数据库，以方便展示
        $model = new Material;
        $model->public_id = $this->pid;
        $model->name = $_FILES['FileData']['name'];//原始文件名
        $model->filepath = $post['type'] . '/' . $uploader->uploadFileInfo['secondfilePath'];
        $model->filename = $uploader->uploadFileInfo['savename'];
        $model->type = $post['type'];
        //获取图片大小
        if ($post['type'] == 'image' || $post['type'] == 'thumb') {
            $picSize = getimagesize($filePath);
            $model->imgwidth = $picSize[0];
            $model->imgheight = $picSize[1];
        }
        $model->filesize = $_FILES['FileData']['size'];
        $model->create_time = time();
        $material_id = 0;
        if ($model->save())
            $material_id = $model->id;
        $uploadRet['material_id'] = $material_id; 
        return $uploadRet;
    }

    //删除素材
    public function actionDelete($id)
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
        if (($model = ForeverMaterial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
