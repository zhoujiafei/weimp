<?php 
namespace backend\base;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\PublicNumber;

class BaseBackPublicController extends BaseBackController
{
    public $layout = 'public';
    public $publicNumber = [];
    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            
            //获取到公众号的unique_id;
            $unique_id = Yii::$app->request->get('unique_id');
            if (empty($unique_id))
                throw new NotFoundHttpException(Yii::t('yii','Missing required parameters: {params}',['params' => '公众号标识']));

            //查询公众号信息
            $publicNumber = PublicNumber::find()
                                ->where(['unique_id' => $unique_id])
                                ->asArray()
                                ->one();
             //判断公众号存不存在            
             if (empty($publicNumber))
                 throw new NotFoundHttpException(Yii::t('yii','该公众号不存在'));
             
             //保存该公众号信息
             $this->publicNumber = $publicNumber;
             return true;
        }else{
            return false;
        }
    }   
}


