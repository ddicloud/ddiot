<?php

use yii\helpers\Html;
use common\widgets\MyActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DdAiGroups */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="dd-ai-groups-form">

    <?php $form = MyActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_default')->radioList([
        '0' => '非默认',
        '1' => '默认用户组',
    ], ['style' => 'padding-top:7px;']) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php MyActiveForm::end(); ?>

</div>
