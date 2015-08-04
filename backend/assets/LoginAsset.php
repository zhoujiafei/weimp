<?php

namespace backend\assets;

use yii\web\AssetBundle;

//登陆用到的资源包
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap-responsive.min.css',
        'css/unicorn.login.css',
    ];
    public $js = [
        'js/unicorn.login.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
