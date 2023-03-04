<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-26 15:43:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-04 13:40:11
 */

namespace admin\services;

use admin\models\User;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\models\UserBloc;
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
                $userBlocBool = UserBloc::find()->where($tempData)->exists();
                if (!$userBlocBool) {
                    unset($tempData['is_default']);
                    $userBloc = UserBloc::find()->andWhere($tempData)->one();
                    if ($userBloc) {
                        $userBloc->is_default = 1;
                        if (!$userBloc->save(false)) {
                            loggingHelper::writeLog('Store', 'store', '_addonsCreate', $userBloc->getErrors());
                        }
                    } else {
                        $userBloc = new UserBloc();
                        $tempData['is_default'] = 1;
                        if (!($userBloc->load($tempData, '') && $userBloc->save())) {
                            loggingHelper::writeLog('Store', 'store', '_addonsCreate', $userBloc->getErrors());
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
    public static function addLinkStore($data)
    {
        loggingHelper::writeLog('StoreService', 'addLinkStore', '创建初始数据', [
            'data' => $data,
        ]);

        $model = new BlocStore([
            'extras' => [],
        ]);

        $link = new StoreLabelLink();
        $data['lng_lat'] = json_encode([
            'lng' => $data['longitude'],
            'lat' => $data['latitude'],
        ]);

        $storeData = [
            'category_id' => $data['category'][0],
            'category_pid' => $data['category'][1],
            'name' => $data['name'],
            'logo' => $data['logo'],
            'bloc_id' => $data['bloc_id'],
            'province' => $data['provinceCityDistrict'][0],
            'city' => $data['provinceCityDistrict'][1],
            'county' => $data['provinceCityDistrict'][2],
            'address' => $data['address'],
            'mobile' => $data['mobile'],
            'create_time' => $data['create_time'],
            'update_time' => $data['update_time'],
            'status' => $data['status'],
            'lng_lat' => $data['lng_lat'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
        ];

        $transaction = Yii::$app->db->beginTransaction();
        if ($model->load($storeData, '') && $model->save()) {
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

                $user = User::find()->where(['id' => Yii::$app->user->identity->user_id])->one();
                if ($user->store_id == 0) {
                    $user->store_id = $model->store_id;
                    if (!$user->save(false)) {
                        throw new \Exception('保存用户数据失败!');
                    }
                }
                $user_id = Yii::$app->user->identity->user_id;
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
                $userBlocBool = UserBloc::find()->where($tempData)->exists();
                if (!$userBlocBool) {
                    unset($tempData['is_default']);
                    $userBloc = UserBloc::find()->andWhere($tempData)->one();
                    if ($userBloc) {
                        $userBloc->is_default = 1;
                        if (!$userBloc->save(false)) {
                            loggingHelper::writeLog('Store', 'store', '_addonsCreate', $userBloc->getErrors());
                        }
                    } else {
                        $userBloc = new UserBloc();
                        $tempData['is_default'] = 1;
                        if (!($userBloc->load($tempData, '') && $userBloc->save())) {
                            loggingHelper::writeLog('Store', 'store', '_addonsCreate', $userBloc->getErrors());
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
     * @param [type] $data
     * @return void
     * @date 2023-03-03
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function addLinkBloc($data)
    {
        loggingHelper::writeLog('StoreService', 'addLinkStore', '创建初始数据', [
            'data' => $data,
        ]);

        $model = new Bloc();

        $blocData = [
            'invitation_code' => $data['invitation_code'],
            'business_name' => $data['business_name'],
            'logo' => $data['logo'],
            'pid' => $data['pid'],
            'group_bloc_id' => $data['group_bloc_id'],
            'category' => $data['category'],
            'province' => $data['provinceCityDistrict'][0],
            'city' => $data['provinceCityDistrict'][1],
            'district' => $data['provinceCityDistrict'][2],
            'address' => $data['address'],
            'register_level' => $data['register_level'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            'telephone' => $data['telephone'],
            'avg_price' => $data['avg_price'],
            'recommend' => $data['recommend'],
            'special' => $data['special'],
            'introduction' => $data['introduction'],
            'open_time' => $data['open_time'],
            'status' => $data['status'],
            'is_group' => $data['is_group'],
            'sosomap_poi_uid' => $data['sosomap_poi_uid'],
            'license_no' => $data['license_no'],
            'license_name' => $data['license_name'],
            'level_num' => $data['level_num'],
        ];

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

    public static function getStoresAndBloc()
    {
        $user_blocs = UserBloc::find()->where(['user_id' => Yii::$app->user->identity->user_id])->with(['bloc', 'store'])->asArray()->all();
        $blocs = [];
        $stores = [];
        foreach ($user_blocs as $key => $value) {
            if (!empty($value['bloc'])) {
                $blocs[$value['bloc_id']] = [
                    "label" => $value['bloc']['business_name'],
                    "value" => $value['bloc']['bloc_id'],
                ];
            }

            if (!empty($value['store'])) {
                $blocs[$value['bloc_id']]['children'][] = [
                    "label" => $value['store']['name'],
                    "value" => $value['store']['store_id'],
                ];
            } else {
                unset($blocs[$value['bloc_id']]);
            }
        }

        return array_values($blocs);
    }
}
