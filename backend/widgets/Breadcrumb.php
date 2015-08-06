<?php
namespace backend\widgets;

use Yii;
use yii\base\Widget;

//面包屑小部件
class Breadcrumb extends Widget
{
    private $_nav = [];
    public function run() {
        return $this->render('breadcrumb',[
                'nav' => $this->getNav(),
        ]);
    }

    //获取当前活动标签
    public function getNav() {
        return $this->_nav;
    }

    //设置当前活动标签
    public function setNav($nav = []) {
        $this->_nav = $nav;
    }
}