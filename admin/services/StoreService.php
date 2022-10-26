<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-26 15:43:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-26 15:55:52
 */

namespace admin\services;

use admin\models\User;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\models\UserBloc;
use common\services\BaseService;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\BlocStore;
use diandi\addons\models\DdAddons;
use diandi\addons\models\StoreLabelLink;
use Yii;
use yii\web\HttpException;

class StoreService extends BaseService
{
    /**
     * 用户创建店铺.
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
        $model = new BlocStore([
            'extras' => $extras,
        ]);

        $link = new StoreLabelLink();
        $data['lng_lat'] = json_encode([
                'lng' => $data['longitude'],
                'lat' => $data['latitude'],
            ]);
        $addons = DdAddons::find()->where(['mid' => $mid ?? 0])->select('identifie')->scalar();
        if (!$addons) {
            throw new HttpException(400, '无效的应用模块ID!');
        }
        $transaction = Yii::$app->db->beginTransaction();
        if ($model->load($data, '') && $model->save()) {
            try {
                $StoreLabelLink = $data['StoreLabelLink'];
                if (!empty($StoreLabelLink['label_id'])) {
                    foreach ($StoreLabelLink['label_id'] as $key => $label_id) {
                        $_link = clone  $link;
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
                $addonsUser = AddonsUser::find()->andWhere([
                        'module_name' => $addons,
                        'user_id' => Yii::$app->user->identity->user_id,
                    ])->one();
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
                UserService::AssignmentPermissionByUid($user_id, '');

                $tempData = [
                        'user_id' => Yii::$app->user->id,
                        'bloc_id' => $model->bloc_id,
                        'store_id' => $model->store_id,
                        'is_default' => 1,
                        'status' => 1,
                    ];
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
}
