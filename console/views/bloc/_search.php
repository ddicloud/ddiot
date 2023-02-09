<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\searchs\BeaBloc */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="panel panel-info">
      <div class="panel-heading">
            <h3 class="panel-title">搜索</h3>
      </div>
      <div class="panel-body">
           
    

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    


<div class="bea-bloc-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
                            ]); ?>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?= $form->field($model, 'id') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?= $form->field($model, 'store_id') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?= $form->field($model, 'bloc_id') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?= $form->field($model, 'create_time') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?= $form->field($model, 'update_time') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'title') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'service_money') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'mobile') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'activity_num') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'sale_total') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'fund_in_float') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'cash_in') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'cash_total') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'cash_rate') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'order_rate') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'status') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'official_receipts') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'sharer_total') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'is_pledge') ?>

</div>

<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>

    <?php // echo $form->field($model, 'cash_pledge') ?>

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
