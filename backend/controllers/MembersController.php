<?php

namespace backend\controllers;

use Yii;
use common\models\Members;
use backend\base\BaseBackController;
use backend\helpers\Error;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * MembersController implements the CRUD actions for Members model.
 */
//用户管理控制器
class MembersController extends BaseBackController
{
    //显示列表
    public function actionIndex() {
        $query = Members::find();
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
               $data[$k]['public_number_name'] = $v->publicNumber->name;
               $data[$k]['subscribe_time_text'] = date('Y-m-d H:s',$v['subscribe_time']);
               $data[$k]['is_subscribe_text'] = $v['subscribe'] ? '是' : '否';
           }
        }
        return $this->render('index', [
              'models' => $data,
              'pages' => $pages,
        ]);
    }

    //查看用户详情
    public function actionForm() {
        $id = Yii::$app->request->get('id');
        $model = null;
        $cur_public = null;
        $member_group = null;
        if (!empty($id)) {
           $model = $this->findModel($id);
           $cur_public = $model->publicNumber->attributes;
           $member_group = $model->memberGroup->attributes;
        }
        return $this->render('form', [
            'model' => $model,
            'cur_public' => $cur_public,
            'member_group' => $member_group
        ]);
    }

    //加载模型
    protected function findModel($id) {
        if (($model = Members::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii','Page not found.'));
        }
    }
}
