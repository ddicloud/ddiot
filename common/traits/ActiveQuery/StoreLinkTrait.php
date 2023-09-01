<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 14:40:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-20 11:48:57
 */

namespace common\traits\ActiveQuery;

use admin\services\StoreService;
use common\helpers\ResultHelper;
use Yii;
use yii\web\HttpException;

trait StoreLinkTrait
{
    /**
     * @throws \Exception
     */
    public function getUser(){
        $parent  = new parent();
        if (method_exists($parent, 'getUser')) {
            return $parent::getUser();
        } else {
            throw new \Exception('模型类中 getUser 方法不存在!');
        }
    }

    /**
     * @throws HttpException
     */
    public function beforeSave($insert): bool|array
    {
        global $_GPC;
        $bloc_id =  isset($_GPC['bloc_id']) ??0;
        $name = isset($_GPC['name']) ??'';
        $logo = isset($_GPC['logo']) ??'';
        $address = isset($_GPC['address']) ??'';
        $longitude = isset($_GPC['longitude']) ??'';
        $latitude = isset($_GPC['latitude']) ??'';
        $mobile = isset($_GPC['mobile']) ??'';
        $status = isset($_GPC['status'])??0;
//        $lng_lat = isset($_GPC['lng_lat'])??[];
        $category = (array) (isset($_GPC['category'])??[]);
        $provinceCityDistrict = (array) (isset($_GPC['provinceCityDistrict'])??[]);
        $label_link = isset($_GPC['label_link'])??[];
        if ($insert) {
            try {
                $user_id = $this->getUser();
            } catch (\Exception $e) {
                return ResultHelper::json(400, $e->getMessage(), (array)$e);
            }
            try {
                $bloc = StoreService::addLinkStore($user_id, $bloc_id, $category, $provinceCityDistrict, $name, $logo, $address, $longitude, $latitude, $mobile, $status, $label_link);
            } catch (HttpException $e) {
                return ResultHelper::json(400, $e->getMessage(), (array)$e);
            }
            $this->store_id = $bloc['store_id'];
        } else {
            $store_id = $this->store_id;
            $bloc = StoreService::upLinkStore($store_id, $bloc_id, $category, $provinceCityDistrict, $name, $logo, $address, $longitude, $latitude, $mobile, $status, $label_link);
        }
        parent::beforeSave($insert);
        return true;
    }
}
