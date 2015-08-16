<?php
namespace backend\controllers;

use Yii;
use backend\base\BaseBackPublicController;
use common\models\CustomMenus;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use backend\helpers\Error;
use yii\web\NotFoundHttpException;

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

    //首页列表（只列出一级菜单）
    public function actionIndex() {
        $fid = Yii::$app->request->get('fid',0);
        //如果存在父级菜单，查询出父级菜单的信息
        $parentMenu = [];
        if (!empty($fid)) {
           $parentMenu = CustomMenus::find()
                              ->where(['public_id' => $this->pid,'id' => intval($fid)])
                              ->asArray()
                              ->one();
           //如果不存在
           if (empty($parentMenu))
              throw new NotFoundHttpException(Yii::t('yii','父级菜单不存在'));
        }
        //查询出列表信息                   
        $models = CustomMenus::find()
                              ->where(['public_id' => $this->pid,'fid' => intval($fid)])
                              ->orderBy(['order_id' => SORT_ASC])
                              ->all();            
        $data = [];
        if (!empty($models)) {
           foreach($models AS $k => $v) {
               $data[$k] = $v->attributes;
               $data[$k]['parent'] = empty($v->parentMenu) ? '无' : $v->parentMenu->title;
               $data[$k]['level'] = intval($fid) == 0 ? '一级菜单' : '二级菜单';
           }
        }
        return $this->render('index', [
              'models' => $data,
              'parent_menu' => $parentMenu
        ]);
    }

    //表单页
    public function actionForm() {
        $fid = Yii::$app->request->get('fid',0);
        //如果存在父级菜单，查询出父级菜单的信息
        $parentMenu = [];
        if (!empty($fid)) {
           $parentMenu = CustomMenus::find()
                              ->where(['public_id' => $this->pid,'id' => intval($fid)])
                              ->asArray()
                              ->one();
           //如果不存在
           if (empty($parentMenu))
              throw new NotFoundHttpException(Yii::t('yii','父级菜单不存在'));
        }

        $id = Yii::$app->request->get('id');
        $model = [];
        if (!empty($id))
           $model = $this->findModel($id);

        return $this->render('form', [
            'model' => $model,
            'parent_menu' => $parentMenu
        ]);
    }

    //创建菜单
    public function actionCreate() {
        $post = Yii::$app->request->post();
        //判断名称
        if (empty($post['title'])) {
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '菜单名称']));
        }
        
        //获取传递过来的所属的父级ID
        $fid = !empty($post['fid']) ? intval($post['fid']) : 0;
        //获取最大允许的菜单数（自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单）
        $maxMenuNum = !empty($fid) ? 5 : 3;
        //获取当前fid下的菜单个数
        $menuNum = CustomMenus::find()
                        ->where(['public_id' => $this->pid,'fid' => intval($fid)])
                        ->count();
        if (intval($menuNum) >= $maxMenuNum)
           throw new NotFoundHttpException(Yii::t('yii','你创建的菜单在该级别菜单下已经达到上线，不能再创建'));
        //把当前的公众号ID加入进去
        $post['public_id'] = $this->pid;
        $post['create_time'] = time();
        $post['update_time'] = time();
        $model = new CustomMenus();
        if ($model->load(['CustomMenus' => $post]) && $model->save()) {
            $model->order_id = $model->id;
            $model->save();
            //跳到对应级别的菜单列表下
            return $this->redirect(['custom-menus/index','pid' => $this->pid,'fid' => $fid]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii','An internal server error occurred.'));
        }
    }

    //更新菜单
    public function actionUpdate() {
        $post = Yii::$app->request->post();
        $id = !empty($post['id']) ? intval($post['id']) : 0;
        $fid = !empty($post['fid']) ? intval($post['fid']) : 0;

        if (empty($id))
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => 'ID']));
        //判断名称
        if (empty($post['title'])) {
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '菜单名称']));
        }

        //用户名处理一下
        $post['title'] = trim($post['title']);
        $model = $this->findModel($id);
        $post['update_time'] = time();
        unset($post['id'],$post['fid']);
        if ($model->load(['CustomMenus' => $post]) && $model->save()) {
            return $this->redirect(['custom-menus/index','pid' => $this->pid,'fid' => $fid]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii','An internal server error occurred.'));
        }
    }

    //删除菜单
    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        if (!intval($id))
           Error::output(Error::ERR_NOID);
        
        //首先查看该菜单存不存在子级菜单，如果存在的话则不能删除，必须把子级删完之后才能删除
        $submenuNum = CustomMenus::find()
                        ->where(['public_id' => $this->pid,'fid' => intval($id)])
                        ->count();
        if (!empty($submenuNum))
           Error::output(Error::ERR_SUBMENUS_EXISTS_CAN_NOT_DEL);
        //首先获取该分组模型
        $model = $this->findModel($id);
        if ($model->delete()) {
           Error::output(Error::SUCCESS);
        }else{
           Error::output(Error::ERR_FAIL);
        }
    }
    
    //同步当前菜单到线上
    public function actionSyncMenus() {
      //首先查询出所有数据
      $menus = CustomMenus::find()
                     ->where(['public_id' => $this->pid])
                     ->orderBy(['order_id' => SORT_ASC])
                     ->asArray()
                     ->all();
      
      if (empty($menus))
         Error::output(Error::ERR_NO_MENUS);
      
      //构造菜单结构体
      $buttons = [];
      foreach ($menus AS $k => $v) {
         $item = ['name' => $v['title'],'type' => $v['type'],'key' => $v['keyword'],'url' => $v['url']];
         if (!empty($v['fid'])) {
            $buttons[$v['fid']]['sub_button'][] = $item;
         }else{
            $buttons[$v['id']] = $item;
         }
      }
      
      //对于一级菜单，如果存在子菜单，把不必要的参数去除掉
      foreach ($buttons AS $k => & $v) {
         if (array_key_exists('sub_button',$v) && !empty($v['sub_button']))
            unset($v['type'],$v['key'],$v['url']);
      }
      
      //提交到微信接口同步
      $ret = $this->wechat->createMenu(['button' => array_values($buttons)]);
      if ($ret === false)
         Error::output(Error::ERR_SYNC_MENUS_FAIL);
      Error::output(Error::SUCCESS);
    }

    //加载模型
    protected function findModel($id) {
        if (($model = CustomMenus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
