<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\BeaStore */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Bea Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('_tab') ?>


<div class=" firetech-main">
    <div class="bea-store-view">

        <div class="panel panel-default">
            <div class="box-body">

                <p>
                    <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                    ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                            'id',
            'store_id',
            'bloc_id',
            'create_time',
            'update_time',
            'title',
            'store_code',
            'mobile',
            'staff_num',
            'sale_total',
            'fund_in_float',
            'cash_in',
            'service_charge',
            'is_cash',
            'is_trans',
            'thumb',
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>