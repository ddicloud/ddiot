<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-23 03:58:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-09 12:08:51
 */
 

namespace common\plugins\diandi_hub\models\account;

use common\plugins\diandi_hub\models\member\HubUserBank;
use common\models\DdMember;
use common\models\DdUser;
use Yii;

/**
 * This is the model class for table "{{%diandi_hub_withdraw_log}}".
 *
 * @public int $id
 * @public string|null $partner_trade_no 付款商户单号
 * @public float $money 申请金额
 * @public int|null $withdraw_type 提现类型
 * @public int|null $withdraw_status 提现状态
 * @public int|null $member_id 用户id
 * @public string|null $confirm_name 确认人
 * @public string|null $openid OPENID
 * @public string|null $re_user_name 真实姓名
 * @public string|null $desc 付款说明
 * @public int $ymd_time 申请时间ymd
 * @public int|null $create_time 申请时间
 * @public int|null $update_time
 */
class HubWithdrawLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_withdraw_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['money', 'ymd_time'], 'required'],
            [['money','service_charge','money_count'], 'number'],
            [['withdraw_type', 'withdraw_status','pay_type','member_id', 'ymd_time', 'create_time', 'update_time','pay_status'], 'integer'],
            [['partner_trade_no', 'confirm_name', 'openid', 're_user_name'], 'string', 'max' => 30],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * 行为.
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }

    public function getUserbank()
    {
        return $this->hasOne(HubUserBank::class,['member_id'=>'member_id']);
    }

    public function getMember()
    {
        return $this->hasOne(DdUser::class,['id'=>'member_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_trade_no' => '付款商户单号',
            'money' => '到账金额',
            'money_count' => '申请总金额',
            'withdraw_type' => '提现类型',
            'withdraw_status' => '提现状态',
            'member_id' => '用户id',
            'confirm_name' => '确认人',
            'openid' => 'OPENID',
            'pay_status'=>'付款状态',
            're_user_name' => '真实姓名',
            'desc' => '付款说明',
            'service_charge'=>'手续费',
            'pay_type'=>'付款方式',
            'ymd_time' => '申请时间ymd',
            'create_time' => '申请时间',
            'update_time' => 'Update Time',
        ];
    }
}
