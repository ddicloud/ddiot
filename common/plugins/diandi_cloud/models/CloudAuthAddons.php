<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-18 09:49:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-22 09:06:53
 */

namespace common\plugins\diandi_cloud\models;

/**
 * This is the model class for table "dd_diandi_cloud_auth_addons".
 *
 * @public int         $id
 * @public int|null    $member_id   会员ID
 * @public string|null $addons      授权模块
 * @public string|null $start_time  开始时间
 * @public string|null $end_time    结束时间
 * @public string|null $domin_url   授权域名
 * @public int|null    $create_time
 * @public int|null    $update_time
 */
class CloudAuthAddons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_cloud_auth_addons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['member_id', 'create_time', 'update_time'], 'integer'],
            [['member_id', 'addons'], 'required'],
            [['start_time', 'end_time'], 'safe'],
            [['start_time', 'end_time'], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            [['addons'], 'string', 'max' => 50],
            [['domin_url'], 'string', 'max' => 100],
            ['domin_url', 'url'],
            ['member_id', 'exist', 'targetClass' => 'common\models\DdMember', 'targetAttribute' => 'member_id', 'message' => '所选用户不存在'],
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
            'addons' => '授权模块',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'domin_url' => '授权域名',
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
