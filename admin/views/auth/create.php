<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model admin\models\auth\AuthRoute */

$this->title = '添加 Auth Route';
$this->params['breadcrumbs'][] = ['label' => 'Auth Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="auth-route-create">

                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</div>