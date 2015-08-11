<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Members';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="members-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Members', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'public_id',
            'openid',
            'nickname',
            'headimgurl:url',
            // 'sex',
            // 'city',
            // 'province',
            // 'country',
            // 'remark',
            // 'subscribe',
            // 'subscribe_time:datetime',
            // 'groupid',
            // 'unionid',
            // 'order_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
