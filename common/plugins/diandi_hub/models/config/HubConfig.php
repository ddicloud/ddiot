<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-23 21:35:40
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 20:59:09
 */
 

namespace common\plugins\diandi_hub\models\config;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_config}}".
 *
 * @public int $id
 * @public float|null $min_money 用户最低提现金额
 * @public int|null $max_num 用户每天最多提现次数
 * @public float|null $max_money 用户每天最多提现金额
 * @public float|null $store_min_money 商户最低提现金额
 * @public int|null $store_max_num 商户每天最多提现次数
 * @public float|null $store_max_money 商户每天最多提现金额
 * @public float|null $store_radio 商户提现手续费
 * @public float|null $user_radio 用户提现手续费
 * @public string|null $user_integral_name 系统积分名称
 * @public int $is_credit1 是否启用credit1
 * @public int $is_credit2 是否启用credit2
 * @public int $is_credit3 是否启用credit3
 * @public string|null $credit1_name credit1名称
 * @public string|null $credit2_name credit2名称
 * @public string|null $credit3_name credit3名称
 * @public int|null $kd_id 快递鸟用户id
 * @public string|null $kd_key 快递鸟key
 * @public int|null $create_time
 * @public int|null $update_time
 */
class HubConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['min_money', 'max_money', 'store_min_money', 'store_max_money', 'store_radio', 'user_radio'], 'number'],
            [['max_num', 'store_max_num', 'is_credit1', 'is_credit2', 'is_credit3', 'create_time', 'update_time','onecode'], 'integer'],
            [['user_integral_name', 'credit1_name'], 'string', 'max' => 30],
            [['credit2_name', 'credit3_name', 'kd_key', 'kd_id','shareimg','myshareimg','h5_url'], 'string', 'max' => 255],
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
            'min_money' => '用户最低提现金额',
            'max_num' => '用户每天最多提现次数',
            'max_money' => '用户每天最多提现金额',
            'store_min_money' => '商户最低提现金额',
            'store_max_num' => '商户每天最多提现次数',
            'store_max_money' => '商户每天最多提现金额',
            'store_radio' => '商户提现手续费',
            'user_radio' => '用户提现手续费',
            'user_integral_name' => '系统积分名称',
            'is_credit1' => '是否启用credit1',
            'is_credit2' => '是否启用credit2',
            'is_credit3' => '是否启用credit3',
            'credit1_name' => 'credit1名称',
            'credit2_name' => 'credit2名称',
            'credit3_name' => 'credit3名称',
            'kd_id' => '快递鸟用户id',
            'kd_key' => '快递鸟key',
            'onecode'=> '首码用户ID',
            'shareimg'=> '分享商品背景',
            'myshareimg'=> '我的海报背景',
            'h5_url'=> 'h5地址',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
