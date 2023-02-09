<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\BeaBloc */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Bea Blocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('_tab') ?>


<div class=" firetech-main">
    <div class="bea-bloc-view">

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
            'service_money',
            'mobile',
            'activity_num',
            'sale_total',
            'fund_in_float',
            'cash_in',
            'cash_total',
            'cash_rate',
            'order_rate',
            'status',
            'official_receipts',
            'sharer_total',
            'is_pledge',
            'cash_pledge',
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>