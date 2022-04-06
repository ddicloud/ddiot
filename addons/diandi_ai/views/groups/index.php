<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 11:48:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-11 11:51:11
 */
 

use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Searchs\DdAiGroupsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '人脸库分组';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_tab') ?>

<div class="firetech-main">

<div class="dd-ai-groups-index ">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel panel-default">
        <div class="box-body">
    <?= MyGridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>"{items}\n{pager}",
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ai_group_status'=>[
                'attribute'=>'ai_group_status',
                'format' => ['raw'],
                'value' => function($model){
                        $ai_group_status = $model->ai_group_status;
                        // return $ai_group_status;
                        return Yii::$app->params['aierror'][$ai_group_status];
                    }
            ],
            'name',
            'is_default'=>[
                'attribute'=>'is_default',
                'format' => ['raw'],
                'value' => function($model){
                        $is_default = $model->is_default;
                        return $is_default==1?'默认用户组':'非默认';
                    }
            ],
            'createtime:datetime',
            'updatetime:datetime',

            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>


</div>
    </div>
</div>
</div>