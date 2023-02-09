<?php

use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel addons\bea_cloud\models\searchs\BeaAcitvityGroups */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bea Acitvity Groups';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>
                
<div class="firetech-main">

    <div class="bea-acitvity-groups-index ">
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
            //'product_id',
            //'displayorder',
            //'start_time',
            //'end_time',
            //'is_cash_audit',
            //'is_mark',
            //'is_music',
            //'stock',
            //'sale_limit',
            //'thumb',
            //'index_thumb',
            //'share_thumb',
            //'title_color',
            //'bg_color',
            //'time_limit',
            //'is_virtual',
            //'is_award',
            //'award_money',
            //'ladder1_num',
            //'ladder1_price',
            //'ladder2_num',
            //'ladder2_price',
            //'ladder3_num',
            //'ladder3_price',
                    
                    ['class' => 'common\components\ActionColumn'],
                    ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>
</div>