<?php
namespace weixin\controllers;

use Yii;
use weixin\base\BaseWeixinController;

//微信回调控制器
class WeixinController extends BaseWeixinController
{
    public function actionIndex()
    {
        
        
       
        
        
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
