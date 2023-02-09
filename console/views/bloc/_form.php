<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\BeaBloc */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="bea-bloc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'bloc_id')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activity_num')->textInput() ?>

    <?= $form->field($model, 'sale_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fund_in_float')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cash_in')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cash_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cash_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'official_receipts')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sharer_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_pledge')->textInput() ?>

    <?= $form->field($model, 'cash_pledge')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
