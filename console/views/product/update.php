<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\BeaBlocProduct */

$this->title = 'Update Bea Bloc Product: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Bea Bloc Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="bea-bloc-product-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>