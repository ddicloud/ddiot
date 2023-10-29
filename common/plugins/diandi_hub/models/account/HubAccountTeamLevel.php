<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-01 20:57:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-13 17:47:27
 */
 

namespace common\plugins\diandi_hub\models\account;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_account_team_level}}".
 *
 * @public int $id
 * @public int|null $order_id 订单id
 * @public int|null $member_id 会员id
 * @public int|null $selflevel_num 下单人等级
 * @public int|null $level_num 会员等级
 * @public int|null $levelnum 会员等级人数
 * @public int|null $level_mid 团队id
 * @public int|null $level1_mid 分销一级用户
 * @public int|null $level2_mid 分销二级用户
 * @public int|null $level3_mid 分销三级用户
 * @public float|null $team_radio 团队奖励比例
 * @public float|null $money 团队奖励
 * @public int|null $update_time 创建时间
 * @public int|null $create_time 更新时间
 */
class HubAccountTeamLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_account_team_level}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id', 'member_id', 'selflevel_num', 'level_num', 'levelnum', 'level_mid', 'level1_mid', 'level2_mid', 'level3_mid', 'update_time', 'create_time','order_goods_id'], 'integer'],
            [['team_radio', 'money','performance'], 'number'],
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
            'order_id' => '订单id',
            'member_id' => '会员id',
            'selflevel_num' => '下单人等级',
            'performance'=> '礼包业绩',
            'level_num' => '会员等级',
            'levelnum' => '会员等级人数',
            'level_mid' => '团队id',
            'level1_mid' => '分销一级用户',
            'level2_mid' => '分销二级用户',
            'level3_mid' => '分销三级用户',
            'team_radio' => '团队奖励比例',
            'money' => '团队奖励',
            'update_time' => '创建时间',
            'create_time' => '更新时间',
        ];
    }
}
