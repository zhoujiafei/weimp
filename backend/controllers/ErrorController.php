<?php
namespace backend\controllers;

use Yii;
use yii\base\Controller;

//报错控制器
class ErrorController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}