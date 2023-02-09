<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\BeaAcitvityGroups */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Bea Acitvity Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('_tab') ?>


<div class=" firetech-main">
    <div class="bea-acitvity-groups-view">

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
            'product_id',
            'displayorder',
            'start_time',
            'end_time',
            'is_cash_audit',
            'is_mark',
            'is_music',
            'stock',
            'sale_limit',
            'thumb',
            'index_thumb',
            'share_thumb',
            'title_color',
            'bg_color',
            'time_limit',
            'is_virtual',
            'is_award',
            'award_money',
            'ladder1_num',
            'ladder1_price',
            'ladder2_num',
            'ladder2_price',
            'ladder3_num',
            'ladder3_price',
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>