<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 18:19:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-26 18:26:14
 */

 
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $generators \yii\gii\Generator[] */
/* @var $content string */

$generators = Yii::$app->controller->module->generators;
$this->title = '开发者助手';
?>
<div class="default-index">
    <h1 class="border-bottom pb-3 mb-3">店滴云CMS <small class="text-muted">诚邀优秀php开发者</small></h1>

    <p class="lead mb-5">免费的多商户业务引擎</p>

    <div class="row">
        <?php foreach ($generators as $id => $generator): ?>
        <div class="generator col-lg-4">
            <h3><?= Html::encode($generator->getName()) ?></h3>
            <p style="min-height: 50px;"><?= $generator->getDescription() ?></p>
            <p><?= Html::a('创建代码', ['default/view', 'id' => $id], ['class' => ['btn', 'btn-outline-secondary']]) ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <p><a class="btn btn-success" href="http://doc.hopesfire.com/">官方开发文档</a></p>

</div>