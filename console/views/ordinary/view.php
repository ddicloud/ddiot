<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model addons\bea_cloud\models\BeaAcitvityOrdinary */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Bea Acitvity Ordinaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('_tab') ?>


<div class=" firetech-main">
    <div class="bea-acitvity-ordinary-view">

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
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>