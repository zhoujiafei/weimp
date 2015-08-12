<?php
namespace backend\widgets;

use Yii;
use yii\base\Widget;

//自定义菜单组件，主要用于后台左侧菜单栏
class Menu extends Widget
{
    private $_active = null;
    private $_menus = [];
    public function run() {
        return $this->render('menu',[
                'active' => $this->getActive(),
                'menus' => $this->getMenus()
        ]);
    }

    //获取当前活动标签
    public function getActive() {
        return $this->_active == null ? 'home' : $this->_active;
    }

    //设置当前活动标签
    public function setActive($active = null) {
        $this->_active = $active;
    }
    
    //获取菜单
    public function getMenus() {
        return $this->_menus;
    }
    
    //设置菜单项
    public function setMenus($menus = []) {
        $this->_menus = $menus;
    }
}