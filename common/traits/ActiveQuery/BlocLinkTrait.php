<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 14:40:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-19 19:26:07
 */

namespace common\traits\ActiveQuery;

use admin\services\StoreService;
use yii\base\ErrorException;
use yii\web\HttpException;

trait BlocLinkTrait
{
    /**
     * @throws ErrorException
     */
    public function beforeSave($insert): bool
    {
        global $_GPC;
        $invitation_code = $_GPC['invitation_code'];
        $business_name = $_GPC['business_name'];
        $logo = $_GPC['logo'];
        $pid = $_GPC['pid'];
        $group_bloc_id = $_GPC['group_bloc_id'];
        $category = $_GPC['category'];
        $provinceCityDistrict = $_GPC['provinceCityDistrict'];
        $address = $_GPC['address'];
        $register_level = $_GPC['register_level'];
        $longitude = $_GPC['longitude'];
        $latitude = $_GPC['latitude'];
        $telephone = $_GPC['telephone'];
        $avg_price = $_GPC['avg_price'];
        $recommend = $_GPC['recommend'];
        $special = $_GPC['special'];
        $introduction = $_GPC['introduction'];
        if ($insert) {
            // $province = $_GPC['province'];
            // $city = $_GPC['city'];
            // $district = $_GPC['district'];
            $open_time = $_GPC['open_time'];
            $end_time = $_GPC['end_time'];
            $status = $_GPC['status'];
            $is_group = $_GPC['is_group'];
            $sosomap_poi_uid = $_GPC['sosomap_poi_uid'];
            $license_no = $_GPC['license_no'];
            $license_name = $_GPC['license_name'];
            $level_num = $_GPC['level_num'];
            try {
                $bloc = StoreService::addLinkBloc($invitation_code, $business_name, $logo, $pid, $group_bloc_id, $category, $provinceCityDistrict, $address, $register_level, $longitude, $latitude, $telephone, $avg_price, $recommend, $special, $introduction, $open_time, $end_time, $status, $is_group, $sosomap_poi_uid, $license_no, $license_name, $level_num);
            } catch (HttpException $e) {
                throw new ErrorException($e->getMessage(),400);
            }
            $this->bloc_id = $bloc['bloc_id'];
        } else {
            // $province = $_GPC['province'];
            // $city = $_GPC['city'];
            // $district = $_GPC['district'];
            $end_time = $_GPC['end_time'];
            $open_time = $_GPC['open_time'];
            $status = $_GPC['status'];
            $is_group = $_GPC['is_group'];
            $sosomap_poi_uid = $_GPC['sosomap_poi_uid'];
            $license_no = $_GPC['license_no'];
            $license_name = $_GPC['license_name'];
            $level_num = $_GPC['level_num'];
            $bloc_id = $this->bloc_id;
            try {
                $bloc = StoreService::upLinkBloc($bloc_id, $invitation_code, $business_name, $logo, $pid, $group_bloc_id, $category, $provinceCityDistrict, $address, $register_level, $longitude, $latitude, $telephone, $avg_price, $recommend, $special, $introduction, $open_time, $end_time, $status, $is_group, $sosomap_poi_uid, $license_no, $license_name, $level_num);
            } catch (HttpException $e) {
                throw new ErrorException($e->getMessage(),400);
            }
        }
        parent::beforeSave($insert);
        return true;
    }
}
