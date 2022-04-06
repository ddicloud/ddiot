<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 11:46:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-11 11:51:23
 */
 

use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Searchs\DdAiFacesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '人脸库人脸';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_tab') ?>

<div class="firetech-main">

<div class="dd-ai-faces-index ">
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
            'ai_user_id',
            'ai_group_id',
            'createtime',
            'updatetime',

            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>


</div>
    </div>
</div>
</div>