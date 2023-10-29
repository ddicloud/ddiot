<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-23 02:46:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-09 12:24:18
 */
 

namespace common\plugins\diandi_hub\models\member;

use common\models\DdRegion;
use Yii;

/**
 * This is the model class for table "{{%diandi_hub_user_bank}}".
 *
 * @public int $id
 * @public int $member_id 用户id
 * @public string $name 用户姓名
 * @public string $bank_no 银行卡号
 * @public string $mobile 到账通知手机号
 * @public string $address 开户行
 * @public int $provice 省份
 * @public int|null $city 城市
 * @public int|null $area 区域
 * @public string|null $thumb 银行卡正面照片
 * @public string|null $card_front 身份证正面
 * @public string|null $card_reverse 身份证反面
 * @public string|null $alipay 支付宝账号
 * @public int $create_time
 * @public int $update_time
 */
class HubUserBank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_user_bank}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['member_id', 'province', 'city', 'area', 'create_time', 'update_time','editor_status'], 'integer'],
            [['name', 'bank_no'], 'string', 'max' => 30],
            [['mobile'], 'string', 'max' => 11],
            [['address'], 'string', 'max' => 50],
            [['thumb', 'card_front', 'card_reverse', 'alipay'], 'string', 'max' => 255],
            [['member_id'], 'unique'],
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

 

    /* 获取分类 */
    public function getProvinces()
    {
        return $this->hasOne(DdRegion::class, ['id' => 'province']);
    }

    /* 获取分类 */
    public function getCitys()
    {
        return $this->hasOne(DdRegion::class, ['id' => 'city']);
    }

    /* 获取分类 */
    public function getRegions()
    {
        return $this->hasOne(DdRegion::class, ['id' => 'area']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户id',
            'name' => '真实姓名',
            'bank_no' => '银行卡号',
            'mobile' => '到账通知手机号',
            'address' => '开户行',
            'province' => '省份',
            'editor_status'=>'是否可修改',
            'is_apply'=>'是否申请',
            'city' => '城市',
            'area' => '区域',
            'thumb' => '银行卡正面照片',
            'card_front' => '身份证正面',
            'card_reverse' => '身份证反面',
            'alipay' => '支付宝账号',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
