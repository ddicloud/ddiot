<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\BeaStore */

$this->title = '添加 Bea Store';
$this->params['breadcrumbs'][] = ['label' => 'Bea Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="bea-store-create">

                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</div>