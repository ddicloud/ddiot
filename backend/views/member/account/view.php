<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DdMemberAccount */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dd Member Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('_tab') ?>


<div class=" firetech-main">
    <div class="dd-member-account-view">

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
            'bloc_id',
            'store_id',
            'member_id',
            'level',
            'user_money',
            'accumulate_money',
            'give_money',
            'consume_money',
            'frozen_money',
            'user_integral',
            'accumulate_integral',
            'give_integral',
            'consume_integral',
            'frozen_integral',
            'credit1',
            'credit2',
            'credit3',
            'credit4',
            'credit5',
            'status',
            'create_time:datetime',
            'update_time:datetime',
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>