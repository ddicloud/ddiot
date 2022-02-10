<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-04 23:39:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-05 00:16:46
 */
 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DdMemberAccount */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="dd-member-account-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'member_id')->textInput() ?>


    <?= $form->field($model, 'user_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accumulate_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'give_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consume_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'frozen_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_integral')->textInput() ?>

    <?= $form->field($model, 'accumulate_integral')->textInput() ?>

    <?= $form->field($model, 'give_integral')->textInput() ?>

    <?= $form->field($model, 'consume_integral')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'frozen_integral')->textInput() ?>

    <?= $form->field($model, 'credit1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'credit2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'credit3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'credit4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'credit5')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
