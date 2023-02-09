<?php

use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel addons\bea_cloud\models\searchs\BeaBlocProduct */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bea Bloc Products';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>
                
<div class="firetech-main">

    <div class="bea-bloc-product-index ">
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
            //'thumb',
            //'thumbs:ntext',
            //'market_price',
            //'sale_price',
            //'is_time:datetime',
            //'time_num:datetime',
                    
                    ['class' => 'common\components\ActionColumn'],
                    ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>
</div>