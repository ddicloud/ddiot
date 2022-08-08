<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:54:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-08 15:38:26
 */

namespace common\models;

/**
 * This is the model class for table "dd_member_group".
 *
 * @property string   $item_name
 * @property int|null $create_time
 * @property int|null $update_time
 */
class DdMemberGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%member_group}}';
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
               'updatedAttribute' => 'create_time',
               'createdAttribute' => 'update_time',
           ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'level'], 'required'],
            [['create_time', 'update_time', 'level', 'bloc_id', 'store_id'], 'integer'],
            [['item_name'], 'string', 'max' => 64],
            [['level'], 'unique', 'targetAttribute' => ['level', 'store_id']],
            [['item_name'], 'unique', 'targetAttribute' => ['item_name', 'store_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_name' => '等级名称',
            'level' => '等级权重',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
