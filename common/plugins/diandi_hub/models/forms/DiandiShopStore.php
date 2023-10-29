<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-19 15:47:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-09 20:02:48
 */

namespace common\plugins\diandi_hub\models\forms;

use common\plugins\diandi_hub\models\HubShopStore;

use yii\base\Model;

class DiandiShopStore extends Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_hub_setting';
    }

    public $id;

    public $bloc_id;
    public $mobile;
    public $title;
    public $startingPrice;
    public $intro;
    public $shippingDees;
    public $address;
    public $describe;
    public $logo;
    public $banner;
    public $hotSearch;
    public $notice;
    public $surroundings;
    public $certificate;
    public $lng_lat;
    public $distance;

    public $service;
    public $sendtime;
    public $shareimg;

    public $Lodop_ip;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['mobile', 'startingPrice', 'shippingDees', 'distance'], 'integer'],
            [['title', 'notice', 'service', 'Lodop_ip', 'sendtime'], 'string', 'max' => 50],
            [['hotSearch', 'lng_lat', 'shareimg'], 'string', 'max' => 255],
            [['surroundings', 'certificate'], 'safe'],
            [['intro', 'address', 'describe', 'logo', 'banner'], 'string', 'max' => 255],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new HubShopStore();
        $store = $conf::findOne(['bloc_id' => $bloc_id]);
        $this->id = $store->id;
        $this->bloc_id = $store->bloc_id;
        $this->sendtime = $store->sendtime;
        $this->service = $store->service;
        $this->title = $store->title;
        $this->intro = $store->intro;
        $this->address = $store->address;
        $this->mobile = $store->mobile;
        $this->describe = $store->describe;
        $this->Lodop_ip = $store->Lodop_ip;
        $this->logo = $store->logo;
        $this->banner = $store->banner;
        $this->startingPrice = $store->startingPrice;
        $this->shippingDees = $store->shippingDees;
        $this->distance = $store->distance;
        $this->lng_lat = $store->lng_lat;
        $this->notice = $store->notice;
        $this->surroundings = $store->surroundings;
        $this->certificate = $store->certificate;
        $this->shareimg = $store->shareimg;
        $this->hotSearch = $store->hotSearch;
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return null;
        }

        $conf = HubShopStore::findOne(['bloc_id' => $bloc_id]);
        if (!$conf) {
            $conf = new HubShopStore();
        }

        $conf->bloc_id = $bloc_id;

        $conf->bloc_id = $this->bloc_id;
        $conf->sendtime = $this->sendtime;
        $conf->service = $this->service;
        $conf->title = $this->title;
        $conf->intro = $this->intro;
        $conf->address = $this->address;
        $conf->mobile = $this->mobile;
        $conf->describe = $this->describe;
        $conf->Lodop_ip = $this->Lodop_ip;
        $conf->logo = $this->logo;
        $conf->banner = $this->banner;
        $conf->startingPrice = $this->startingPrice;
        $conf->shippingDees = $this->shippingDees;
        $conf->distance = $this->distance;
        $conf->lng_lat = $this->lng_lat;
        $conf->notice = $this->notice;
        $conf->surroundings = $this->surroundings;
        $conf->certificate = $this->certificate;
        $conf->shareimg = $this->shareimg;
        $conf->hotSearch = $this->hotSearch;

        return $conf->save();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'sendtime' => '配送时间',
            'service' => '配送服务保障',
            'title' => '商家名称',
            'intro' => '简介',
            'address' => '商家地址',
            'mobile' => '商家电话',
            'describe' => '商家详情',
            'Lodop_ip' => '局域网打印机ip',
            'logo' => '商家logo',
            'banner' => '横幅背景',
            'startingPrice' => '起送价',
            'shippingDees' => '配送费',
            'id' => '商家ID',
            'distance' => '配送范围',
            'lng_lat' => '经纬度',
            'notice' => '公告',
            'surroundings' => '商家环境',
            'certificate' => '资质证书',
            'shareimg' => '分享图片',
            'hotSearch' => '热搜(以英文逗号隔开)',
        ];
    }
}
