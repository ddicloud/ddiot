<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-02 14:26:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-02 14:26:33
 */
 

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DdMember */

$this->title = $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Dd Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('_tab') ?>


<div class=" firetech-main">
    <div class="dd-member-view">

        <div class="panel panel-default">
            <div class="box-body">

                <p>
                    <?= Html::a('更新', ['update', 'id' => $model->member_id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('删除', ['delete', 'id' => $model->member_id], [
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
                            'member_id',
            'group_id',
            'level',
            'openid',
            'store_id',
            'bloc_id',
            'username',
            'mobile',
            'address',
            'nickName',
            'avatarUrl',
            'gender',
            'country',
            'province',
            'status',
            'city',
            'address_id',
            // 'wxapp_id',
            // 'verification_token',
            // 'create_time',
            // 'update_time',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'realname',
            'avatar',
            'qq',
            'vip',
            'birthyear',
            'constellation',
            'zodiac',
            'telephone',
            'idcard',
            'studentid',
            'grade',
            'zipcode',
            'nationality',
            'resideprovince',
            'graduateschool',
            'company',
            'education',
            'occupation',
            'position',
            'revenue',
            'affectivestatus',
            'lookingfor',
            'bloodtype',
            'height',
            'weight',
            'alipay',
            'msn',
            'email:email',
            'taobao',
            'site',
            'bio',
            'interest',
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>