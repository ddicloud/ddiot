<?php

use yii\helpers\Html;
use common\widgets\MyActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DdAiApplications */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="dd-ai-applications-form">

    <?php $form = MyActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'APP_ID')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'API_KEY')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'SECRET_KEY')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php MyActiveForm::end(); ?>

</div>
