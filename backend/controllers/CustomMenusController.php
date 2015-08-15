<?php
namespace backend\controllers;

use Yii;
use backend\base\BaseBackPublicController;
use common\models\CustomMenus;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use backend\helpers\Error;

//自定义菜单控制器
class CustomMenusController extends BaseBackPublicController
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

    //首页列表
    public function actionIndex(){
        $query = CustomMenus::find()->where(['public_id' => $this->pid]);
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
               $data[$k]['parent'] = empty($v->parentMenu) ? '无' : $v->parentMenu->title;
               $data[$k]['level'] = intval($v['fid']) == 0 ? '一级菜单' : '二级菜单';
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
        $firstMenus = [];
        if (!empty($id))
           $model = $this->findModel($id);
        
        //取出所有一级菜单
        $firstMenus = CustomMenus::find()
                           ->where(['public_id' => $this->pid, 'fid' => 0])
                           ->asArray()
                           ->all();
        return $this->render('form', [
            'model' => $model,
            'first_menus' => $firstMenus
        ]);
    }

    //创建菜单
    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        //判断名称
        if (empty($post['title'])) {
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '菜单名称']));
        }
        //把当前的公众号ID加入进去
        $post['public_id'] = $this->pid;
        $post['create_time'] = time();
        $post['update_time'] = time();
        $model = new CustomMenus();
        if ($model->load(['CustomMenus' => $post]) && $model->save()) {
            $model->order_id = $model->id;
            $model->save();
            return $this->redirect(['custom-menus/index','pid' => $this->pid]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii','An internal server error occurred.'));
        }
    }

    //更新菜单
    public function actionUpdate()
    {
        $id = Yii::$app->request->post('id',0);
        if (empty($id))
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => 'ID']));
        $post = Yii::$app->request->post();
        //判断名称
        if (empty($post['title'])) {
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '菜单名称']));
        }

        //用户名处理一下
        $post['title'] = trim($post['title']);
        $model = $this->findModel($id);
        $post['update_time'] = time();
        unset($post['id']);
        if ($model->load(['CustomMenus' => $post]) && $model->save()) {
            return $this->redirect(['custom-menus/index','pid' => $this->pid]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii','An internal server error occurred.'));
        }
    }

    //删除菜单
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        if (!intval($id))
           Error::output(Error::ERR_NOID);
        //首先获取该分组模型
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
        if (($model = CustomMenus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
