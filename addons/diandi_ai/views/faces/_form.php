<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 11:47:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-11 11:47:49
 */
 
/*** 
 * @开源软件: 店滴AI-基于AI的软硬件开源解决方案
 * @官方地址: http://www.wayfirer.com/
 * @版本: 1.0
 * @邮箱: 2192138785@qq.com
 * @作者: Wang Chunsheng
 * @Date: 2020-02-28 22:38:38
 * @LastEditTime: 2020-04-25 02:45:22
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\DdAiFaces */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="dd-ai-faces-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
             <?= Html::buttonInput('选择用户', [
                    'id' => 'create',
                    'data-toggle' => 'modal',
                    'data-target' => '#users-modal',
                    'class' => 'btn btn-success',
            ]);
            ?>
        </div>
    </div>
    <?= $form->field($model, 'ai_user_id')->textInput(['readonly' => 'true']); ?>

    
    <?= $form->field($model, 'ai_group_id')->textInput(['readonly' => 'true']); ?>

    <?= $form->field($model, 'face_image')->widget('common\widgets\webuploader\FileInput', []); ?>

    

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
Modal::begin([
    'id' => 'users-modal',
    'header' => '<h4 class="modal-title">用户列表</h4>',
    'footer' => '<a href="#" class="btn btn-primary btn-close" data-dismiss="modal">关闭</a>',
]);

Modal::end();

?>
<?php JSRegister::begin([
    'key' => '3445',
]); ?>
<script>
    $(function(){
        $.get("<?= Url::toRoute('users'); ?>", {},
            function (data) {
                $('.modal-body').html(data);
            }  
        );
        function getUsers() {
            console.log('keys')
            var keys = $(this).data('user_id');
            console.log(keys)
        }
    })

</script>
<?php JSRegister::end(); ?>


