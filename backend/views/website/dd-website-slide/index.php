<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-29 00:26:36
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-25 00:39:29
 */

use common\helpers\ImageHelper;
use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\DdWebsiteSlideSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '幻灯片管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_tab') ?>

<div class="firetech-main">

    <div class="dd-website-slide-index ">
        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>
        <div class="panel panel-default">
            <div class="box-body">
                <?= MyGridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        // 'id',
                        'images' => [
                            'attribute' => 'images',
                            'format' => ['raw'],
                            'value' => function ($model) {
                                return Html::img(ImageHelper::tomedia($model->images), ['height' => 50, 'width' => 'auto']);
                            }
                        ],
                        'title',
                        'description',
                        'menuname',
                        //'menuurl',
                        //'createtime',
                        //'updatetime',

                        ['class' => 'common\components\ActionColumn'],
                    ],
                ]); ?>


            </div>
        </div>
    </div>
</div>