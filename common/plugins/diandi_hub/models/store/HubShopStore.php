<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-16 13:38:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:39:08
 */
 

namespace common\plugins\diandi_hub\models\store;

use Yii;

/**
 * This is the model class for table "dd_diandi_hub_store".
 *
 * @public int $id
 * @public int|null $bloc_id 所属公司
 * @public string|null $title 商家名称
 * @public string|null $banner 横幅背景
 * @public string|null $logo 商家logo
 * @public string|null $intro 简介
 * @public string $address 商家地址
 * @public string|null $shareimg 分享图片
 * @public string|null $certificate 资质证书
 * @public string|null $hotSearch 热搜
 * @public string|null $lng_lat 经纬度
 * @public string|null $service 服务
 * @public int|null $mobile 商家电话
 * @public string|null $sendtime 配送时间
 * @public string|null $Lodop_ip 打印机IP
 * @public float|null $shippingDees 基础配送费
 * @public string|null $notice 公告
 * @public string|null $surroundings 商家环境
 * @public float|null $startingPrice 起送价
 * @public string|null $describe 商家详情
 * @public int|null $create_time
 * @public int|null $update_time
 */
class HubShopStore extends \yii\db\ActiveRecord
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
            [['bloc_id', 'mobile', 'create_time', 'update_time'], 'integer'],
            [['address'], 'required'],
            [['shippingDees', 'startingPrice'], 'number'],
            [['title'], 'string', 'max' => 50],
            [['banner', 'logo', 'intro', 'address', 'shareimg', 'certificate', 'hotSearch', 'lng_lat', 'service', 'notice', 'surroundings', 'describe'], 'string', 'max' => 255],
            [['sendtime', 'Lodop_ip'], 'string', 'max' => 100],
            [['bloc_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => '所属公司',
            'title' => '商家名称',
            'banner' => '横幅背景',
            'logo' => '商家logo',
            'intro' => '简介',
            'address' => '商家地址',
            'shareimg' => '分享图片',
            'certificate' => '资质证书',
            'hotSearch' => '热搜',
            'lng_lat' => '经纬度',
            'service' => '服务',
            'mobile' => '商家电话',
            'sendtime' => '配送时间',
            'Lodop_ip' => '打印机IP',
            'shippingDees' => '基础配送费',
            'notice' => '公告',
            'surroundings' => '商家环境',
            'startingPrice' => '起送价',
            'describe' => '商家详情',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
