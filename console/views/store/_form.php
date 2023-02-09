<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\BeaStore */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="bea-store-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'bloc_id')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_num')->textInput() ?>

    <?= $form->field($model, 'sale_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fund_in_float')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cash_in')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_charge')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_cash')->textInput() ?>

    <?= $form->field($model, 'is_trans')->textInput() ?>

    <?= $form->field($model, 'thumb')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
