<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 11:50:09
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-11 11:50:19
 */
 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\DdAiMember */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="dd-ai-member-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'face_group_id')->dropDownList(ArrayHelper::map($ai_groups, 'id', 'name'),[
         'prompt'=>[
            'options' => ['value' => 'none', 'class' => 'prompt', 'label' => '选择用户组']
        ],
    ]) ?>

    <?= $form->field($model, 'nickName')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'face_image')->widget('common\widgets\webuploader\FileInput', []); ?>


    <?= $form->field($model, 'gender')->radioList(['male'=>'男性','female'=>'女性']) ?>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
