<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-02 01:03:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-24 16:34:36
 */

use common\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DdMember */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="dd-member-form">

    <?php $form = ActiveForm::begin(); ?>
    

    <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">会员信息</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'nickName')->textInput(['maxlength' => true]) ?>
                  <?= $form->field($model, 'avatarUrl')->widget('common\widgets\webuploader\FileInput', [
                        'options' => [
                        'field' => 'avatarUrl'
                        ]
                  ]); ?>
                <?= $form->field($model, 'realname')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>
            </div>
    </div>
          

    <div class="box box-solid">
          <div class="box-header with-border">
                <h3 class="box-title">基本信息</h3>
          </div>
          <div class="box-body">
                              
                <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map($group,'group_id','item_name')) ?>

                <?= $form->field($model, 'level')->textInput() ?>

                <?= $form->field($model, 'openid')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'store_id')->textInput() ?>

                <?= $form->field($model, 'bloc_id')->textInput() ?>

                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                
                <?= $form->field($model, 'gender')->textInput() ?>

                <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>


                <?= $form->field($model, 'status')->textInput() ?>
          </div>
    </div>

    <div class="box box-solid">
          <div class="box-header with-border">
                <h3 class="box-title">联系方式</h3>
          </div>
          <div class="box-body">
                <?= $form->field($model, 'mobile')->textInput() ?>
                <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'msn')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
                
          </div>
    </div>

    <div class="box box-solid">
          <div class="box-header with-border">
                <h3 class="box-title">工作情况</h3>
          </div>
          <div class="box-body">
                <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'education')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'occupation')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'revenue')->textInput(['maxlength' => true]) ?>
          </div>
    </div>

    <div class="box box-solid">
          <div class="box-header with-border">
                <h3 class="box-title">教育情况</h3>
          </div>
          <div class="box-body">
                <?= $form->field($model, 'studentid')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'graduateschool')->textInput(['maxlength' => true]) ?>

          </div>
    </div>
    
  
    <div class="box box-solid">
          <div class="box-header with-border">
                <h3 class="box-title">自我介绍</h3>
          </div>
          <div class="box-body">
                <?= $form->field($model, 'address_id')->textInput() ?>

                <?= $form->field($model, 'vip')->textInput(['maxlength' => true]) ?>
                
                         
                <?= $form->field($model, 'birthyear')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'constellation')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'zodiac')->textInput(['maxlength' => true]) ?>


                <?= $form->field($model, 'idcard')->textInput(['maxlength' => true]) ?>



                <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'nationality')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'resideprovince')->textInput(['maxlength' => true]) ?>




                <?= $form->field($model, 'affectivestatus')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'lookingfor')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'bloodtype')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'alipay')->textInput(['maxlength' => true]) ?>



                <?= $form->field($model, 'taobao')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'bio')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'interest')->textInput(['maxlength' => true]) ?>
                
          </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
