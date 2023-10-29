<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-18 09:49:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-29 18:25:31
 */

namespace common\plugins\diandi_cloud\models;

use common\plugins\diandi_cloud\models\enums\AuthDomainStatus;

/**
 * This is the model class for table "dd_diandi_cloud_auth_domain".
 *
 * @public int         $id
 * @public int|null    $member_id   会员ID
 * @public int|null    $status      域名状态
 * @public string|null $domin_url   域名
 * @public string|null $start_time  开始时间
 * @public string|null $end_time    结束时间
 * @public int|null    $create_time
 * @public int|null    $update_time
 */
class CloudAuthDomain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_cloud_auth_domain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['member_id', 'status', 'create_time', 'update_time'], 'integer'],
            [['member_id', 'status'], 'required'],
            [['start_time', 'end_time'], 'safe'],
            [['start_time', 'end_time'], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            [['domin_url'], 'string', 'max' => 100],
            ['domin_url', 'url'],
            ['member_id', 'exist', 'targetClass' => 'common\models\DdMember', 'targetAttribute' => 'member_id', 'message' => '所选用户不存在'],
            ['status', 'in', 'range' => array_keys(AuthDomainStatus::$list), 'message' => '授权用户状态只能是:'.implode(',', array_keys(AuthDomainStatus::$list))],
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
            'member_id' => '会员ID',
            'status' => '域名状态',
            'domin_url' => '域名',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
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
            'member_id',
        ]);
    }
}
