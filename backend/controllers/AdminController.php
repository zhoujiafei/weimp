<?php
namespace backend\controllers;

use Yii;
use backend\base\BaseBackController;
use backend\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

//后台管理员相关操作的控制器
class AdminController extends BaseBackController
{
    //后台首页
    public function actionIndex()
    {
        return $this->render('index');
    }

    //登陆处理（如果登陆成功跳转到后台首页，没有登陆成功就处于登陆页面）
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    //退出登陆
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actions()
    {
       return [
           'upload' => [
               'class' => 'kucha\ueditor\UEditorAction',
               'config' => [
                   "imageUrlPrefix"  => "http://localhost/",//图片访问路径前缀
                   "imagePathFormat" => Yii::$app->params['upload_path'] . "ueditorimage/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
               ],
           ]
       ];
    }
}
