<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model admin\models\auth\AuthRoute */

$this->title = 'Update Auth Route: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id, 'name' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="auth-route-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>