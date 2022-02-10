<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DdMemberAccount */

$this->title = 'Update Dd Member Account: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dd Member Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="dd-member-account-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>