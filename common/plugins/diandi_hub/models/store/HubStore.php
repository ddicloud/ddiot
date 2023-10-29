<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-06 10:33:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-05 15:19:45
 */
 

namespace common\plugins\diandi_hub\models\store;

use common\plugins\diandi_hub\models\enums\BaseStatus;
use Yii;

/**
 * This is the model class for table "{{%diandi_hub_store}}".
 *
 * @public int $id
 * @public string|null $name 商家名称
 * @public int $mobile 商家手机号
 * @public string|null $address 商家地址
 * @public int|null $city 城市
 * @public int|null $provice 省份
 * @public int|null $area 区域
 * @public string|null $desc 店铺介绍
 * @public string|null $linkman 联系人
 * @public string|null $storefront 店面门头
 * @public string|null $business 营业执照
 * @public string|null $cardFront 身份证正面
 * @public string|null $cardReverse 身份证反面
 * @public string|null $interior 店铺内景
 * @public string|null $wechat_code 微信二维码
 * @public string|null $certification 其他资质
 * @public int|null $status 店铺审核状态
 * @public int|null $create_time
 * @public int|null $update_time
 */
class HubStore extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_store}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['mobile'], 'required'],
            [['id','city', 'provice', 'area', 'status', 'create_time', 'update_time','member_id'], 'integer'],
            [['name', 'linkman','mobile'], 'string', 'max' => 30],
            [['address'], 'string', 'max' => 100],
            [['desc', 'storefront', 'business', 'cardFront', 'cardReverse', 'interior', 'wechat_code', 'certification'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (!is_numeric($this->status) && isset($this->status)) {
                //字段
                $this->status = BaseStatus::getValueByName($this->status);
            }

            // if(is_array($this->images)){
            //     $this->images = serialize($this->images);

            // }

            return true;
        } else {
            return false;
        }
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
            'member_id'=>'申请人id',
            'name' => '商家名称',
            'mobile' => '商家手机号',
            'address' => '商家地址',
            'city' => '城市',
            'provice' => '省份',
            'area' => '区域',
            'desc' => '店铺介绍',
            'linkman' => '联系人',
            'storefront' => '店面门头',
            'business' => '营业执照',
            'cardFront' => '身份证正面',
            'cardReverse' => '身份证反面',
            'interior' => '店铺内景',
            'wechat_code' => '申请人身份证',
            'certification' => '其他资质',
            'status' => '店铺审核状态',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
