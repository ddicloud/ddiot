<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 11:49:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-11 11:49:10
 */
 

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DdAiMember */

$this->title = '添加 会员';
$this->params['breadcrumbs'][] = ['label' => '会员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="dd-ai-member-create">
                <?= $this->render('_form', [
                    'model' => $model,
                    'ai_groups' => $ai_groups,
                ]) ?>

            </div>
        </div>
    </div>
</div>