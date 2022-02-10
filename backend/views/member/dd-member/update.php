<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-02 01:24:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-24 16:34:58
 */

use common\components\backend\VueBackendAsset;
use yii\helpers\Html;
VueBackendAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\DdMember */

$this->title = '修改会员信息: ' . $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Dd Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'id' => $model->member_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="dd-member-update" id="dd-member-update">


                <?= $this->render('_form', [
                'group' => $group,
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>