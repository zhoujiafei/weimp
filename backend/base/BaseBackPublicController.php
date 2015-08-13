<?php 
namespace backend\base;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\PublicNumber;
use yii\helpers\ArrayHelper;

class BaseBackPublicController extends BaseBackController
{
    public $layout = 'public';
    public $publicNumber = [];
    public $pid;
    public $menus = [];
    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            //合并get与post
            $data = ArrayHelper::merge(Yii::$app->request->get(),Yii::$app->request->post());
            if (!isset($data['pid']) || empty($data['pid']))
                throw new NotFoundHttpException(Yii::t('yii','未选取公众号'));
            //查询公众号信息
            $publicNumber = $this->getPublicNumber($data['pid']);
            //判断公众号存不存在
            if (empty($publicNumber))
               throw new NotFoundHttpException(Yii::t('yii','该公众号不存在'));

            //获取菜单
            $this->menus = $this->getMenus($data['pid']);
            //保存该公众号信息
            $this->publicNumber = $publicNumber;
            $this->pid = $data['pid'];
            return true;
        }else{
            return false;
        }
    }

    //获取菜单
    private function getMenus($pid) {
       //如果开启了缓存，先从缓存取菜单
       $menus = [];
       if (Yii::$app->params['enable_cache'])
            $menus = Yii::$app->cache->get('public_menus_' . $pid);

       if (empty($menus)) {
          //不存在就重新去构造
          $menus = Yii::$app->params['public_menus'];
          foreach ($menus AS $k => &$v) {
             if (array_key_exists('submenus',$v)) {
                foreach ($v['submenus'] AS $kk => &$vv) {
                   if (is_array($vv['url']))
                      $vv['url']['pid'] = $pid;
                }
             }elseif (is_array($v['url'])){
                $v['url']['pid'] = $pid;
             }
          }
          //之后缓存起来（过期时间为一天）
          Yii::$app->cache->set('public_menus_' . $pid,json_encode($menus),3600 * 24);
       }else{
          $menus = json_decode($menus,1);
       }
       return $menus;
    }
    
    //获取
    private function getPublicNumber($pid) {
       //如果开启了缓存，先从缓存取
       $publicNumber = [];
       if (Yii::$app->params['enable_cache'])
          $publicNumber = Yii::$app->cache->get('public_number_' . $pid);

       if (empty($publicNumber)) {
          $publicNumber = PublicNumber::find()
                                ->where(['id' => $pid])
                                ->asArray()
                                ->one();
          if (empty($publicNumber))
               return [];
          //之后缓存起来（过期时间为一天）
          Yii::$app->cache->set('public_number_' . $pid,json_encode($publicNumber),3600 * 24);
       }else{
          $publicNumber = json_decode($publicNumber,1);
       }
       return $publicNumber;
    }
    
    //获取当前公众号下的weChat微信操作对象
    public function getWeChat() {
       if (!empty($this->publicNumber)) {
          return Yii::createObject([
                        'class' => 'weixin\components\WeChat',
                        'options' => [
                	                      'token'         => $this->publicNumber['token'], //填写你设定的key
                	                      'appid'         => $this->publicNumber['appid'], //填写高级调用功能的app id
                	                      'appsecret'     => $this->publicNumber['appsecret'],  //填写高级调用功能的密钥
                	                      'encodingaeskey'=> $this->publicNumber['encoding_aes_key'], //填写加密用的EncodingAESKey
            		                   ]
           ]);
       }
       throw new NotFoundHttpException(Yii::t('yii','未选取公众号1111'));
    }
}