<?php

namespace weixin\base;

use Yii;
use yii\web\Controller;
use weixin\helpers\Error;
use common\models\PublicNumber;

class BaseWeixinController extends Controller
{
    protected $wechat = null;
	public function beforeAction($action) {
	    if (parent::beforeAction($action)) {
    	      $this->initWeChat();
	          if (!empty($this->wechat)) {
	              return true;
	          }else{
	              return false;
	          }
	    }else{
	        return false;
	    }
	}

	//初始化wechat
	protected function initWeChat() {
	    //首先获取传过来的unique_id（用于本系统内唯一标识公众号）
        $unique_id = Yii::$app->request->get('unique_id');
        if (empty($unique_id))
            Error::output(Error::ERR_FIFA);

        //根据传过来unique_id定位是哪个公众号
        $publicNumber = PublicNumber::find()
                            ->where(['unique_id' => $unique_id])
                            ->asArray()
                            ->one();
        if (empty($publicNumber))
            Error::output(Error::ERR_FIFA);

        //获取到该公众号appid以及appsecret以及token来实例化$wechat
        $this->wechat = Yii::createObject([
            'class' => 'weixin\components\WeChat',
            'options' => [
    	                      'token'     => $publicNumber['token'], //填写你设定的key
    	                      'appid'     => $publicNumber['appid'], //填写高级调用功能的app id
    	                      'appsecret' => $publicNumber['appsecret']  //填写高级调用功能的密钥
		                 ]
        ]);
	}
}