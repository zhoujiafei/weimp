<?php
namespace weixin\controllers;

use Yii;
use weixin\base\BaseWeixinController;

class WeixinController extends BaseWeixinController
{

    public function actionIndex()
    {
        echo 1111;
    }
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
}
