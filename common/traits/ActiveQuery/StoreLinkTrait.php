<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 14:40:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-20 11:48:57
 */

namespace common\traits\ActiveQuery;

use admin\services\StoreService;
use Yii;

trait StoreLinkTrait
{
    public function getUser(){
        if (method_exists($this, 'getUser')) {
            return parent::getUser();
        } else {
            throw new \Exception('模型类中 getUser 方法不存在!');
        }
    }

    public function beforeSave($insert)
    {
        global $_GPC;
        if ($insert) {
            $bloc_id =   $_GPC['bloc_id'];
            $name = $_GPC['name'];
            $logo = $_GPC['logo'];
            $address = $_GPC['address'];
            $longitude = $_GPC['longitude'];
            $latitude = $_GPC['latitude'];
            $mobile = $_GPC['mobile'];
            $status = $_GPC['status'];
            $lng_lat = $_GPC['lng_lat'];
            $category = $_GPC['category'];
            $provinceCityDistrict = $_GPC['provinceCityDistrict'];
            $label_link = (array) $_GPC['label_link'];
            $user_id = $this->getUser();
            $bloc = StoreService::addLinkStore($user_id,$bloc_id, $category, $provinceCityDistrict, $name, $logo, $address, $longitude, $latitude, $mobile, $status, $label_link);
            $this->store_id = $bloc['store_id'];
            parent::beforeSave($insert);
            return true;
        } else {
            $bloc_id =   $_GPC['bloc_id'];
            $name = $_GPC['name'];
            $logo = $_GPC['logo'];
            $address = $_GPC['address'];
            $longitude = $_GPC['longitude'];
            $latitude = $_GPC['latitude'];
            $mobile = $_GPC['mobile'];
            $status = $_GPC['status'];
            $lng_lat = $_GPC['lng_lat'];
            $category = $_GPC['category'];
            $provinceCityDistrict = $_GPC['provinceCityDistrict'];
            $label_link = (array) $_GPC['label_link'];
            $store_id = $this->store_id;
            $bloc = StoreService::upLinkStore($store_id, $bloc_id, $category, $provinceCityDistrict, $name, $logo, $address, $longitude, $latitude, $mobile, $status, $label_link);
            parent::beforeSave($insert);
            return true;
        }
    }
}
