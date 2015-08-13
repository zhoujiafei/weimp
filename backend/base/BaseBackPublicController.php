<?php 
namespace backend\base;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\PublicNumber;

class BaseBackPublicController extends BaseBackController
{
    public $layout = 'public';
    public $publicNumber = [];
    public $pid;
    public $menus = [];
    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            //获取到公众号的id;
            $id = Yii::$app->request->get('pid');
            if (empty($id))
                throw new NotFoundHttpException(Yii::t('yii','未选取公众号'));

            //查询公众号信息
            $publicNumber = $this->getPublicNumber($id);
            //判断公众号存不存在
            if (empty($publicNumber))
               throw new NotFoundHttpException(Yii::t('yii','该公众号不存在'));

            //保存该公众号信息
            $this->publicNumber = $publicNumber;
            $this->pid = $id;
            //获取菜单
            $this->menus = $this->getMenus($id);
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
}