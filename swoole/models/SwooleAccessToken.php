<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-19 13:19:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-19 17:38:48
 */

namespace swooleService\models;

/**
 * This is the model class for table "{{%swoole_access_token}}".
 *
 * @property int         $id
 * @property string|null $refresh_token        刷新令牌
 * @property string|null $access_token         授权令牌
 * @property int|null    $member_id            用户id
 * @property string|null $openid               授权对象openid
 * @property string|null $group_id             组别
 * @property int|null    $bloc_id
 * @property int|null    $store_id
 * @property int|null    $status               状态[-1:删除;0:禁用;1启用]
 * @property int|null    $create_time          创建时间
 * @property int|null    $updated_time         修改时间
 * @property int|null    $login_num            登录次数
 * @property int|null    $allowance
 * @property int|null    $allowance_updated_at
 */
class SwooleAccessToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%swoole_access_token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['swoole_member_id','id','member_id','group_id', 'bloc_id', 'store_id', 'status', 'create_time', 'updated_time', 'login_num', 'allowance', 'allowance_updated_at'], 'integer'],
            [['refresh_token', 'access_token'], 'string', 'max' => 60],
            [['openid'], 'string', 'max' => 50],
            [['access_token'], 'unique'],
            [['swoole_member_id'], 'unique'],
            [['refresh_token'], 'unique'],
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
            'refresh_token' => '刷新令牌',
            'access_token' => '授权令牌',
            'member_id' => '用户id',
            'openid' => '授权对象openid',
            'group_id' => '组别',
            'bloc_id' => 'Bloc ID',
            'store_id' => 'Store ID',
            'status' => '状态[-1:删除;0:禁用;1启用]',
            'create_time' => '创建时间',
            'updated_time' => '修改时间',
            'login_num' => '登录次数',
            'allowance' => 'Allowance',
            'allowance_updated_at' => 'Allowance Updated At',
        ];
    }
}
