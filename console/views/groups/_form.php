<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\BeaAcitvityGroups */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="bea-acitvity-groups-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'bloc_id')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'displayorder')->textInput() ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>

    <?= $form->field($model, 'is_cash_audit')->textInput() ?>

    <?= $form->field($model, 'is_mark')->textInput() ?>

    <?= $form->field($model, 'is_music')->textInput() ?>

    <?= $form->field($model, 'stock')->textInput() ?>

    <?= $form->field($model, 'sale_limit')->textInput() ?>

    <?= $form->field($model, 'thumb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'index_thumb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'share_thumb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bg_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_limit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_virtual')->textInput() ?>

    <?= $form->field($model, 'is_award')->textInput() ?>

    <?= $form->field($model, 'award_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ladder1_num')->textInput() ?>

    <?= $form->field($model, 'ladder1_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ladder2_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ladder2_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ladder3_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ladder3_price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
