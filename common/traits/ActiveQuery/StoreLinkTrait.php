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
use Exception;
use Yii;
use yii\web\HttpException;

trait StoreLinkTrait
{
    /**
     * @throws Exception
     */
    public function getUser()
    {
        $parent = new parent();
        if (method_exists($parent, 'getUser')) {
            return $parent::getUser();
        } else {
            throw new Exception('模型类中 getUser 方法不存在!');
        }
    }

    /**
     */
    public function beforeSave($insert): bool|array
    {
        try {
            $bloc_id = Yii::$app->request->input('bloc_id', 0);
            $name = Yii::$app->request->input('name', '');
            $logo = Yii::$app->request->input('logo', '');
            $address = Yii::$app->request->input('address', '');
            $longitude = Yii::$app->request->input('longitude', '');
            $latitude = Yii::$app->request->input('latitude', '');
            $mobile = Yii::$app->request->input('mobile', '');
            $status = Yii::$app->request->input('status', 0);
            $lng_lat = Yii::$app->request->input('lng_lat', []);
            $category = Yii::$app->request->input('category', []);
            $provinceCityDistrict = Yii::$app->request->input('provinceCityDistrict',[]);
            $label_link = Yii::$app->request->input('label_link') ?? [];
            if ($insert) {
                $user_id = $this->getUser();
                $bloc = StoreService::addLinkStore($user_id, $bloc_id, $category, $provinceCityDistrict, $name, $logo, $address, $longitude, $latitude, $mobile, $status, $label_link);
                $this->store_id = $bloc['store_id'];
            } else {
                $store_id = $this->store_id;
                $bloc = StoreService::upLinkStore($store_id, $bloc_id, $category, $provinceCityDistrict, $name, $logo, $address, $longitude, $latitude, $mobile, $status, $label_link);
            }
            return parent::beforeSave($insert);
        } catch (HttpException|Exception $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }
    }
}
