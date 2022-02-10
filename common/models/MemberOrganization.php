<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-11-13 16:01:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-11-17 14:34:55
 */


namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%member_organization}}".
 *
 * @property int $group_id
 * @property string $item_name 名称
 * @property int|null $group_pid 父级组织
 * @property int|null $create_time
 * @property int|null $update_time
 */
class MemberOrganization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%member_organization}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name'], 'required'],
            [['group_pid', 'create_time', 'update_time'], 'integer'],
            [['item_name'], 'string', 'max' => 64],
            [['intro'], 'string', 'max' => 255],
            [['item_name'], 'unique'],
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
            'group_id' => 'Group ID',
            'item_name' => '名称',
            'group_pid' => '父级组织',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
