<?php
namespace backend\controllers;

use Yii;
use common\models\PublicNumber;
use common\models\PublicNumberSearch;
use backend\base\BaseBackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

//公众号管理控制器
class PublicNumberController extends BaseBackController
{
    //操作类型控制
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    //显示列表
    public function actionIndex()
    {
        $query = PublicNumber::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 10]);
        $models = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
         return $this->render('index', [
              'models' => $models,
              'pages' => $pages,
         ]);
    }

    //表单页
    public function actionForm($id)
    {
        return $this->render('form', [
            'model' => $this->findModel($id),
        ]);
    }

    //添加一个公众号
    public function actionCreate()
    {
        $model = new PublicNumber();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['form', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    //更新公众号相关信息
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['form', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    //删除一条公众号
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    //加载模型
    protected function findModel($id)
    {
        if (($model = PublicNumber::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
