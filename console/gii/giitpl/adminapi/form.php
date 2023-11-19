<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 22:07:59
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-05-26 14:05:56
 */

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\crud\Generator */
?>


<div class="box">
    <div class="box-body table-responsive">
        <div class="module-form">
            <?php
            echo $form->field($generator, 'moduleID');
            echo $form->field($generator, 'modelClass');
            echo $form->field($generator, 'searchModelClass');
            echo $form->field($generator, 'controllerClass');
            echo $form->field($generator, 'baseControllerClass');
            echo $form->field($generator, 'messageCategory');
            ?>
        </div>
    </div>
</div>