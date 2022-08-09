<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\searchs\DdAiMemberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dd-ai-member-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'face_group_id') ?>

    <?= $form->field($model, 'nickName') ?>

    <?= $form->field($model, 'face_image') ?>

    <?= $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'face_id') ?>

    <?php // echo $form->field($model, 'uid') ?>

    <?php // echo $form->field($model, 'face_token') ?>

    <?php // echo $form->field($model, 'wxapp_id') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'ai_age') ?>

    <?php // echo $form->field($model, 'ai_gender') ?>

    <?php // echo $form->field($model, 'ai_glasses') ?>

    <?php // echo $form->field($model, 'ai_race') ?>

    <?php // echo $form->field($model, 'ai_emotion') ?>

    <?php // echo $form->field($model, 'face_shape') ?>

    <?php // echo $form->field($model, 'ai_quality_blur') ?>

    <?php // echo $form->field($model, 'ai_quality_illumination') ?>

    <?php // echo $form->field($model, 'ai_quality_completeness') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
