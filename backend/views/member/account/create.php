<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DdMemberAccount */

$this->title = '添加 Dd Member Account';
$this->params['breadcrumbs'][] = ['label' => 'Dd Member Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="dd-member-account-create">

                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</div>