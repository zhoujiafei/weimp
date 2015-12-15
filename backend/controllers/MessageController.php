<?php

namespace backend\controllers;

use Yii;
use backend\base\BaseBackPublicController;
use common\models\Message;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use backend\helpers\Error;
use yii\web\NotFoundHttpException;

//消息控制器
class MessageController extends BaseBackPublicController
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

    //列表首页
    public function actionIndex() {
        $query = Message::find()->where(['public_id' => $this->pid]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 20]);
        $models = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->orderBy(['order_id' => SORT_DESC]) //倒序排列
                        ->all();
        $data = [];
        if (!empty($models)) {
           foreach($models AS $k => $v) {
               $data[$k] = $v->attributes;
               $data[$k]['create_time'] = date('Y-m-d H:s',$v['create_time']);
           }
        }
        return $this->render('index', [
              'models' => $data,
              'pages' => $pages,
        ]);
    }

    //消息表单页
    public function actionForm() {
        $id = Yii::$app->request->get('id');
        $model = null;
        if (empty($id)) {
           throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => 'ID']));
        }
        $model = $this->findModel($id);
        return $this->render('form', [
            'model' => $model,
        ]);
    }

    //删除消息
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    //加载模型
    protected function findModel($id) {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
