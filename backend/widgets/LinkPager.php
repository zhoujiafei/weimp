<?php
namespace backend\widgets;

use Yii;
use yii\helpers\Html;

//自定义linkpager
class LinkPager extends \yii\widgets\LinkPager
{
    public $options = [];
    protected function renderPageButton($label, $page, $class, $disabled, $active) {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::a($label,'#'), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}