<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-17 20:05:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 11:27:35
 */

namespace console\models;

use diandi\admin\models\AuthAssignmentGroup as ModelsAuthAssignmentGroup;

class AuthAssignmentGroup extends ModelsAuthAssignmentGroup
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at', 'user_id', 'item_id','group_id'], 'integer'],
            [['item_name'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthUserGroup::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * Gets query for [[ItemName]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthUserGroup::className(), ['name' => 'item_name']);
    }
}
