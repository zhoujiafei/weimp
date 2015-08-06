<?php
namespace backend\widgets;

use Yii;
use yii\base\Widget;

//面包屑小部件
class Breadcrumb extends Widget
{
    private $_active = null;
    public function run() {
        return $this->render('breadcrumb',[
                'active' => $this->getActive(),
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
}