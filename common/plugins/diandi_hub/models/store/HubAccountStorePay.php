<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-14 01:51:21
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-03 00:37:47
 */
 

namespace common\plugins\diandi_hub\models\store;

use common\plugins\diandi_hub\models\member\HubUserBank;
use common\models\DdMember;
use common\models\DdUser;
use diandi\addons\models\BlocStore;
use Yii;

/**
 * This is the model class for table "{{%diandi_hub_account_store_pay}}".
 *
 * @public int $id
 * @public string|null $order_no 订单编号
 * @public int|null $member_id 会员id
 * @public int|null $operation_mid 发起人
 * @public float|null $money 付款金额
 * @public string|null $remark 付款备注
 * @public int|null $status 付款状态
 * @public int|null $affirm_mid 确认人
 * @public string|null $transaction_id 微信支付单号
 * @public int|null $pay_time 支付时间
 * @public int|null $update_time 创建时间
 * @public int|null $create_time 更新时间
 */
class HubAccountStorePay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_account_store_pay}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        
        return [
            [['store_id','bloc_id','member_id', 'operation_mid', 'status', 'affirm_mid', 'pay_time', 'update_time', 'create_time','qrcode_time','confirm_time','store_id','bloc_id','member_store_id','pay_type','is_money','is_rebate'], 'integer'],
            [['money','store_money','store_radio'], 'number'],
            [['order_no'], 'string', 'max' => 30],
            [['remark'], 'string', 'max' => 255],
            [['transaction_id', 'affirm_name'], 'string', 'max' => 50],
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

    public function getList()
    {
        return $this->hasMany(HubAccountStorePayList::class,['order_id'=>'id']);
    }

    public function getOperation()
    {
        return $this->hasOne(DdUser::class,['id'=>'operation_mid']);
    }

    public function getAffirm()
    {
        return $this->hasOne(DdUser::class,['id'=>'affirm_mid']);
    }

    public function getStore()
    {
        return $this->hasOne(BlocStore::class,['store_id'=>'store_id']);
    }
    
    public function getMember()
    {
        return $this->hasOne(DdUser::class,['id'=>'member_id']);
    }

    
    public function getUserbank()
    {
        return $this->hasOne(HubUserBank::class,['member_id'=>'member_id']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_radio'=>'店铺折扣',
            'store_money'=>'店铺结算资金',
            'order_no' => '订单编号',
            'member_id' => '付款人',
            'operation_mid' => '发起人',
            'money' => '付款金额',
            'remark' => '付款备注',
            'pay_type'=> '支付方式',
            'status' => '付款状态',
            'affirm_mid' => '确认客服',
            'affirm_name'=> '确认客服名字',
            'transaction_id' => '微信支付单号',
            'pay_time' => '付款时间',
            'is_money'=>'是否解冻',
            'is_rebate'=>'是否补贴',
            'qrcode_time' => '扫码事件',
            'confirm_time' => '确认时间',
            'update_time' => '创建时间',
            'create_time' => '更新时间',
        ];
    }
}
