<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 11:45:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-11 11:51:29
 */
 

use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Searchs\DdAiApplicationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '人脸库应用';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>

<div class="firetech-main">

<div class="dd-ai-applications-index ">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel panel-default">
        <div class="box-body">
    <?= MyGridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>"{items}\n{pager}",
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'name',
            'APP_ID',
            'create_time',
            // 'updatetime',
            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>
</div>
    </div>
</div>
</div>