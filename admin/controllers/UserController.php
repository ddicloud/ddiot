<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-05 11:45:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-22 17:58:22
 */

namespace admin\controllers;

use admin\models\forms\LoginForm;
use admin\models\User;
use admin\services\UserService;
use api\models\DdApiAccessToken;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\DdMember as ModelsDdMember;
use common\models\DdWebsiteContact;
use common\models\forms\EdituserinfoForm;
use common\models\forms\PasswdForm;
use common\models\UserBloc;
use diandi\addons\models\AddonsUser;
use diandi\admin\components\UserStatus;
use diandi\admin\models\AuthAssignmentGroup;
use diandi\admin\models\searchs\User as ModelsUser;
use Yii;
use yii\web\NotFoundHttpException;

class UserController extends AController
{
    public $modelClass = 'admin\models\User';

    protected $authOptional = ['login', 'signup', 'repassword', 'sendcode', 'forgetpass', 'refresh'];

    /**
     * @SWG\Post(path="/user/userlist",
     *     tags={"管理员列表"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "管理员列表",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="username",
     *      type="string",
     *      description="用户名",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="mobile",
     *      type="string",
     *      description="手机号",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="password",
     *      type="string",
     *      description="密码",
     *      required=true,
     *    ),
     *
     * )
     */
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

    /**
     * @SWG\Post(path="/user/signup",
     *     tags={"登录与注册"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "注册",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="username",
     *      type="string",
     *      description="用户名",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="mobile",
     *      type="string",
     *      description="手机号",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="password",
     *      type="string",
     *      description="密码",
     *      required=true,
     *    ),
     *
     * )
     */
    public function actionSignup()
    {
        $User = new User();
        $data = Yii::$app->request->post();
        $username = $data['username'];
        $mobile = $data['mobile'];
        $email = $data['email'];
        $password = $data['password'];
        if (empty($username)) {
            return ResultHelper::json(401, '用户名不能为空', []);
        }
        if (empty($mobile)) {
            return ResultHelper::json(401, '手机号不能为空', []);
        }
        if (empty($password)) {
            return ResultHelper::json(401, '密码不能为空', []);
        }

        $res = $User->signup($username, $mobile, $email, $password);

        return ResultHelper::json(200, '注册成功', $res);
    }

    /**
     * @SWG\Post(path="/user/login",
     *     tags={"登录与注册"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "登录",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="username",
     *      type="string",
     *      description="用户名",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="password",
     *      type="string",
     *      description="密码",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="type",
     *      type="integer",
     *      description="登录方式1：账户登录2手机登录",
     *      required=true,
     *    )
     * )
     */
    public function actionLogin()
    {
        global $_GPC;

        \YII::beginProfile('actionLogin');

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            $userinfo = $model->login();

            return ResultHelper::json(200, '登录成功', $userinfo);
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json('401', $message);
        }
        \YII::endProfile('actionLogin');
    }

    /**
     * @SWG\Post(path="/user/repassword",
     *     tags={"密码设置"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "重置密码",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="mobile",
     *      type="string",
     *      description="手机号",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="code",
     *      type="string",
     *      description="验证码",
     *      required=false,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name=" ",
     *      type="string",
     *      description="密码",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="password_reset_token",
     *      type="string",
     *      description="修改密码token",
     *      required=true,
     *    ),
     *
     * )
     */
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
            $sendcode = Yii::$app->cache->get($mobile.'_code');
            if ($code != $sendcode) {
                return ResultHelper::json(401, '验证码错误');
            }

            $member = User::findByMobile($data['mobile']);
            $member->password_hash = Yii::$app->security->generatePasswordHash($model->newpassword);
            $member->generatePasswordResetToken();
            if ($member->save()) {
                Yii::$app->user->logout();
                $service = Yii::$app->service;
                $service->namespace = 'api';
                $userinfo = $service->AccessTokenService->getAccessToken($member, 1);
                // 清除验证码
                Yii::$app->cache->delete($mobile.'_code');

                return ResultHelper::json(200, '修改成功', $userinfo);
            }

            return ResultHelper::json(404, $this->analyErr($member->getFirstErrors()));
        } else {
            $res = ErrorsHelper::getModelError($model);

            return ResultHelper::json(404, $res);
        }
    }

    /**
     * @SWG\Post(path="/user/userinfo",
     *     tags={"会员资料"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "会员资料",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="header",
     *      required=true
     *    ),
     *    @SWG\Parameter(
     *      name="mobile",
     *      type="integer",
     *      in="formData",
     *      required=false
     *    )
     * )
     */
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
        $Website['blogo'] = ImageHelper::tomedia($Website['blogo']);
        $Website['flogo'] = ImageHelper::tomedia($Website['flogo']);

        $Website['themcolor'] = !empty(Yii::$app->cache->get('themcolor')) ? Yii::$app->cache->get('themcolor') : $Website['themcolor'];

        $roles = AuthAssignmentGroup::find()->where(['user_id' => $user_id])->select('item_name')->column();
        $userinfo['roles'] = $roles;

        return ResultHelper::json(200, '获取成功', [
            'userinfo' => $userinfo,
            'Website' => $Website,
        ]);
    }

    /**
     * @SWG\Post(path="/user/bindmobile",
     *     tags={"会员资料"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "绑定手机号",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="header",
     *      required=true
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="mobile",
     *      type="integer",
     *      description="手机号",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      in="formData",
     *      name="code",
     *      type="string",
     *      description="验证码",
     *      required=false,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="nickName",
     *      type="string",
     *      description="微信昵称",
     *      required=true,
     *    )
     * )
     */
    public function actionBindmobile()
    {
        global $_GPC;

        $code = $_GPC['code'];
        $mobile = $_GPC['mobile'];
        $sendcode = Yii::$app->cache->get($mobile.'_code');

        if ($code != $sendcode) {
            return ResultHelper::json(401, '验证码错误');
        }

        $member_id = Yii::$app->user->identity->member_id;
        $fields['mobile'] = $mobile;
        $res = Yii::$app->service->commonMemberService->editInfo($member_id, $fields);

        if ($res) {
            return ResultHelper::json(200, '绑定手机号成功', []);
        }
    }

    /**
     * @SWG\Post(path="/user/edituserinfo",
     *     tags={"会员资料"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "修改资料",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="header",
     *      required=true
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="username",
     *      type="string",
     *      description="用户名",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="mobile",
     *      type="integer",
     *      description="手机号",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="nickName",
     *      type="string",
     *      description="微信昵称",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="avatarUrl",
     *      type="string",
     *      description="头像",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="gender",
     *      type="string",
     *      description="性别",
     *      required=true,
     *    ),
     * )
     */
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

    /**
     * @SWG\Post(path="/user/forgetpass",
     *     tags={"密码设置"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "忘记密码",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="mobile",
     *      type="integer",
     *      description="手机号",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="sms_code",
     *      type="integer",
     *      description="验证码",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="password",
     *      type="string",
     *      description="密码",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="repassword",
     *      type="string",
     *      description="确认密码",
     *      required=true,
     *    ),
     * )
     */
    public function actionForgetpass()
    {
        global $_GPC;
        $data = Yii::$app->request->post();
        $mobile = $_GPC['mobile'];
        $password = $_GPC['password'];
        $repassword = $_GPC['repassword'];
        $code = $_GPC['sms_code'];
        $sendcode = Yii::$app->cache->get($mobile.'_code');

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
            Yii::$app->cache->delete($mobile.'_code');

            return ResultHelper::json(200, '修改成功', []);
        } else {
            return ResultHelper::json(401, '修改失败', []);
        }
    }

    /**
     * @SWG\Post(path="/user/sendcode",
     *     tags={"发送验证码"},
     *     summary="发送验证码",
     *     @SWG\Response(
     *         response = 200,
     *         description = "发送验证码",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="mobile",
     *      type="string",
     *      description="手机号",
     *      required=true,
     *    ),
     * )
     */
    public function actionSendcode()
    {
        global $_GPC;
        $type = $_GPC['type'];
        if (!in_array($type, ['forgetpass', 'register', 'bindMobile'])) {
            return ResultHelper::json(401, '验证码请求不合法');
        }
        $mobile = $_GPC['mobile'];
        $where = [];
        $where['mobile'] = $mobile;

        $where['bloc_id'] = yii::$app->params['bloc_id'];
        $where['store_id'] = yii::$app->params['store_id'];

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
        Yii::$app->cache->set($mobile.'_code', $code);
        $res = Yii::$app->service->adminAccessTokenService->send($mobile, ['code' => $code]);

        return ResultHelper::json(200, '发送成功', $res);
    }

    /**
     * @SWG\Post(path="/user/refresh",
     *     tags={"重置令牌"},
     *     summary="重置令牌",
     *     @SWG\Response(
     *         response = 200,
     *         description = "重置令牌",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="refresh_token",
     *      type="string",
     *      description="刷新token令牌",
     *      required=true,
     *    ),
     * )
     */
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

    /**
     * @SWG\Post(path="/user/feedback",
     *     tags={"重置令牌"},
     *     summary="重置令牌",
     *     @SWG\Response(
     *         response = 200,
     *         description = "重置令牌",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="refresh_token",
     *      type="string",
     *      description="刷新token令牌",
     *      required=true,
     *    ),
     * )
     */
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

    /**
     * @SWG\Post(path="/user/addons",
     *     tags={"用户授权应用"},
     *     summary="应用",
     *     @SWG\Response(
     *         response = 200,
     *         description = "应用",
     *     ),
     *     @SWG\Parameter(
     *      in="header",
     *      name="access_token",
     *      type="string",
     *      description="用户token",
     *      required=true,
     *    ),
     * )
     */
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

    /**
     * @SWG\Post(path="/user/delete",
     *     tags={"删除管理员"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "应用",
     *     ),
     *     @SWG\Parameter(
     *      in="header",
     *      name="access_token",
     *      type="string",
     *      description="用户token",
     *      required=true,
     *    ),
     * )
     */
    public function actionDelete($id)
    {
        UserService::deleteUser($id);

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * @SWG\Post(path="/user/activate",
     *     tags={"审核管理员"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "应用",
     *     ),
     *     @SWG\Parameter(
     *      in="header",
     *      name="access_token",
     *      type="string",
     *      description="用户token",
     *      required=true,
     *    ),
     * )
     */
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

    /**
     * @SWG\Post(path="/user/upstatus",
     *     tags={"修改管理员状态"},
     *     summary="管理员",
     *     @SWG\Response(
     *         response = 200,
     *         description = "应用",
     *     ),
     *     @SWG\Parameter(
     *      in="header",
     *      name="access_token",
     *      type="string",
     *      description="用户token",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="user_id",
     *      type="number",
     *      description="用户ID",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="type",
     *      type="string",
     *      description="状态类型",
     *      required=true,
     *    ),
     * )
     */
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

        $model = new User();

        $res = $model->signup($username, $mobile, $email, $password);

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

        $UserBloc = UserBloc::find()->where(['user_id' => $user_id])->with(['store'])->indexBy('store_id')->asArray()->all();
        $UserBlocList = [];
        foreach ($UserBloc as $key => $value) {
            if (empty($value['store'])) {
                unset($UserBloc[$key]);
            } else {
                $UserBlocList[] = [
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
        ]);
    }

    public function actionDefaultInfo()
    {
        global $_GPC;

        $user_id = $_GPC['user_id'];
        $addons_user_id = AddonsUser::find()->where(['user_id' => $user_id, 'is_default' => 1])->select('id')->scalar();
        $store_user_id = UserBloc::find()->where(['user_id' => $user_id, 'is_default' => 1])->select('id')->scalar();

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
                'id' => $store_user_id,
            ]);
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
}
