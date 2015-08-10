<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Members Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="members-group-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Members Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'group_id',
            'name',
            'count',
            'create_time:datetime',
            // 'update_time:datetime',
            // 'order_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
