<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-01 20:57:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-01 20:57:28
 */
 

namespace common\plugins\diandi_hub\models\account;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_account_store_pay}}".
 *
 * @public int $id
 * @public int|null $member_id 会员id
 * @public int|null $operation_mid 发起人
 * @public float|null $money 付款金额
 * @public string|null $remark 付款备注
 * @public int|null $status 付款状态
 * @public int|null $affirm_mid 确认人
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
            [['member_id', 'operation_mid', 'status', 'affirm_mid', 'update_time', 'create_time','order_goods_id'], 'integer'],
            [['money'], 'number'],
            [['remark'], 'string', 'max' => 255],
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员id',
            'operation_mid' => '发起人',
            'money' => '付款金额',
            'remark' => '付款备注',
            'status' => '付款状态',
            'affirm_mid' => '确认人',
            'update_time' => '创建时间',
            'create_time' => '更新时间',
        ];
    }
}
