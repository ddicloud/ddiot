<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model addons\diandi_cloud\models\CloudAuthAddons */

$this->title = '添加 Cloud Auth Addons';
$this->params['breadcrumbs'][] = ['label' => 'Cloud Auth Addons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="cloud-auth-addons-create">

                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</div>