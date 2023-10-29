<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-01 20:57:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-01 20:57:11
 */
 

namespace common\plugins\diandi_hub\models\account;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_account_level}}".
 *
 * @public int $id
 * @public int|null $order_id 订单id
 * @public int|null $member_id 会员id
 * @public int|null $level_mid 用户id
 * @public int|null $selflevel_num 下单人等级
 * @public int|null $level_num 团队等级
 * @public int|null $levelnum 团队等级人数
 * @public int|null $level_dis 分销等级
 * @public float|null $level_radio 奖励比例
 * @public float|null $money 用户奖励金额
 * @public int|null $teamnum 团队人数
 * @public float|null $teamsale 团队销售额
 * @public float|null $selfsale 我的累计消费
 * @public int|null $update_time 创建时间
 * @public int|null $create_time 更新时间
 */
class HubAccountLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_account_level}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id', 'member_id', 'level_mid', 'selflevel_num', 'level_num', 'levelnum', 'level_dis', 'teamnum', 'update_time', 'create_time','order_goods_id'], 'integer'],
            [['level_radio', 'money', 'teamsale', 'selfsale'], 'number'],
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
            'order_id' => '订单id',
            'member_id' => '会员id',
            'level_mid' => '用户id',
            'selflevel_num' => '下单人等级',
            'level_num' => '团队等级',
            'levelnum' => '团队等级人数',
            'level_dis' => '分销等级',
            'level_radio' => '奖励比例',
            'money' => '用户奖励金额',
            'teamnum' => '团队人数',
            'teamsale' => '团队销售额',
            'selfsale' => '我的累计消费',
            'update_time' => '创建时间',
            'create_time' => '更新时间',
        ];
    }
}
