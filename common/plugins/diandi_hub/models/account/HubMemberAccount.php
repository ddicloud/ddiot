<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-29 00:36:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-04 23:08:10
 */
 

namespace common\plugins\diandi_hub\models\account;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_member_account}}".
 *
 * @public int $id
 * @public int|null $bloc_id 公司ID
 * @public int|null $store_id 商户ID
 * @public int|null $is_store 是否是店主
 * @public int|null $member_id 会员ID
 * @public float|null $self_money 个人奖金
 * @public float|null $self_withdraw 个人可提现
 * @public float|null $self_freeze 个人冻结
 * @public float|null $team_money 团队奖金
 * @public float|null $team_withdraw 团队奖金提现
 * @public float|null $team_freeze 团队奖金冻结
 * @public float|null $store_money 店铺收益
 * @public float|null $store_withdraw 店铺可提现
 * @public float|null $store_freeze 店铺收益冻结
 * @public int|null $create_time 注册时间
 * @public int|null $update_time 更新时间
 */
class HubMemberAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_account_member}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'member_id', 'create_time', 'update_time'], 'integer'],
            [[  
                'self_money', 'self_withdraw', 'self_freeze', 
                'team_money', 'team_withdraw', 'team_freeze', 
                'store_money', 'store_withdraw', 'store_freeze',
                'agent_money','agent_withdraw','agent_freeze',
                'water_money','water_withdraw','water_freeze'
            ], 'number'],
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
                'is_bloc'=>1//集团数据
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
            'bloc_id' => '公司ID',
            'store_id' => '商户ID',
            'member_id' => '会员ID',
            'self_money' => '个人奖金',
            'self_withdraw' => '个人可提现',
            'self_freeze' => '个人冻结',
            'team_money' => '团队奖金',
            'team_withdraw' => '团队奖金提现',
            'team_freeze' => '团队奖金冻结',
            'store_money' => '店铺收益',
            'store_withdraw' => '店铺可提现',
            'store_freeze' => '店铺收益冻结',
            'create_time' => '注册时间',
            'update_time' => '更新时间',
            'agent_money' => '代理奖金',
            'agent_withdraw' => '代理可提现',
            'agent_freeze' => '代理冻结',

        ];
    }
}
