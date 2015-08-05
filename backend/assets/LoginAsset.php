<?php

namespace backend\assets;

use yii\web\AssetBundle;

//登陆用到的资源包
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/bootstrap-responsive.min.css',
        'css/unicorn.login.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/unicorn.login.js',
    ];
}
