<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-04 23:39:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-05 00:14:27
 */
 

use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\DdMemberAccount */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dd Member Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>
                
<div class="firetech-main">

    <div class="dd-member-account-index ">
                                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">列表</h3>
            </div>
            <div class="box-body table-responsive">
            <?= MyGridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                                    'member_id',
                                    'member.username',
                                    'store.name',
                                    // 'level',
                                    //'user_money',
                                    //'accumulate_money',
                                    //'give_money',
                                    //'consume_money',
                                    //'frozen_money',
                                    'user_integral',
                                    //'accumulate_integral',
                                    //'give_integral',
                                    //'consume_integral',
                                    //'frozen_integral',
                                    'credit1',
                                    'credit2',
                                    'credit3',
                                    //'credit4',
                                    //'credit5',
                                    //'status',
                                    //'create_time:datetime',
                                    //'update_time:datetime',
                    
                                [
                                    'class' => 'common\components\ActionColumn',
                                    'template' => '{view} {update}',

                                ],
                    ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>
</div>