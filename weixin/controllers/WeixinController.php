<?php
namespace weixin\controllers;

use Yii;
use weixin\base\BaseWeixinController;
use weixin\helpers\Error;
use common\models\PublicNumber;

//微信回调控制器
class WeixinController extends BaseWeixinController
{
    public function actionIndex()
    {
        $this->wechat->valid();
        
        
        
            
        
        
        
        
        
        
        
        
        
        
        
        
       
        
        
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
