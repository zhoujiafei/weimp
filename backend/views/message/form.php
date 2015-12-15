<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'msg_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'public_id')->textInput() ?>

    <?= $form->field($model, 'msg_type')->textInput() ?>

    <?= $form->field($model, 'media_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb_media_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'voice_format')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pic_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location_x')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location_y')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'scale')->textInput() ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
