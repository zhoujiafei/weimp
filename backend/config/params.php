<?php
use yii\helpers\Url;
return [
    'adminEmail' => 'admin@example.com',
    'public_number_type' => [1 => '订阅号',2 => '服务号'],
    'encript_mode' => [1 => '明文模式',2 => '兼容模式',3 => '安全模式（推荐）'],
    'weixin_callback' => 'http://www.yourdomain.com/weixin',
    'admin_menus' => [
         ['name' => 'Dashboard','url'  => ['admin/index'],'mark' => 'admin'],
         ['name' => '系统设置','url' => '#','mark' => 'system_config','submenus' => [
               ['name' => '公众号设置','url' => ['public-number/index'],'mark' => 'public-number'],
         ]],
         
         /*
         ['name' => '菜单管理','url'  => ['menu/index'],'mark' => 'menu'],
         ['name' => '用户管理','url' => '#','mark' => 'members_manger','submenus' => [
               ['name' => '用户分组','url' => ['members-group/index'],'mark' => 'members-group'],
               ['name' => '用户信息','url' => ['members/index'],'mark' => 'members'],
         ]],
         ['name' => '素材管理','url' => '#','mark' => 'material','submenus' => [
               ['name' => '临时素材','url' => ['tmp-material/index'],'mark' => 'tmp-material'],
               ['name' => '永久素材','url' => ['forever-material/index'],'mark' => 'forever-material'],
         ]],
         ['name' => '消息管理','url'  => ['message/index'],'mark' => 'message'],
         ['name' => '客服管理','url'  => ['custom-service/index'],'mark' => 'custom-service'],
         ['name' => '微信小店','url'  => '#','mark' => 'shop'],
         ['name' => '微信卡券','url'  => '#','mark' => 'card'],
         ['name' => '智能服务','url'  => '#','mark' => 'intelligent-service'],
         ['name' => '摇一摇','url'  => '#','mark' => 'shake'],
         ['name' => '微信WIFI','url'  => '#','mark' => 'wifi'],
         */
     ],
     'public_menus' => [
         ['name' => '菜单管理','url'  => ['menu/index'],'mark' => 'menu'],
         ['name' => '用户管理','url' => '#','mark' => 'members_manger','submenus' => [
               ['name' => '用户分组','url' => ['members-group/index'],'mark' => 'members-group'],
               ['name' => '用户信息','url' => ['members/index'],'mark' => 'members'],
         ]],
         ['name' => '素材管理','url' => '#','mark' => 'material','submenus' => [
               ['name' => '临时素材','url' => ['tmp-material/index'],'mark' => 'tmp-material'],
               ['name' => '永久素材','url' => ['forever-material/index'],'mark' => 'forever-material'],
         ]],
         ['name' => '消息管理','url'  => ['message/index'],'mark' => 'message'],
         ['name' => '客服管理','url'  => ['custom-service/index'],'mark' => 'custom-service'],
         ['name' => '微信小店','url'  => '#','mark' => 'shop'],
         ['name' => '微信卡券','url'  => '#','mark' => 'card'],
         ['name' => '智能服务','url'  => '#','mark' => 'intelligent-service'],
         ['name' => '摇一摇','url'  => '#','mark' => 'shake'],
         ['name' => '微信WIFI','url'  => '#','mark' => 'wifi'],
     ]
];
