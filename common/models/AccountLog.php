<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-15 17:37:07
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-04 22:14:44
 */
 

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%account_log}}".
 *
 * @public int $id
 * @public int|null $bloc_id
 * @public int|null $store_id
 * @public int|null $member_id 会员id
 * @public int|null $account_type 资金类型
 * @public float|null $money 资金
 * @public int|null $is_add 0增加，1减少
 * @public string|null $remark 备注
 * @public int|null $update_time 创建时间
 * @public int|null $create_time 更新时间
 */
class AccountLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%account_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'store_id', 'member_id', 'is_add', 'update_time', 'create_time','money_id'], 'integer'],
            [['money','old_money'], 'number'],
            [['account_type'], 'string', 'max' => 30],
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
                'class' => \common\behaviors\SaveBehavior::className(),
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
            'bloc_id' => 'Bloc ID',
            'store_id' => 'Store ID',
            'member_id' => '会员id',
            'account_type' => '资金类型',
            'money' => '资金',
            'old_money'=>'原来的资金',
            'is_add' => '0增加，1减少',
            'remark' => '备注',
            'money_id'=>'操作日志ID',
            'update_time' => '创建时间',
            'create_time' => '更新时间',
        ];
    }
}
