<?php
use yii\helpers\Url;
return [
    'adminEmail' => 'admin@example.com',
    'public_number_type' => [1 => '订阅号',2 => '服务号'],
    'encript_mode' => [1 => '明文模式',2 => '兼容模式',3 => '安全模式（推荐）'],
    'weixin_callback' => 'http://www.yourdomain.com/weixin',
    'upload_path' => 'weimp/upload/',//图片上传之后保存目录(这个是以web根目录的为基准的)
    'upload_url' => 'http://localhost/weimp/upload/',//上传目录对应的基准URL
    'enable_cache' => 0,
    'admin_menus' => [
         ['name' => 'Dashboard','url'  => ['admin/index'],'mark' => 'admin','icon' => 'icon-home'],
         ['name' => '公众号管理','url' => ['public-number/index'],'mark' => 'public-number','icon' => 'icon-comment'],
     ],
    'public_menus' => [
         ['name' => 'Dashboard','url'  => ['public-admin/index'],'mark' => 'public-admin','icon' => 'icon-home'],
         ['name' => '菜单管理','url'  => ['custom-menus/index'],'mark' => 'custom-menus','icon' => 'icon-th-list'],
         ['name' => '消息管理','url'  => '#','mark' => 'message','icon' => 'icon-envelope','submenus' => [
               ['name' => '接收消息','url' => ['message-accept/index'],'mark' => 'message-accept'],
               ['name' => '发送消息','url' => ['message-send/index'],'mark' => 'message-send'],
         ]],
         ['name' => '用户管理','url' => '#','mark' => 'members_manger','icon' => 'icon-user','submenus' => [
               ['name' => '用户分组','url' => ['members-group/index'],'mark' => 'members-group'],
               ['name' => '用户信息','url' => ['members/index'],'mark' => 'members'],
         ]],
         ['name' => '素材管理','url' => '#','mark' => 'material','icon' => 'icon-file','submenus' => [
               ['name' => '临时素材','url' => ['tmp-material/index'],'mark' => 'tmp-material'],
               ['name' => '永久素材','url' => ['forever-material/index'],'mark' => 'forever-material'],
         ]],

         /*
         ['name' => '客服管理','url'  => ['custom-service/index'],'mark' => 'custom-service'],
         ['name' => '微信小店','url'  => '#','mark' => 'shop'],
         ['name' => '微信卡券','url'  => '#','mark' => 'card'],
         ['name' => '智能服务','url'  => '#','mark' => 'intelligent-service'],
         ['name' => '摇一摇','url'  => '#','mark' => 'shake'],
         ['name' => '微信WIFI','url'  => '#','mark' => 'wifi'],
         */
     ]
];
