<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 14:40:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-19 19:26:07
 */

namespace common\traits\ActiveQuery;

use admin\services\StoreService;
use Yii;
use yii\base\ErrorException;
use yii\web\HttpException;

trait BlocLinkTrait
{
    /**
     * @throws ErrorException
     */
    public function beforeSave($insert): bool
    {
        $invitation_code = Yii::$app->request->input('invitation_code');
        $business_name = Yii::$app->request->input('business_name');
        $logo = Yii::$app->request->input('logo');
        $pid = Yii::$app->request->input('pid');
        $group_bloc_id = Yii::$app->request->input('group_bloc_id');
        $category = Yii::$app->request->input('category');
        $provinceCityDistrict = Yii::$app->request->input('provinceCityDistrict',[]);
        $address = Yii::$app->request->input('address');
        $register_level = Yii::$app->request->input('register_level');
        $longitude = Yii::$app->request->input('longitude');
        $latitude = Yii::$app->request->input('latitude');
        $telephone = Yii::$app->request->input('telephone');
        $avg_price = Yii::$app->request->input('avg_price');
        $recommend = Yii::$app->request->input('recommend');
        $special = Yii::$app->request->input('special');
        $introduction = Yii::$app->request->input('introduction');
        if ($insert) {
            // $province =\Yii::$app->request->input('province');
            // $city =\Yii::$app->request->input('city');
            // $district =\Yii::$app->request->input('district');
            $open_time = Yii::$app->request->input('open_time');
            $end_time = Yii::$app->request->input('end_time');
            $status = Yii::$app->request->input('status');
            $is_group = Yii::$app->request->input('is_group');
            $sosomap_poi_uid = Yii::$app->request->input('sosomap_poi_uid');
            $license_no = Yii::$app->request->input('license_no');
            $license_name = Yii::$app->request->input('license_name');
            $level_num = Yii::$app->request->input('level_num');
            try {
                $bloc = StoreService::addLinkBloc($invitation_code, $business_name, $logo, $pid, $group_bloc_id, $category, $provinceCityDistrict, $address, $register_level, $longitude, $latitude, $telephone, $avg_price, $recommend, $special, $introduction, $open_time, $end_time, $status, $is_group, $sosomap_poi_uid, $license_no, $license_name, $level_num);
            } catch (HttpException $e) {
                throw new ErrorException($e->getMessage(), 400);
            }
            $this->bloc_id = $bloc['bloc_id'];
        } else {
            // $province =\Yii::$app->request->input('province');
            // $city =\Yii::$app->request->input('city');
            // $district =\Yii::$app->request->input('district');
            $end_time = Yii::$app->request->input('end_time');
            $open_time = Yii::$app->request->input('open_time');
            $status = Yii::$app->request->input('status');
            $is_group = Yii::$app->request->input('is_group');
            $sosomap_poi_uid = Yii::$app->request->input('sosomap_poi_uid');
            $license_no = Yii::$app->request->input('license_no');
            $license_name = Yii::$app->request->input('license_name');
            $level_num = Yii::$app->request->input('level_num');
            $bloc_id = $this->bloc_id;
            try {
                $bloc = StoreService::upLinkBloc($bloc_id, $invitation_code, $business_name, $logo, $pid, $group_bloc_id, $category, $provinceCityDistrict, $address, $register_level, $longitude, $latitude, $telephone, $avg_price, $recommend, $special, $introduction, $open_time, $end_time, $status, $is_group, $sosomap_poi_uid, $license_no, $license_name, $level_num);
            } catch (HttpException $e) {
                throw new ErrorException($e->getMessage(), 400);
            }
        }
        parent::beforeSave($insert);
        return true;
    }
}
