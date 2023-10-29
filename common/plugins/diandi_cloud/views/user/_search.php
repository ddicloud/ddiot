<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model addons\diandi_cloud\models\searchs\CloudAuthUser */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="panel panel-info">
      <div class="panel-heading">
            <h3 class="panel-title">搜索</h3>
      </div>
      <div class="panel-body">
           
    

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    


<div class="cloud-auth-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
                            ]); ?>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?= $form->field($model, 'id') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?= $form->field($model, 'member_id') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?= $form->field($model, 'email') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?= $form->field($model, 'mobile') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?= $form->field($model, 'username') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'web_key') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'status') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'create_time') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'update_time') ?>

</div>


</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

</div>

  
    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
