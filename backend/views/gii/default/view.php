<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 21:55:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-25 00:41:17
 */
 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\gii\components\ActiveField;
use yii\gii\CodeFile;

/* @var $this yii\web\View */
/* @var $generator yii\gii\Generator */
/* @var $id string panel ID */
/* @var $form yii\widgets\ActiveForm */
/* @var $results string */
/* @var $hasError bool */
/* @var $files CodeFile[] */
/* @var $answers array */

$this->title = $generator->getName();
$templates = [];
foreach ($generator->templates as $name => $path) {
    $templates[$name] = "$name ($path)";
}
?>
<div class="firetech-main" >
        <h1><?= Html::encode($this->title) ?></h1>

        <p><?= $generator->getDescription() ?></p>

        <?php $form = ActiveForm::begin([
            'id' => "$id-generator",
            'successCssClass' => 'is-valid',
            'errorCssClass' => 'is-invalid',
            'validationStateOn' => ActiveForm::VALIDATION_STATE_ON_INPUT,
            'fieldConfig' => [
                'class' => ActiveField::className(),
                'hintOptions' => ['tag' => 'small', 'class' => 'form-text text-muted'],
                'errorOptions' => ['class' => 'invalid-feedback']
            ],
        ]); ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="form-fields">
                    <?= $this->renderFile($generator->formView(), [
                        'generator' => $generator,
                        'form' => $form,
                    ]) ?>
                    <?= $form->field($generator, 'template')
                        ->sticky()
                        ->hint('请选择应该使用哪组模板库生成代码。')
                        ->label('模板库')
                        ->dropDownList($templates) ?>
                    <div class="form-group">
                        <?= Html::submitButton('预览', ['name' => 'preview', 'class' => 'btn btn-primary']) ?>

                        <?php if (isset($files)): ?>
                            <?= Html::submitButton('生成', ['name' => 'generate', 'class' => 'btn btn-success']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php
            if (isset($results)) {
                echo $this->render('view/results', [
                    'generator' => $generator,
                    'results' => $results,
                    'hasError' => $hasError,
                ]);
            } elseif (isset($files)) {
                echo $this->render('view/files', [
                    'id' => $id,
                    'generator' => $generator,
                    'files' => $files,
                    'answers' => $answers,
                ]);
            }
            ?>
        <?php ActiveForm::end(); ?>
</div>
    
