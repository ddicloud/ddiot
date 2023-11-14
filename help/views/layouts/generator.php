<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-26 17:47:35
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-28 16:53:35
 */

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $generators \yii\gii\Generator[] */
/* @var $activeGenerator \yii\gii\Generator */
/* @var $content string */

$generators = Yii::$app->controller->module->generators;
$activeGenerator = Yii::$app->controller->generator;
?>
<?php $this->beginContent('@admin/views/gii/layouts/main.php'); ?>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <div class="list-group">
            <?php
            $classes = ['list-group-item', 'd-flex', 'justify-content-between', 'align-items-center'];
            foreach ($generators as $id => $generator) {
                $label = Html::tag('span', Html::encode($generator->getName())) . '<span class="icon"></span>';
                echo Html::a($label, ['default/view', 'id' => $id], [
                    'class' => $generator === $activeGenerator ? array_merge($classes, ['active']) : $classes,
                ]);
            }
            ?>
        </div>
    </div>
    <div class="col-md-9 col-sm-8">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>
