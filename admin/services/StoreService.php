<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-26 15:43:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-20 11:23:43
 */

namespace admin\services;

use admin\models\User;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\models\UserBloc;
use common\models\UserStore;
use common\services\BaseService;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\Bloc;
use diandi\addons\models\BlocStore;
use diandi\addons\models\DdAddons;
use diandi\addons\models\StoreLabelLink;
use Yii;
use yii\web\HttpException;

class StoreService extends BaseService
{
    /**
     * 用户创建店铺.注册后用户自主创建店铺
     *
     * @param [type] $data   店铺数据
     * @param [type] $mid    模块ID
     * @param array  $extras 商户扩展字段
     *
     * @return void
     * @date 2022-10-26
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function createStore($data, $mid, $extras = [])
    {
        loggingHelper::writeLog('StoreService', 'createStore', '创建初始数据', [
            'data' => $data,
            'mid' => $mid,
            'extras' => $extras,
        ]);

        $model = new BlocStore([
            'extras' => $extras,
        ]);

        $link = new StoreLabelLink();
        $data['lng_lat'] = json_encode([
            'lng' => $data['longitude'],
            'lat' => $data['latitude'],
        ]);
        $addons = DdAddons::find()->where(['mid' => $mid ?? 0])->select('identifie')->scalar();
        loggingHelper::writeLog('StoreService', 'createStore', '模块', $addons);
        if (!$addons) {
            throw new HttpException(400, '无效的应用模块ID!');
        }
        $transaction = Yii::$app->db->beginTransaction();
        if ($model->load($data, '') && $model->save()) {
            loggingHelper::writeLog('StoreService', 'createStore', '商户基础数据创建完成', $model);

            try {
                // 保存商户标签
                $StoreLabelLink = $data['StoreLabelLink'];
                if (!empty($StoreLabelLink['label_id'])) {
                    foreach ($StoreLabelLink['label_id'] as $key => $label_id) {
                        $_link = clone $link;
                        $bloc_id = $model->bloc_id;
                        $store_id = $model->store_id;
                        $data = [
                            'bloc_id' => $bloc_id,
                            'store_id' => $store_id,
                            'label_id' => $label_id,
                        ];
                        $_link->setAttributes($data);
                        if (!$_link->save()) {
                            throw new \Exception('保存标签数据失败!');
                        }
                    }
                }

                // 给用户授权应用权限
                $addonsUser = AddonsUser::find()->andWhere([
                    'module_name' => $addons,
                    'user_id' => Yii::$app->user->identity->user_id,
                    'store_id' => $model->store_id,
                ])->one();
                loggingHelper::writeLog('StoreService', 'createStore', 'addonsUser', $addonsUser);

                if (!$addonsUser) {
                    $addonsUser = new AddonsUser();
                    $addonsUser->module_name = $addons;
                    $addonsUser->user_id = Yii::$app->user->identity->user_id;
                    $addonsUser->store_id = $model->store_id;
                    $addonsUser->type = 1;
                    $addonsUser->status = 1;
                    $addonsUser->is_default = AddonsUser::find()->andWhere(['user_id' => Yii::$app->user->id])->andWhere('is_default = 1')->exists() ? 0 : 1;
                    if (!$addonsUser->save()) {
                        throw new \Exception('保存用户模块数据失败!');
                    }
                }
                $user = User::find()->where(['id' => Yii::$app->user->identity->user_id])->one();
                if ($user->store_id == 0) {
                    $user->store_id = $model->store_id;
                    if (!$user->save(false)) {
                        throw new \Exception('保存用户数据失败!');
                    }
                }
                $user_id = Yii::$app->user->identity->user_id;
                // 初始权限
                UserService::AssignmentPermissionByUid($user_id, $addons);

                $tempData = [
                    'user_id' => Yii::$app->user->id,
                    'bloc_id' => $model->bloc_id,
                    'store_id' => $model->store_id,
                    'is_default' => 1,
                    'status' => 1,
                ];

                //给用户授权商户权限
                $userStoreBool = userStore::find()->where($tempData)->exists();
                if (!$userStoreBool) {
                    unset($tempData['is_default']);
                    $userStore = userStore::find()->andWhere($tempData)->one();
                    if ($userStore) {
                        $userStore->is_default = 1;
                        if (!$userStore->save(false)) {
                            loggingHelper::writeLog('Store', 'store', '_addonsCreate', $userStore->getErrors());
                        }
                    } else {
                        $userStore = new userStore();
                        $tempData['is_default'] = 1;
                        if (!($userStore->load($tempData, '') && $userStore->save())) {
                            loggingHelper::writeLog('Store', 'store', '_addonsCreate', $userStore->getErrors());
                        }
                    }
                }

                $transaction->commit();

                return $model;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new HttpException(400, $e->getMessage());
            }
        } else {
            $transaction->rollBack();
            $msg = ErrorsHelper::getModelError($model);
            throw new HttpException(400, $msg);
        }
    }

    /**
     * 更新关联店铺数据
     * @param [type] $store_id
     * @param [type] $data
     * @return void
     * @date 2023-03-08
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function upLinkStore($store_id, $bloc_id,$category,$provinceCityDistrict,$name,$logo,$address,$longitude,$latitude,$mobile,$status,$label_link=[])
    {
        $model = BlocStore::findOne($store_id);

        $link = new StoreLabelLink();
        $lng_lat = json_encode([
            'lng' => $longitude,
            'lat' => $latitude,
        ]);

        $storeData = [
            'category_id' => (int) $category[1],
            'category_pid' => (int) $category[0],
            'name' => $name,
            'logo' => $logo,
            'bloc_id' => (int) $bloc_id,
            'province' => (int) $provinceCityDistrict[0],
            'city' => (int) $provinceCityDistrict[1],
            'county' => (int) $provinceCityDistrict[2],
            'address' => $address,
            'mobile' => $mobile,
            'status' => $status,
            'lng_lat' => $lng_lat,
            'longitude' =>(string) $longitude,
            'latitude' => (string)$latitude,
        ];
        loggingHelper::writeLog('StoreService', 'addLinkStore', '创建初始数据', [
            'data' => $storeData,
        ]);
        $transaction = Yii::$app->db->beginTransaction();
        if ($model->load($storeData, '') && $model->save()) {
            loggingHelper::writeLog('StoreService', 'createStore', '商户基础数据创建完成', $model);

            try {
                // 保存商户标签
                $StoreLabelLink = $label_link;
                if (!empty($StoreLabelLink)) {
                    $link->deleteAll(['store_id' => $store_id]);
                    foreach ($StoreLabelLink as $key => $label_id) {
                        $_link = clone $link;
                        $bloc_id = $model->bloc_id;
                        $store_id = $model->store_id;
                        $data = [
                            'bloc_id' => $bloc_id,
                            'store_id' => $store_id,
                            'label_id' => $label_id,
                        ];
                        $_link->setAttributes($data);
                        if (!$_link->save()) {
                            throw new \Exception('保存标签数据失败!');
                        }
                    }
                }

                $transaction->commit();

                return $model;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new HttpException(400, $e->getMessage());
            }
        } else {
            $transaction->rollBack();
            $msg = ErrorsHelper::getModelError($model);
            throw new HttpException(400, $msg);
        }
    }

    /**
     * 新建店铺数据关联全局
     * @return void
     * @date 2023-03-03
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function addLinkStore($user_id,$bloc_id,$category,$provinceCityDistrict,$name,$logo,$address,$longitude,$latitude,$mobile,$status,$label_link=[])
    {
        if($user_id){
            throw new \Exception('用户ID不能为空!');
        }
        $model = new BlocStore([
            'extras' => [],
        ]);

        $link = new StoreLabelLink();
        $lng_lat = json_encode([
            'lng' => $longitude,
            'lat' => $latitude,
        ]);

        $storeData = [
            'category_id' => (int) $category[1],
            'category_pid' =>(int) $category[0],
            'name' => $name,
            'logo' => $logo,
            'bloc_id' => $bloc_id,
            'province' => (int) $provinceCityDistrict[0],
            'city' => (int) $provinceCityDistrict[1],
            'county' => (int) $provinceCityDistrict[2],
            'address' => $address,
            'mobile' => $mobile,
            'status' => $status,
            'lng_lat' => $lng_lat,
            'longitude' => (string) $longitude,
            'latitude' => (string) $latitude,
        ];
        loggingHelper::writeLog('StoreService', 'addLinkStore', '创建初始数据', [
            'data' => $storeData,
        ]);

        $transaction = Yii::$app->db->beginTransaction();
        if ($model->load($storeData, '') && $model->save()) {
            loggingHelper::writeLog('StoreService', 'createStore', '商户基础数据创建完成', $model);

            try {
                // 保存商户标签
                $StoreLabelLink = $label_link;
                if (!empty($StoreLabelLink)) {
                    foreach ($StoreLabelLink as $key => $label_id) {
                        $_link = clone $link;
                        $bloc_id = $model->bloc_id;
                        $store_id = $model->store_id;
                        $data = [
                            'bloc_id' => $bloc_id,
                            'store_id' => $store_id,
                            'label_id' => $label_id,
                        ];
                        $_link->setAttributes($data);
                        if (!$_link->save()) {
                            throw new \Exception('保存标签数据失败!');
                        }
                    }
                }

                $user = User::find()->where(['id' => $user_id])->one();
                if ($user->store_id == 0) {
                    $user->store_id = $model->store_id;
                    if (!$user->save(false)) {
                        throw new \Exception('保存用户数据失败!');
                    }
                }
                // $user_id = Yii::$app->user->identity->user_id;
                // 初始权限
                UserService::addUserBloc($user_id, $bloc_id, $store_id, 0);
                $tempData = [
                    'user_id' => Yii::$app->user->id,
                    'bloc_id' => $model->bloc_id,
                    'store_id' => $model->store_id,
                    'is_default' => 1,
                    'status' => 1,
                ];

                //给用户授权商户权限
                $userStoreBool = userStore::find()->where($tempData)->exists();
                if (!$userStoreBool) {
                    unset($tempData['is_default']);
                    $userStore = userStore::find()->andWhere($tempData)->one();
                    if ($userStore) {
                        $userStore->is_default = 1;
                        if (!$userStore->save(false)) {
                            loggingHelper::writeLog('Store', 'store', '_addonsCreate', $userStore->getErrors());
                        }
                    } else {
                        $userStore = new userStore();
                        $tempData['is_default'] = 1;
                        if (!($userStore->load($tempData, '') && $userStore->save())) {
                            loggingHelper::writeLog('Store', 'store', '_addonsCreate', $userStore->getErrors());
                        }
                    }
                }

                $transaction->commit();

                return $model;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new HttpException(400, $e->getMessage());
            }
        } else {
            $transaction->rollBack();
            $msg = ErrorsHelper::getModelError($model);
            throw new HttpException(400, $msg);
        }
    }

    /**
     * 用户添加公司
     * @param [type] $invitation_code
     * @param [type] $business_name
     * @param [type] $logo
     * @param [type] $pid
     * @param [type] $group_bloc_id
     * @param [type] $category
     * @param array $provinceCityDistrict
     * @param [type] $address
     * @param [type] $register_level
     * @param [type] $longitude
     * @param [type] $latitude
     * @param [type] $telephone
     * @param [type] $avg_price
     * @param [type] $recommend
     * @param [type] $special
     * @param [type] $introduction
     * @param [type] $open_time
     * @param [type] $status
     * @param [type] $is_group
     * @param [type] $sosomap_poi_uid
     * @param [type] $license_no
     * @param [type] $license_name
     * @param [type] $level_num
     * @return void
     * @date 2023-06-19
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function addLinkBloc($invitation_code,$business_name,$logo,$pid,$group_bloc_id,$category,$provinceCityDistrict= [],$address,$register_level,$longitude,$latitude,$telephone,$avg_price,$recommend,$special,$introduction,$open_time,$end_time,$status,$is_group,$sosomap_poi_uid,$license_no,$license_name,$level_num)
    {
       

        $model = new Bloc();

        $blocData = [
            'invitation_code' => $invitation_code,
            'business_name' => $business_name,
            'logo' => $logo,
            'pid' => (int) $pid,
            'group_bloc_id' => $group_bloc_id,
            'category' => (int) $category,
            'province' => (int) $provinceCityDistrict[0],
            'city' => (int) $provinceCityDistrict[1],
            'district' => (int) $provinceCityDistrict[2],
            'address' => $address,
            'register_level' => $register_level,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'telephone' => $telephone,
            'avg_price' => $avg_price,
            'recommend' => $recommend,
            'special' => $special,
            'introduction' => $introduction,
            'end_time' => $end_time,
            'open_time' => $open_time,
            'status' => (int) $status,
            'is_group' => (int) $is_group,
            'sosomap_poi_uid' => (int) $sosomap_poi_uid,
            'license_no' => $license_no,
            'license_name' => $license_name,
            'level_num' => (int) $level_num,
        ];
        
        loggingHelper::writeLog('StoreService', 'addLinkStore', '创建初始数据',$blocData);
        
        $transaction = Yii::$app->db->beginTransaction();
        if ($model->load($blocData, '') && $model->save()) {
            loggingHelper::writeLog('StoreService', 'createStore', '商户基础数据创建完成', $model);

            $bloc_id = $model->bloc_id;

            try {

                $user = User::find()->where(['id' => Yii::$app->user->identity->user_id])->one();
                if ($user->store_id == 0) {
                    $user->store_id = $model->store_id;
                    if (!$user->save(false)) {
                        throw new \Exception('保存用户数据失败!');
                    }
                }
                $user_id = Yii::$app->user->identity->user_id;
                // 初始权限
                $store_id = 0;
                UserService::addUserBloc($user_id, $bloc_id, $store_id, 0);

                $transaction->commit();

                return $model;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new HttpException(400, $e->getMessage());
            }
        } else {
            $transaction->rollBack();
            $msg = ErrorsHelper::getModelError($model);
            throw new HttpException(400, $msg);
        }
    }

    /**
     * 用户编辑公司
     * @param [type] $bloc_id
     * @param [type] $invitation_code
     * @param [type] $business_name
     * @param [type] $logo
     * @param [type] $pid
     * @param [type] $group_bloc_id
     * @param [type] $category
     * @param array $provinceCityDistrict
     * @param [type] $address
     * @param [type] $register_level
     * @param [type] $longitude
     * @param [type] $latitude
     * @param [type] $telephone
     * @param [type] $avg_price
     * @param [type] $recommend
     * @param [type] $special
     * @param [type] $introduction
     * @param [type] $open_time
     * @param [type] $status
     * @param [type] $is_group
     * @param [type] $sosomap_poi_uid
     * @param [type] $license_no
     * @param [type] $license_name
     * @param [type] $level_num
     * @return void
     * @date 2023-06-19
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function upLinkBloc($bloc_id, $invitation_code,$business_name,$logo,$pid,$group_bloc_id,$category,$provinceCityDistrict= [],$address,$register_level,$longitude,$latitude,$telephone,$avg_price,$recommend,$special,$introduction,$open_time,$end_time,$status,$is_group,$sosomap_poi_uid,$license_no,$license_name,$level_num)
    {
       

        $model = Bloc::findOne($bloc_id);

        $blocData = [
            'invitation_code' => $invitation_code,
            'business_name' => $business_name,
            'logo' => $logo,
            'pid' => (int) $pid,
            'group_bloc_id' =>(int) $group_bloc_id,
            'category' =>(int) $category,
            'province' => (int) $provinceCityDistrict[0],
            'city' => (int) $provinceCityDistrict[1],
            'district' => (int) $provinceCityDistrict[2],
            'address' => $address,
            'register_level' => $register_level,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'telephone' => $telephone,
            'avg_price' => $avg_price,
            'recommend' => $recommend,
            'special' => $special,
            'introduction' => $introduction,
            'open_time' => $open_time,
            'end_time' => $end_time,
            'status' =>(int) $status,
            'is_group' => (int) $is_group,
            'sosomap_poi_uid' => (int) $sosomap_poi_uid,
            'license_no' => $license_no,
            'license_name' => $license_name,
            'level_num' =>(int) $level_num,
        ];
        
        loggingHelper::writeLog('StoreService', 'addLinkStore', '创建初始数据', [
            'data' => $blocData,
        ]);

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($model->load($blocData, '') && $model->save()) {
                loggingHelper::writeLog('StoreService', 'createStore', '商户基础数据创建完成', $model);

                $bloc_id = $model->bloc_id;

                $user = User::find()->where(['id' => Yii::$app->user->identity->user_id])->one();
                if ($user->store_id == 0) {
                    $user->store_id = $model->store_id;
                    if (!$user->save(false)) {
                        throw new \Exception('保存用户数据失败!');
                    }
                }

                $transaction->commit();

                return $model;
            } else {
                $msg = ErrorsHelper::getModelError($model);
                throw new HttpException(400, $msg);
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new HttpException(400, $e->getMessage());
        }
    }

    /**
     * 获取公司与商户级联数据，表单级联使用
     * @return void
     * @date 2023-03-04
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function getStoresAndBloc()
    {
        $user_stores = UserStore::find()->where(['user_id' => Yii::$app->user->identity->user_id])->select('store_id')->column();

        $user_blocs = UserBloc::find()->where(['user_id' => Yii::$app->user->identity->user_id])->with(['bloc' => function ($query) {
            return $query->with(['store'])->asArray();
        }])->asArray()->all();

        $blocs = [];
        $BlocStore = BlocStore::find()->indexBy('store_id')->asArray()->all();
        foreach ($user_blocs as $key => $value) {
            $stores = [];

            if (!empty($value['bloc'])) {
                $blocs[$value['bloc_id']] = [
                    "label" => $value['bloc']['business_name'],
                    "value" => $value['bloc']['bloc_id'],
                    "bloc_id" => $value['bloc']['bloc_id'],
                ];
            }

            if (!empty($value['bloc']['store'])) {
                foreach ($value['bloc']['store'] as $k => $val) {
                    $store_id = $val['store_id'];
                    if (!empty($user_stores) && !in_array($store_id, $user_stores)) {
                        continue;
                    } else {
                        $stores[] = [
                            "label" =>  $BlocStore[$store_id]['name'],
                            "value" => $store_id,
                            "store_id" => $store_id,
                            "bloc_id" => $value['bloc']['bloc_id'],

                        ];
                    }
                }
            }
            $blocs[$value['bloc_id']]['children'] = $stores;
        }

        return array_values($blocs);
    }

    /**
     * 获取公司授权数据，检索使用
     * @return void
     * @date 2023-03-04
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function getAuthBlos()
    {
        $user_blocs = UserBloc::find()->where(['user_id' => Yii::$app->user->identity->user_id])->with(['bloc'])->asArray()->all();
        $lists = [];
        foreach ($user_blocs as $key => $value) {
            if ($value['bloc']) {
                $lists[$value['bloc_id']] = [
                    'id' => $value['bloc_id'],
                    'name' => $value['bloc']['business_name'],
                    'text' => $value['bloc']['business_name'],
                    "label" => $value['bloc']['business_name'],
                    "value" => $value['bloc_id'],
                ];
            }
        }
        return array_values($lists);
    }

    /**
     * 获取商户授权数据，检索使用
     * @return void
     * @date 2023-03-04
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function getAuthStores()
    {
        $user_blocs = UserStore::find()->where(['user_id' => Yii::$app->user->identity->user_id])->with(['store'])->asArray()->all();
        $lists = [];
        foreach ($user_blocs as $key => $value) {
            if ($value['store']) {
                $lists[$value['store_id']] = [
                    'id' => $value['store_id'],
                    'bloc_id' => $value['store']['bloc_id'],
                    'name' => $value['store']['name'],
                    'text' => $value['store']['name'],
                    "label" => $value['store']['name'],
                    "value" => $value['store_id'],
                ];
            }
        }
        return array_values($lists);
    }

    public static function checkStoreNum($bloc_id)
    {
        $bloc = Bloc::find()->where(['bloc_id' => $bloc_id])->with(['store'])->asArray()->one();

        if ($bloc['store_num'] <= count($bloc['store'])) {
            return false;
        }

        return true;
    }

    public static function deleteStore($store_id)
    {
        // 删除全局商户
        BlocStore::deleteAll([
            'store_id' => $store_id
        ]);
        // 删除商户授权
        UserStore::deleteAll([
            'store_id' => $store_id,
            'user_id' => Yii::$app->user->identity->user_id
        ]);
    }
}
