<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-30 00:23:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-24 09:31:20
 */

namespace common\plugins\diandi_hub\models\member;

use common\plugins\diandi_hub\models\level\HubLevel;
use admin\modules\officialaccount\models\DdWechatFans;
use api\modules\wechat\models\DdWxappFans;
use common\models\DdUser;
use diandi\addons\models\BlocStore;

/**
 * This is the model class for table "dd_diandi_hub_member_level".
 *
 * @public int         $id
 * @public int|null    $bloc_id     公司ID
 * @public int|null    $store_id    商户ID
 * @public int|null    $member_id   会员ID
 * @public int|null    $member_pid  上级id
 * @public int|null    $level_pid   上级的等级
 * @public int|null    $level_id    等级
 * @public string|null $family      下级家族
 * @public int|null    $create_time 注册时间
 * @public int|null    $update_time 更新时间
 */
class HubMemberLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_member_level}}';
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
                'is_bloc' => 1, //集团数据
            ],
        ];
    }

    public function getLevel()
    {
        return $this->hasOne(HubLevel::class, ['levelnum' => 'level_num']);
    }

    public function getLevelParent()
    {
        return $this->hasOne(HubLevel::class, ['levelnum' => 'level_pid_num']);
    }

    public function getWxappfans()
    {
        return $this->hasOne(DdWxappFans::class, ['user_id' => 'member_id']);
    }

    public function getWechatfans()
    {
        return $this->hasOne(DdWechatFans::class, ['user_id' => 'member_id']);
    }

    public function getMember()
    {
        return $this->hasOne(DdUser::class, ['id' => 'member_id']);
    }

    public function getMemberParent()
    {
        return $this->hasOne(DdUser::class, ['id' => 'member_pid']);
    }

    public function getStore()
    {
        return $this->hasOne(BlocStore::class, ['store_id' => 'member_store_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'is_store', 'member_id', 'member_pid', 'level_pid_num', 'level_num', 'create_time', 'update_time', 'end_time'], 'integer'],
            [['family', 'member_store_id'], 'string'],
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
            'member_store_id' => '我的店',
            'is_store' => '是否是店主',
            'member_id' => '会员ID',
            'member_pid' => '上级id',
            'level_pid_num' => '上级的等级',
            'level_num' => '等级',
            'family' => '下级家族',
            'create_time' => '注册时间',
            'update_time' => '更新时间',
        ];
    }
}
