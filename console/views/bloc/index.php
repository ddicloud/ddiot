<?php

use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel addons\bea_cloud\models\searchs\BeaBloc */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bea Blocs';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>
                
<div class="firetech-main">

    <div class="bea-bloc-index ">
                                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">列表</h3>
            </div>
            <div class="box-body table-responsive">
                                    <?= MyGridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'filterModel' => $searchModel,
        'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                                'id',
            'store_id',
            'bloc_id',
            'create_time',
            'update_time',
            //'title',
            //'service_money',
            //'mobile',
            //'activity_num',
            //'sale_total',
            //'fund_in_float',
            //'cash_in',
            //'cash_total',
            //'cash_rate',
            //'order_rate',
            //'status',
            //'official_receipts',
            //'sharer_total',
            //'is_pledge',
            //'cash_pledge',
                    
                    ['class' => 'common\components\ActionColumn'],
                    ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>
</div>