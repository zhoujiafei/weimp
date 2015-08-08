<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/bootstrap-responsive.min.css',
        'css/uniform.css',
        'css/unicorn.main.css',
        'css/unicorn.grey.css',
    ];
    public $js = [
        'js/excanvas.min.js',
        'js/jquery.min.js',
        'js/jquery.ui.custom.js',
        'js/bootstrap.min.js',
    ];
   
    public $jsOptions = ['position' => View::POS_HEAD];

     //定义按需加载JS方法，注意加载顺序在最后 
    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile,['depends' => AppAsset::className(),'position' => View::POS_HEAD]);
    }  

   //定义按需加载css方法，注意加载顺序在最后  
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile,['depends' => AppAsset::className()]);
    }
}