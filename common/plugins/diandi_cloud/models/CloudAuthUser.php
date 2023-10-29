<?php

namespace common\plugins\diandi_cloud\models;

use Yii;
use common\plugins\diandi_cloud\models\enums\AuthUserStatus;

/**
 * This is the model class for table "dd_diandi_cloud_auth_user".
 *
 * @public int $id
 * @public int|null $member_id 会员ID
 * @public string|null $email 邮箱
 * @public string|null $mobile 手机号
 * @public string|null $username 真实姓名
 * @public string|null $web_key 系统秘钥
 * @public int|null $status 用户状态
 * @public int|null $create_time
 * @public int|null $update_time
 */
class CloudAuthUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_cloud_auth_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['member_id', 'status'], 'integer'],
            [['member_id', 'status'], 'required'],
            [['email', 'mobile'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 50],
            [['web_key'], 'string', 'max' => 100],
            ['member_id', 'exist', 'targetClass' => 'common\models\DdMember', 'targetAttribute' => 'member_id', 'message' => '所选用户不存在'],
            ['status', 'in', 'range' => array_keys(AuthUserStatus::$list), 'message' => '授权用户状态只能是:' . implode(',', array_keys(AuthUserStatus::$list))],
            ['member_id', 'unique', 'targetAttribute' => 'member_id', 'message' => '所选用户已存在!', 'when' => function ($model) {
                return $model->isNewRecord;
            }],

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
            [
                'class' => \yii\behaviors\AttributeBehavior::class,
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'web_key',
                ],
                'value' => function ($event) {
                    return uniqid($event->sender->member_id);
                },
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
            'member_id' => '会员ID',
            'email' => '邮箱',
            'mobile' => '手机号',
            'username' => '真实姓名',
            'web_key' => '系统秘钥',
            'status' => '用户状态',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    public function getMember()
    {
        return $this->hasOne(\common\models\DdMember::class, ['member_id' => 'member_id'])->select([
            'username',
            'mobile',
            'nickName',
            'avatarUrl',
            'status',
            'create_time',
            'update_time',
            'realname',
            'avatar',
            'idcard',
            'member_id'
        ]);
    }
}
