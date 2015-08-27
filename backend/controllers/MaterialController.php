<?php

namespace backend\controllers;

use Yii;
use common\models\Material;
use backend\base\BaseBackPublicController;
use backend\helpers\Error;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

//本地素材库
class MaterialController extends BaseBackPublicController
{
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

    //列表页显示
    public function actionIndex()
    {
        $query = Material::find()->where(['public_id' => $this->pid]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => 20]);
        $models = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->orderBy(['create_time' => SORT_DESC]) //倒序排列
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

    //表单页
    public function actionForm() {
        $id = Yii::$app->request->get('id');
        if (empty($id)) {
           throw new NotFoundHttpException(Yii::t('yii','请选择素材再查看详情'));
        }
        $model = $this->findModel($id);
        return $this->render('form', [
            'model' => $model,
        ]);
    }

    //删除素材
    public function actionDelete($id)
    {
        $id = Yii::$app->request->post('id');
        if (!intval($id))
           Error::output(Error::ERR_NOID);
        if ($model->delete()) {
           Error::output(Error::SUCCESS);
        }else{
           Error::output(Error::ERR_FAIL);
        }
    }

    //加载模型
    protected function findModel($id)
    {
        if (($model = Material::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
