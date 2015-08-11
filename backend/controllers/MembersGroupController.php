<?php
namespace backend\controllers;
use Yii;
use common\models\MembersGroup;
use common\helpers\Out;
use common\helpers\Common;
use backend\base\BaseBackController;
use backend\helpers\Error;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

//公众号管理控制器
class MembersGroupController extends BaseBackController
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

    //显示列表
    public function actionIndex() {
        $query = MembersGroup::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 20]);
        $models = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->orderBy(['order_id' => SORT_DESC]) //倒序排列
                        ->asArray() //转换成数组
                        ->all();
        if ($models) {
           foreach ($models AS $k => & $v) {
              $v['create_time'] = date('Y-m-d H:s',$v['create_time']);
           }  
        }
        return $this->render('index', [
              'models' => $models,
              'pages' => $pages,
        ]);
    }

    //表单页
    public function actionForm() {
        $id = Yii::$app->request->get('id');
        $model = null;
        if (!empty($id))
            $model = $this->findModel($id);
        return $this->render('form', [
            'model' => $model,
        ]);
    }

    //添加一个公众号
    public function actionCreate() {
        $post = Yii::$app->request->post();
        //判断名称
        if (empty($post['name'])) {
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '分组名称']));
        }
        $post['create_time'] = time();
        $post['update_time'] = time();
        $post['group_id'] = 123;//这个需要到微信平台申请
        $model = new MembersGroup();
        if ($model->load(['MembersGroup' => $post]) && $model->save()) {
            $model->order_id = $model->id;
            $model->save();
            return $this->redirect(['members-group/form','id' => $model->id]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii','An internal server error occurred.'));
        }
    }

    //更新公众号相关信息
    public function actionUpdate() {
        $id = Yii::$app->request->post('id',0);
        if (empty($id))
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => 'ID']));
        $post = Yii::$app->request->post();
        //判断名称
        if (empty($post['name'])) {
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '分组名称']));
        }

        $model = $this->findModel($id);
        $post['update_time'] = time();
        unset($post['id']);
        if ($model->load(['MembersGroup' => $post]) && $model->save()) {
            return $this->redirect('index');
        } else {
            throw new NotFoundHttpException(Yii::t('yii','An internal server error occurred.'));
        }
    }

    //删除一条公众号
    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        if (!intval($id))
           Error::output(Error::ERR_NOID);
        if ($this->findModel($id)->delete()) {
           Error::output(Error::SUCCESS);
        }else{
           Error::output(Error::ERR_FAIL);
        }
    }

    //加载模型
    protected function findModel($id) {
        if (($model = MembersGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii','Page not found.'));
        }
    }
}
