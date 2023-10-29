<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-09-20 09:52:22
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-20 09:52:29
 */

namespace common\plugins\diandi_cloud\models;

class DdMember extends \api\models\DdMember
{
    const SELECT_FIELD = ['member_id', 'group_id', 'level', 'openid', 'store_id', 'bloc_id', 'username', 'mobile', 'nickName', 'realname', 'avatarUrl', 'gender'];

    public $temp_target;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['member_id', 'group_id', 'level', 'openid', 'store_id', 'bloc_id', 'username', 'mobile', 'nickName', 'realname', 'avatarUrl', 'gender'], 'safe'],
            ['mobile', 'match', 'pattern' => '/^[1][34578][0-9]{9}$/'],
            [['mobile'], 'unique'],
            [['temp_target'], 'integer', 'min' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'member_id' => '用戶ID',
            'group_id' => 'group_id',
            'level' => 'level',
            'openid' => 'openid',
            'store_id' => 'store_id',
            'bloc_id' => 'bloc_id',
            'username' => '用戶名',
            'mobile' => '手机号',
            'nickName' => '昵称',
            'realname' => '真实姓名',
            'avatarUrl' => '头像',
            'gender' => '性别',
            'temp_target' => '运动目标',
        ];
    }

    public function getExpand()
    {
        return $this->hasOne(MemberExpand::class, ['member_id' => 'member_id']);
    }
}
