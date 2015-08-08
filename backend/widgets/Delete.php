<?php
namespace backend\widgets;

use Yii;
use yii\base\Widget;

//自定义删除某一条记录的时候的小部件
class Delete extends Widget
{
    public function run() {
        return $this->render('delete');
    }
}