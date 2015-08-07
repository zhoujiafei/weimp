<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

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
        'css/unicorn.main.css',
        'css/unicorn.grey.css',
        'css/uniform.css',
    ];
    public $js = [
        'js/excanvas.min.js',
        'js/jquery.min.js',
        'js/jquery.ui.custom.js',
        'js/bootstrap.min.js',
        'js/jquery.flot.min.js',
        'js/jquery.flot.resize.min.js',
        'js/jquery.peity.min.js',
        'js/unicorn.js',
        'js/unicorn.dashboard.js',
    ];
}