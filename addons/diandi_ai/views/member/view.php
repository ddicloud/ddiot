<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 11:49:14
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-11 11:49:15
 */
 

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DdAiMember */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => '会员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('_tab') ?>

<div class=" firetech-main">
<div class="dd-ai-member-view">

    <div class="panel panel-default">
        <div class="box-body">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->user_id], [
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
            'user_id',
            'face_group_id',
            'nickName',
            'face_image',
            'gender',
            'face_id',
            'uid',
            'face_token',
            'wxapp_id',
            'create_time:datetime',
            'update_time:datetime',
            'ai_age',
            'ai_gender',
            'ai_glasses',
            'ai_race',
            'ai_emotion',
            'face_shape',
            'ai_quality_blur',
            'ai_quality_illumination',
            'ai_quality_completeness',
        ],
    ]) ?>

</div>
    </div>
</div>
</div>