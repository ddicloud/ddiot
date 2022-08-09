<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Searchs\DdAiFacesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dd-ai-faces-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ai_user_id') ?>

    <?= $form->field($model, 'ai_group_id') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
