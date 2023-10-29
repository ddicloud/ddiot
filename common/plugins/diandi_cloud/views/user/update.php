<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model addons\diandi_cloud\models\CloudAuthUser */

$this->title = 'Update Cloud Auth User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cloud Auth Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="cloud-auth-user-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>