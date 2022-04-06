<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 11:49:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-11 12:12:11
 */

use common\helpers\ImageHelper;
use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\DdAiMemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_tab') ?>

<div class="firetech-main">

    <div class="dd-ai-member-index ">
        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>
        <div class="panel panel-default">
            <div class="box-body">
                <?= MyGridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'user_id',
                        'face_group_id',
                        'nickName',
                        'gender',
                        'face_image' => [
                            'attribute' => 'face_image',
                            'format' => ['raw'],
                            'value' => function ($model) {
                                return Html::img(ImageHelper::tomedia($model->face_image), ['height' => 50, 'width' => 'auto']);
                            }
                        ],
                        //'face_id',
                        //'uid',
                        //'face_token',
                        //'wxapp_id',
                        //'create_time:datetime',
                        //'update_time:datetime',
                        //'ai_age',
                        //'ai_gender',
                        //'ai_glasses',
                        //'ai_race',
                        //'ai_emotion',
                        //'face_shape',
                        //'ai_quality_blur',
                        //'ai_quality_illumination',
                        //'ai_quality_completeness',

                        ['class' => 'common\components\ActionColumn'],
                    ],
                ]); ?>


            </div>
        </div>
    </div>
</div>