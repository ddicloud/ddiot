<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-05 11:45:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-10 20:21:45
 */

namespace admin\controllers;

use admin\models\forms\EdituserinfoForm;
use admin\models\forms\LoginForm;
use admin\models\User;
use admin\services\UserService;
use api\models\DdApiAccessToken;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\ActionLog;
use common\models\DdMember as ModelsDdMember;
use common\models\DdWebsiteContact;
use common\models\forms\PasswdForm;
use common\models\UserBloc;
use common\models\UserStore;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\form\Api;
use diandi\admin\components\UserStatus;
use diandi\admin\models\AuthAssignmentGroup;
use diandi\admin\models\searchs\User as ModelsUser;
use diandi\admin\models\User as AdminModelsUser;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class UserController extends AController
{
    public $modelClass = 'admin\models\User';

    protected $authOptional = ['login', 'signup', 'repassword', 'sendcode', 'forgetpass', 'refresh'];

    public $searchLevel = 0;

    public function actionUserlist()
    {
        $searchModel = new ModelsUser([
            'module_name' => 'sys',
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSignup()
    {
        $User = new User();
        $data = Yii::$app->request->post();
        $username = $data['username'];
        $mobile = $data['mobile'];
        $email = $data['email'];
        $password = $data['password'];
        $invitation_code = trim($data['invitation_code']);

        if (empty($username)) {
            return ResultHelper::json(401, '用户名不能为空', []);
        }
        if (empty($mobile)) {
            return ResultHelper::json(401, '手机号不能为空', []);
        }
        if (empty($password)) {
            return ResultHelper::json(401, '密码不能为空', []);
        }

        $res = $User->signup($username, $mobile, $email, $password, 1, $invitation_code);

        return ResultHelper::json(200, '注册成功', $res);
    }

    public function actionLogin()
    {
        global $_GPC;

        \YII::beginProfile('actionLogin');

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $userinfo = $model->login()) {
            return ResultHelper::json(200, '登录成功', $userinfo);
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json('401', $message);
        }
        \YII::endProfile('actionLogin');
    }

    public function actionRepassword()
    {
        $model = new PasswdForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            if (!$model->validate()) {
                $res = ErrorsHelper::getModelError($model);

                return ResultHelper::json(404, $res);
            }
            /* @var $member \common\models\backend\Member */
            $data = Yii::$app->request->post();
            $mobile = $data['mobile'];
            $code = $data['code'];
            $sendcode = Yii::$app->cache->get($mobile . '_code');
            if ($code != $sendcode) {
                return ResultHelper::json(401, '验证码错误');
            }

            $member = User::findByMobile($data['mobile']);
            $member->password_hash = Yii::$app->security->generatePasswordHash($model->newpassword);
            $member->generatePasswordResetToken();
            if ($member->save()) {
                Yii::$app->user->logout();
                $service = Yii::$app->service;
                $service->namespace = 'admin';
                $userinfo = $service->AccessTokenService->getAccessToken($member, 1);
                // 清除验证码
                Yii::$app->cache->delete($mobile . '_code');

                return ResultHelper::json(200, '修改成功', $userinfo);
            }

            return ResultHelper::json(404, $this->analyErr($member->getFirstErrors()));
        } else {
            $res = ErrorsHelper::getModelError($model);

            return ResultHelper::json(404, $res);
        }
    }

    public function actionUserinfo()
    {
        global $_GPC;

        $mobile = $_GPC['mobile'];
        $is_addons = $_GPC['is_addons'];

        $data = Yii::$app->request->post();

        $user_id = Yii::$app->user->identity->user_id;

        if (!empty($mobile)) {
            $userobj = User::findByMobile($data['mobile']);
        } else {
            $userobj = User::findIdentity($user_id);
        }

        if (empty($userobj)) {
            return ResultHelper::json(401, '用户资料获取失败');
        }

        $service = Yii::$app->service;
        $service->namespace = 'admin';
        $userinfo = $service->AccessTokenService->getAccessToken($userobj, 1);

        $Website = Yii::$app->settings->getAllBySection('Website');
        unset($Website['access_key_id'],
            $Website['access_key_secret'],
            $Website['sign_name'],
            $Website['template_code'],
            $Website['themcolor']);
        $Website['blogo'] = ImageHelper::tomedia($Website['blogo']);
        $Website['flogo'] = ImageHelper::tomedia($Website['flogo']);

        $Website['themcolor'] = !empty(Yii::$app->cache->get('themcolor')) ? Yii::$app->cache->get('themcolor') : $Website['themcolor'];

        $roles = AuthAssignmentGroup::find()->where(['user_id' => $user_id])->select('item_name')->column();
        $userinfo['roles'] = $roles;
        $Api = new Api();
        $Api->getConf($userinfo['user']['bloc_id']);

        $Api['app_id'] = (int) $Api['app_id'];
        $Api['bloc_id'] = (int) $Api['bloc_id'];
        $Api['id'] = (int) $Api['id'];
        $Api['is_showall'] = (int) $Api['is_showall'];
        $Api['member_id'] = (int) $Api['member_id'];
        $Api['swoole_member_id'] = (int) $Api['swoole_member_id'];

        return ResultHelper::json(200, '获取成功', [
            'userinfo' => $userinfo,
            'Website' => $Website,
            'apiConf' => $Api,
            'apiurl' => Yii::$app->request->hostInfo,
        ]);
    }

    public function actionBindmobile()
    {
        global $_GPC;

        $code = $_GPC['code'];
        $mobile = $_GPC['mobile'];
        $sendcode = Yii::$app->cache->get($mobile . '_code');

        if ($code != $sendcode) {
            return ResultHelper::json(401, '验证码错误');
        }

        $use_id = Yii::$app->user->identity->id;
        $fields['mobile'] = $mobile;
        $res = Yii::$app->service->adminAccessTokenService->editInfo($use_id, $fields);

        if ($res) {
            return ResultHelper::json(200, '绑定手机号成功', []);
        }
    }

    public function actionEdituserinfo()
    {
        $model = new EdituserinfoForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            if (!$model->validate()) {
                $res = ErrorsHelper::getModelError($model);

                return ResultHelper::json(404, $res);
            }
            $userinfo = $model->edituserinfo();
            if ($userinfo) {
                return ResultHelper::json(200, '修改成功', $userinfo);
            }

            return ResultHelper::json(404, $this->analyErr($model->getFirstErrors()));
        } else {
            $res = ErrorsHelper::getModelError($model);

            return ResultHelper::json(404, $res);
        }
    }

    public function actionForgetpass()
    {
        global $_GPC;
        $data = Yii::$app->request->post();
        $mobile = $_GPC['mobile'];
        $password = $_GPC['password'];
        $repassword = $_GPC['repassword'];
        $code = $_GPC['sms_code'];
        $sendcode = Yii::$app->cache->get($mobile . '_code');

        $settings = Yii::$app->settings;
        $settings->invalidateCache();
        $info = $settings->getAllBySection('Website');
        if (empty($mobile)) {
            return ResultHelper::json(401, '手机号不能为空');
        }

        if (empty($password)) {
            return ResultHelper::json(401, '密码不能为空');
        }

        if (empty($repassword)) {
            return ResultHelper::json(401, '确认密码不能为空');
        }

        if (trim($repassword) != trim($password)) {
            return ResultHelper::json(401, '两次输入的密码不同');
        }

        if ((int) $info['is_send_code'] === 1) {
            if (empty($code)) {
                return ResultHelper::json(401, '验证码不能为空');
            }
            if ($code != $sendcode) {
                return ResultHelper::json(401, '验证码错误');
            }
        }
        $member = User::findByMobile($mobile);
        if (empty($member)) {
            return ResultHelper::json(401, '该账户不存在或未通过审核');
        }

        $res = Yii::$app->service->adminAccessTokenService->forgetpassword($member, $mobile, $password);
        if ($res) {
            // 清除验证码
            Yii::$app->cache->delete($mobile . '_code');

            return ResultHelper::json(200, '修改成功', []);
        } else {
            return ResultHelper::json(401, '修改失败', []);
        }
    }

    public function actionSendcode()
    {
        global $_GPC;
        $type = $_GPC['type'];
        if (!in_array($type, ['forgetpass', 'register', 'bindMobile', 'login'])) {
            return ResultHelper::json(401, '验证码请求不合法，请传入字段类型type');
        }
        $mobile = $_GPC['mobile'];
        $where = [];
        $where['mobile'] = $mobile;

        // 首先校验手机号是否重复
        $user = User::find()->where($where)->asArray()->one();

        if (empty($user) && $type === 'forgetpass') {
            return ResultHelper::json(401, '手机号不存在', []);
        }

        if (empty($mobile)) {
            return ResultHelper::json(401, '手机号不能为空');
        }

        // 首先校验手机号是否重复
        $member = ModelsDdMember::find()->where($where)->asArray()->one();

        if ($member && $type == 'register') {
            return ResultHelper::json(401, '手机号已经存在', []);
        }

        $code = random_int(1000, 9999);
        Yii::$app->cache->set($mobile . '_code', $code);
        $res = Yii::$app->service->adminAccessTokenService->send($mobile, ['code' => $code]);

        return ResultHelper::json(200, '发送成功', $res);
    }

    public function actionRefresh()
    {
        global $_GPC;

        $refresh_token = $_GPC['refresh_token'];

        $user = DdApiAccessToken::find()
            ->where(['refresh_token' => $refresh_token])
            ->one();

        if (!$user) {
            throw new NotFoundHttpException('令牌错误，找不到用户!');
        }
        $service = Yii::$app->service;
        $service->namespace = 'api';

        $access_token = $service->AccessTokenService->RefreshToken($user['member_id'], $user['group_id']);

        return ResultHelper::json(200, '发送成功', ['access_token' => $access_token]);
    }

    public function actionFeedback()
    {
        global $_GPC;

        $name = $_GPC['name'];
        $contact = $_GPC['contact'];
        $feedback = $_GPC['feedback'];
        $contacts = new DdWebsiteContact();

        $data = [
            'name' => $name,
            'contact' => $contact,
            'feedback' => $feedback,
        ];

        if ($contacts->load($data, '') && $contacts->save()) {
            return ResultHelper::json(200, '反馈成功', []);
        } else {
            $errors = ErrorsHelper::getModelError($contacts);

            return ResultHelper::json(401, $errors, []);
        }
    }

    public function actionAddons()
    {
        global $_GPC;
        $id = $_GPC['id'];
        $AddonsUser = new AddonsUser([
            'user_id' => $id,
        ]);
        $opts = $AddonsUser->getItems();

        return ResultHelper::json(200, '获取成功', [
            'assigned' => array_values($opts['assigned']['modules']),
            'available' => array_values($opts['available']['modules']),
        ]);
    }

    public function actionDelete($id)
    {
        UserService::deleteUser($id);

        return ResultHelper::json(200, '删除成功');
    }

    public function actionActivate($id)
    {
        /* @var $user User */
        $user = $this->findModel($id);
        if ($user->status == UserStatus::INACTIVE) {
            $user->status = UserStatus::ACTIVE;
            if ($user->save()) {
                return ResultHelper::json(200, '审核成功');
            } else {
                $errors = $user->firstErrors;

                return ResultHelper::json(401, reset($errors));
            }
        }
    }

    public function actionUpstatus()
    {
        global $_GPC;
        $user_id = $_GPC['user_id'];
        $type = $_GPC['type'];

        if (empty($user_id)) {
            return ResultHelper::json(401, '用户ID不能为空');
        }

        if (empty($type)) {
            return ResultHelper::json(401, '操作类型不能为空');
        }

        if (UserService::upStatus($user_id, $type)) {
            return ResultHelper::json(200, '修改成功');
        } else {
            return ResultHelper::json(401, '修改失败');
        }
    }

    public function actionCreate()
    {
        global $_GPC;
        $username = $_GPC['username'];
        $mobile = $_GPC['mobile'];
        $password = $_GPC['password'];
        $email = $_GPC['email'];
        $status = $_GPC['status'];
        
        if (empty($username)) {
            return ResultHelper::json(401, '用户名不能为空', []);
        }
        if (empty($mobile)) {
            return ResultHelper::json(401, '手机号不能为空', []);
        }
        if (empty($email)) {
            return ResultHelper::json(401, '邮箱不能为空', []);
        }
        if (empty($password)) {
            return ResultHelper::json(401, '密码不能为空', []);
        }

        if(strlen($password)<6){
            return ResultHelper::json(401, '密码至少6位', []);
        }

        $model = new User();

        $res = $model->signup($username, $mobile, $email, $password, $status);

        if ($res) {
            return ResultHelper::json(200, '添加成功', $res);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    public function actionSetinfo()
    {
        global $_GPC;
        $user_id = $_GPC['user_id'];
        $addons = AddonsUser::find()->where(['user_id' => $user_id])->with(['addons'])->indexBy('module_name')->asArray()->all();
        $addonsList = [];

        foreach ($addons as $key => $value) {
            if (empty($value['addons'])) {
                unset($addons[$key]);
            } else {
                $addonsList[] = [
                    'id' => $value['id'],
                    'value' => $value['id'],
                    'is_default' => $value['is_default'],
                    'text' => $value['addons']['title'],
                ];
            }
        }

        // 公司授权
        $UserBloc = UserStore::find()->where(['user_id' => $user_id])->with(['bloc'])->indexBy('bloc_id')->asArray()->all();
        $UserBlocList = [];
        foreach ($UserBloc as $key => $value) {
            if (empty($value['bloc'])) {
                unset($UserBloc[$key]);
            } else {
                $UserBlocList[] = [
                    'value' => $value['id'],
                    'id' => $value['id'],
                    'is_default' => $value['is_default'],
                    'text' => $value['bloc']['business_name'],
                ];
            }
        }

        // 商户授权
        $UserStore = UserStore::find()->where(['user_id' => $user_id])->with(['store'])->indexBy('store_id')->asArray()->all();
        $UserStoreList = [];
        foreach ($UserStore as $key => $value) {
            if (empty($value['store'])) {
                unset($UserStore[$key]);
            } else {
                $UserStoreList[] = [
                    'value' => $value['id'],
                    'id' => $value['id'],
                    'is_default' => $value['is_default'],
                    'text' => $value['store']['name'],
                ];
            }
        }

        return ResultHelper::json(200, '获取成功', [
            'addons' => $addonsList,
            'UserBloc' => $UserBlocList,
            'UserStore' => $UserStoreList,
        ]);
    }

    public function actionDefaultInfo()
    {
        global $_GPC;

        $user_id = $_GPC['user_id'];
        $addons_user_id = AddonsUser::find()->where(['user_id' => $user_id, 'is_default' => 1])->select('id')->scalar();
        $store_user_id = UserStore::find()->where(['user_id' => $user_id, 'is_default' => 1])->select('id')->scalar();

        return ResultHelper::json(200, '获取成功', [
            'addons_user_id' => $addons_user_id,
            'store_user_id' => $store_user_id,
        ]);
    }

    public function actionDefault()
    {
        global $_GPC;
        $user_id = $_GPC['user_id'];
        $store_user_id = $_GPC['store_user_id'];
        $bloc_user_id = $_GPC['bloc_user_id'];
        $addons_user_id = $_GPC['addons_user_id'];

        if (empty($user_id)) {
            return ResultHelper::json(400, '用户ID不能为空');
        }

        if (empty($addons_user_id)) {
            return ResultHelper::json(400, '请选择业务类型');
        } else {
            $addons = new AddonsUser();
            $addons->updateAll([
                'is_default' => 0,
            ], [
                'user_id' => $user_id,
            ]);

            $addons->updateAll([
                'is_default' => 1,
            ], [
                'user_id' => $user_id,
                'id' => $addons_user_id,
            ]);
        }

        if (empty($store_user_id)) {
            return ResultHelper::json(400, '请选择商户');
        } else {
            // 公司默认
            $UserBloc = new UserBloc();

            $UserBloc->updateAll([
                'is_default' => 0,
            ], [
                'user_id' => $user_id,
            ]);

            $UserBloc->updateAll([
                'is_default' => 1,
            ], [
                'user_id' => $user_id,
                'id' => $bloc_user_id,
            ]);
            // 商户默认

            $UserStore = new UserStore();

            $UserStore->updateAll([
                'is_default' => 0,
            ], [
                'user_id' => $user_id,
            ]);

            $UserStore->updateAll([
                'is_default' => 1,
            ], [
                'user_id' => $user_id,
                'id' => $store_user_id,
            ]);


            // 更新用户表中的商户与公司
            $store_id = $UserStore->find()->where(['id' => $store_user_id])->select('store_id')->scalar();
            $bloc_id = $UserBloc->find()->where(['id' => $bloc_user_id])->select('bloc_id')->scalar();
            $AdminModelsUser = AdminModelsUser::findOne(['id' => $user_id]);

            $AdminModelsUser->status = $AdminModelsUser['status'];
            $AdminModelsUser->bloc_id = (int) $bloc_id;
            $AdminModelsUser->store_id = (int) $store_id;
            $AdminModelsUser->update();
            
        }

        return ResultHelper::json(200, '设置成功');
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '获取成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    public function actionConfig()
    {
        global $_GPC;

        $user_id = Yii::$app->user->identity->user_id;
        $UserBloc = UserBloc::find()->where(['user_id' => $user_id, 'is_default' => 1, 'status' => 1])->asArray()->one();
        $store_id = UserStore::find()->where(['user_id' => $user_id, 'is_default' => 1, 'status' => 1])->select('store_id')->scalar();
        $Api = new Api();
        $apiConf = $Api->getConf($UserBloc['bloc_id']);
        $data = [
            'baseUrl' => Yii::$app->request->getHostName(),
            'bloc_id' => $UserBloc['bloc_id'],
            'store_id' => $store_id,
            'siteUrl' => Yii::$app->request->getHostName(),
            'app_id' => $apiConf['app_id'],
            'app_secret' => $apiConf['app_secret'],
        ];

        return ResultHelper::json(200, '设置成功', $data);
    }

    public function actionLog()
    {
        global $_GPC;
        $user_id = $_GPC['user_id'];
        $pageSize = 20;
        $query = ActionLog::find()->where(['user_id' => $user_id]);
        $count = $query->count();
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            // 'page'=>$page-1
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        $lists = [];
        foreach ($list as $key => $value) {
            $time = date('Y-m-d', strtotime($value['logtime']));
            $lists[$time][] = $value;
        }

        return ResultHelper::json(200, '获取成功', $lists);
    }
}
