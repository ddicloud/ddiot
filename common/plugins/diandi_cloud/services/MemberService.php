<?php

/**
 * @Author: Radish (minradish@163.com)
 * @Date:   2022-09-15 Thursday
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-20 17:04:51
 */

namespace common\plugins\diandi_cloud\services;

use Yii;
use admin\models\User;
use common\models\DdCorePaylog;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\services\BaseService;
use common\helpers\loggingHelper;
use common\plugins\diandi_cloud\models\enums\{
    MemberAudit,
    MemberCertType,
    MemberCertStatus,
    MemberIsDeveloper,
    MemberCertGoldStatus,
};
use yii\web\HttpException;
use diandi\addons\models\UserBloc;
use diandi\addons\models\DdAddons;
use common\helpers\LevelTplHelper;
use diandi\addons\models\BlocStore;
use diandi\addons\models\StoreLabel;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\StoreLabelLink;
use api\modules\wechat\models\DdWxappFans;
use diandi\addons\models\searchs\StoreCategory;
use diandi\addons\models\searchs\BlocStoreSearch;

class MemberService extends BaseService
{
    use \addons\diandi_cloud\components\ResultServicesTrait;

    public static function initData()
    {
        self::$modelNamespace = 'addons\diandi_cloud\models\MemberExpand';
        // self::$isSoftDelete = true;
        // self::$isCheckBlocId = true;
        self::$modelTitle = '用户';
    }

    /**
     * 注册成为开发者
     * @param array $data
     * @date 2022-09-16
     * @author Radish
     */
    public static function registerDeveloper($data)
    {
        self::initData();
        $model = self::$modelNamespace::find()->where(['member_id' => Yii::$app->user->identity->member_id])->one();
        if ($model && $model->is_developer == MemberIsDeveloper::VALID) {
            return ResultHelper::json(400, '已注册为开发者，请勿重复注册！', []);
        } else {
            $user = new User();
            $data = Yii::$app->request->post();
            $username = $data['admin_username'];
            $mobile = $data['admin_mobile'];
            $email = $data['admin_email'];
            $password = $data['admin_password'];
            if (empty($username)) {
                return ResultHelper::json(400, '用户名不能为空', []);
            }
            if (empty($mobile)) {
                return ResultHelper::json(400, '手机号不能为空', []);
            }
            if (empty($password)) {
                return ResultHelper::json(400, '密码不能为空', []);
            }
            $res = $user->signup($username, $mobile, $email, $password);
            if (isset($res['user']) && $res['user']) {
                if (!$model) {
                    $model = new self::$modelNamespace;
                    $model->member_id = \Yii::$app->user->identity->member_id??0;
                    $model->pay_no = \Yii::$app->user->identity->member_id . date('YmdHis');
                }
                $model->is_developer = MemberIsDeveloper::VALID;
                $model->cert_gold = 300;
                $model->cert_gold_status = MemberCertGoldStatus::INVALID;
                $model->cert_type = MemberCertType::NOT;
                $model->admin_id = $res['user']['id'];
                $model->cert_status = MemberCertStatus::INVALID;
                if ($model->save(false)) {
                    try {
                        $bool = self::_addonsCreate($model);
                    } catch (\Throwable $th) {
                        $bool = false;
                        loggingHelper::writeLog('diandi_cloud', 'member', '_addonsCreate', $th->getMessage());
                    }
                    if ($bool === true) {
                        return ResultHelper::json(200, '注册成功', []);
                    } else {
                        return ResultHelper::json(200, '注册成功,创建商户信息失败,请登录后台创建对应商户！', []);
                    }
                } else {
                    return ResultHelper::json(400, '注册失败！', []);
                }
            } else {
                return ResultHelper::json(200, '注册成功', $res);
            }
        }
    }

    /**
     * 支付认证金
     * @date 2022-09-19
     * @author Radish
     */
    public static function pay($where, $payType = 0)
    {
        static::initData();
        $model = self::$modelNamespace::find()->andWhere($where)->andWhere(['cert_gold_status' => MemberCertGoldStatus::INVALID])->one();
        if ($model) {
            $bool = false;
            switch ($payType) {
                case 0:
                    $bool = $model->wechatPay();
                    break;
                default:
                    $model->addError('id', '无效的支付方式！');
                    break;
            }
            if ($bool === false) {
                return [false, $model];
            } else {
                return [true, $bool];
            }
        } else {
            $model = new self::$modelNamespace;
            $model->addError('id', '无效的待支付的' . self::$modelTitle . '信息！');
            return [false, $model];
        }
    }

    // 写入订单支付日志
    public static function createPayLog($member)
    {
        $fans = DdWxappFans::getFansByUid($member->member_id);
        $corePaylog = DdCorePaylog::find()->where(['uniontid' => $member->pay_no])->one();
        if (!$corePaylog) {
            $openid = $fans['openid'];
            $data = [
                'type' => 'wechat',
                'openid' => $openid,
                'member_id' => $member->member_id,
                'uniontid' => $member->pay_no,
                'fee' => $member->cert_gold,
                'status' => 0,
                'module' => 'diandi_cloud',
                'tag' => '开发者认证金',
            ];
            $corePaylog = new DdCorePaylog();
            $corePaylog->load($data, '');
            $res = $corePaylog->save();
            if ($res) {
                return $corePaylog;
            } else {
                return false;
            }
        } else {
            return $corePaylog;
        }
    }

    /**
     * 提交认证审核
     * @param array $where
     * @param array $data
     * @date 2022-09-19
     * @author Radish
     */
    public static function submitAudit($where, $data)
    {
        self::initData();
        $memberExpand = self::$modelNamespace::find()->where($where)->one();
        if ($memberExpand) {
            $memberExpand->scenario = 'submit_audit';
            $memberExpand->audit = MemberAudit::WAIT;
            if ($memberExpand->load($data, '') && $memberExpand->save()) {
                return [true, $memberExpand];
            } else {
                return [false, $memberExpand];
            }
        } else {
            $memberExpand = new self::$modelNamespace;
            $memberExpand->addError('member_id', '请先注册成为开发者！');
            return [false, $memberExpand];
        }
    }

    /**
     * 开发者详情
     * @param array $where
     * @date 2022-09-20
     * @author Radish
     */
    public static function detail($where)
    {
        self::initData();
        $query = self::$modelNamespace::find()->where($where)->with('member');
        return self::selectOne($query);
    }

    /**
     * 通过应用ID创建商户
     * @date 2022-09-20
     * @author Radish
     */
    private static function _addonsCreate($memberExpand)
    {
        $adminUser = User::findOne(['id' => $memberExpand->admin_id]);
        $data = [
            'longitude' => '',
            'latitude' => '',
            'category_id' => '5',
            'category_pid' => '6',
            'bloc_id' => $adminUser->bloc_id,
            'name' => '开发者应用中心',
            'status' => '1',
        ];
        $model = new BlocStore([
            'extras' => '',
        ]);
        $modelcate = new StoreCategory();
        $helper = new LevelTplHelper([
            'pid' => 'parent_id',
            'cid' => 'category_id',
            'title' => 'name',
            'model' => $modelcate,
            'id' => 'category_id',
        ]);
        // $link = new StoreLabelLink();
        $data['lng_lat'] = json_encode([
            'lng' => $data['longitude'],
            'lat' => $data['latitude'],
        ]);
        $addons = DdAddons::find()->where(['identifie' => 'diandi_hub'])->one();
        if (!$addons) {
            throw new HttpException(400, '无效的应用模块!');
        }
        $transaction = Yii::$app->db->beginTransaction();
        if ($model->load($data, '') && $model->save()) {
            try {
                // $StoreLabelLink = $_GPC['StoreLabelLink'];
                // if (!empty($StoreLabelLink['label_id'])) {
                //     foreach ($StoreLabelLink['label_id'] as $key => $label_id) {
                //         $_link = clone  $link;
                //         $bloc_id = $model->bloc_id;
                //         $store_id = $model->store_id;
                //         $data = [
                //             'bloc_id' => $bloc_id,
                //             'store_id' => $store_id,
                //             'label_id' => $label_id,
                //         ];
                //         $_link->setAttributes($data);
                //         if (!$_link->save()) {
                //             throw new \Exception("保存标签数据失败!");
                //         }
                //     }
                // }
                $addonsUser = AddonsUser::find()->andWhere([
                    'module_name' => $addons->getAttribute('identifie'),
                    'user_id' => $memberExpand->admin_id,
                ])->one();
                if (!$addonsUser) {
                    $addonsUser = new AddonsUser();
                    $addonsUser->module_name = $addons->getAttribute('identifie');
                    $addonsUser->user_id = $memberExpand->admin_id;
                    $addonsUser->store_id = $model->store_id;
                    $addonsUser->type = 1;
                    $addonsUser->status = 1;
                    $addonsUser->is_default = AddonsUser::find()->andWhere(['user_id' => $memberExpand->admin_id])->andWhere('is_default = 1')->exists() ? 0 : 1;
                    if (!$addonsUser->save()) {
                        throw new \Exception("保存用户模块数据失败!");
                    }
                }
                $user = User::find()->where(['id' => $memberExpand->admin_id])->one();
                if ($user->store_id == 0) {
                    $user->store_id = $model->store_id;
                    if (!$user->save(false)) {
                        throw new \Exception("保存用户数据失败!");
                    }
                }
                $transaction->commit();
                $tempData = [
                    'user_id' => $memberExpand->admin_id,
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
                            loggingHelper::writeLog('diandi_cloud', 'member', '_addonsCreate', $userBloc->getErrors());
                        }
                    } else {
                        $userBloc = new UserBloc();
                        $tempData['is_default'] = 1;
                        if (!($userBloc->load($tempData, '') && $userBloc->save())) {
                            loggingHelper::writeLog('diandi_cloud', 'member', '_addonsCreate', $userBloc->getErrors());
                        }
                    }
                }
                return true;
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
