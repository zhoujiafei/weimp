<?php
namespace backend\controllers;

use Yii;
use backend\base\BaseBackPublicController;
use common\models\CustomMenus;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

//自定义菜单控制器
class CustomMenusController extends BaseBackPublicController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    //首页列表
    public function actionIndex()
    { 
        return $this->render('index');
    }

    //创建菜单
    public function actionCreate()
    {
        
    }

    //更新菜单
    public function actionUpdate($id)
    {
        
    }

    //删除菜单
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
