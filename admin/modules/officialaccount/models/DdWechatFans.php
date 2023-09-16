<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 02:29:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-27 15:43:53
 */


namespace admin\modules\officialaccount\models;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "dd_wxapp_fans".
 *
 * @property int $fanid 粉丝id
 * @property int $user_id 会员id
 * @property string|null $avatarUrl 头像
 * @property string $openid OPENID
 * @property string $nickname 昵称
 * @property string $groupid 分组id
 * @property string $fans_info 所有资料
 * @property int|null $update_time 更新时间
 * @property int $create_time 创建时间
 * @property string $unionid unionid
 * @property int|null $gender 性别
 * @property string|null $country 国家
 * @property string|null $city 城市
 * @property string|null $province 省份
 */
class DdWechatFans extends \yii\db\ActiveRecord
{
    use StoreTrait;
    
    const FOLLOW_ON = 1;
    const FOLLOW_OFF = -1;

    /**
     * 关注状态
     *
     * @var array
     */
    public static array $followStatus = [
        self::FOLLOW_ON  => '已关注',
        self::FOLLOW_OFF => '未关注',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%wechat_fans}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'openid', 'nickname', 'fans_info'], 'required'],
            [['user_id', 'update_time', 'create_time', 'gender','groupid','follow'], 'integer'],
            [['fans_info'], 'string'],
            [['avatarUrl', 'secretKey','tag'], 'string', 'max' => 255],
            [['openid', 'nickname','followtime'], 'string', 'max' => 50],
            [['unionid'], 'string', 'max' => 64],
            [['country', 'city', 'province'], 'string', 'max' => 100],
        ];
    }

    /**
     * 行为
     */
    public function behaviors(): array
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::className(),
                'updatedAttribute' => 'create_time',
                'createdAttribute' => 'update_time',
            ]
        ];
    }

    // 根据用户id获取信息
    public static function getFansByUid($user_id): ?DdWechatFans
    {
        return  self::findOne(['user_id' => $user_id]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'fanid' => '粉丝id',
            'user_id' => '会员id',
            'avatarUrl' => '头像',
            'openid' => 'OPENID',
            'nickname' => '昵称',
            'groupid' => '分组id',
            'fans_info' => '所有资料',
            'update_time' => '更新时间',
            'create_time' => '创建时间',
            'unionid' => 'unionid',
            'gender' => '性别',
            'country' => '国家',
            'city' => '城市',
            'province' => '省份',
        ];
    }
}
