<?php
namespace backend\controllers;

use Yii;
use backend\base\BaseBackPublicController;

//针对某一个公众号后台管理首页
class PublicAdminController extends BaseBackPublicController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
