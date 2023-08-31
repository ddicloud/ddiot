<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-14 04:47:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-21 22:54:24
 */


namespace common\models;

use Yii;

/**
 * This is the model class for table "dd_core_paylog".
 *
 * @public int $plid
 * @public string $type 支付类型
 * @public string $openid openid
 * @public string $uniontid 跨应用标识
 * @public string $tid
 * @public float $fee 支付金额
 * @public int $status 支付状态
 * @public string $module 模块
 * @public string $tag
 * @public int $is_usecard 是否使用会员卡
 * @public int $card_type 会员卡类型
 * @public string $card_id 会员卡id
 * @public float $card_fee 会员卡余额
 * @public string $encrypt_code 加密字符串
 * @public int $is_wish
 */
class DdCorePaylog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%core_paylog}}';
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
    public function rules()
    {
        return [
            [['type','uniontid', 'fee', 'status', 'module', 'tag'], 'required'],
            [['fee', 'card_fee'], 'number'],
            [['status', 'is_usecard', 'card_type', 'is_wish',
                'bloc_id',
                'store_id',
                'member_id',
                'create_time',
                'update_time'
            ], 'integer'],
            [['type'], 'string', 'max' => 20],
            [['openid'], 'string', 'max' => 40],
            [['uniontid'], 'string', 'max' => 255],
            [['tid'], 'string', 'max' => 128],
            [['module', 'card_id'], 'string', 'max' => 50],
            [['tag'], 'string', 'max' => 2000],
            [['encrypt_code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'plid' => 'Plid',
            'type' => '支付类型',
            'openid' => 'openid',
            'uniontid' => '跨应用标识',
            'tid' => 'Tid',
            'fee' => '支付金额',
            'status' => '支付状态',
            'module' => '模块',
            'tag' => 'Tag',
            'member_id'=>'用户id',
            'is_usecard' => '是否使用会员卡',
            'card_type' => '会员卡类型',
            'card_id' => '会员卡id',
            'card_fee' => '会员卡余额',
            'encrypt_code' => '加密字符串',
            'is_wish' => 'Is Wish',
        ];
    }
}
