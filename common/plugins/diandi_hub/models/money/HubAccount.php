<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-04 23:13:20
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 23:13:20
 */
 

namespace common\plugins\diandi_hub\models\money;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_account}}".
 *
 * @public int $id
 * @public int|null $bloc_id 公司ID
 * @public int|null $store_id 商户ID
 * @public int|null $member_id 会员ID
 * @public int|null $balance 我的余额
 * @public int|null $freeze 冻结金额
 * @public int|null $create_time 注册时间
 * @public int|null $update_time 更新时间
 */
class HubAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_account}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'member_id', 'balance', 'freeze', 'create_time', 'update_time'], 'integer'],
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
            'member_id' => '会员ID',
            'balance' => '我的余额',
            'freeze' => '冻结金额',
            'create_time' => '注册时间',
            'update_time' => '更新时间',
        ];
    }
}
