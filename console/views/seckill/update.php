<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\BeaAcitvitySeckill */

$this->title = 'Update Bea Acitvity Seckill: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Bea Acitvity Seckills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="bea-acitvity-seckill-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>