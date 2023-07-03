<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-05 11:45:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-03 11:41:58
 */

namespace api\controllers;

use api\models\DdApiAccessToken;
use api\models\DdMember;
use api\models\LoginForm;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\DdMember as ModelsDdMember;
use common\models\DdWebsiteContact;
use common\models\forms\EdituserinfoForm;
use common\models\forms\PasswdForm;
use Yii;

class UserController extends AController
{
    public $modelClass = '';
    protected $authOptional = ['login', 'signup', 'register', 'repassword', 'sendcode', 'forgetpass', 'refresh', 'smsconf', 'relations'];

    /**
     * @SWG\Post(path="/user/signup",
     *     tags={"登录与注册"},
     *     summary="注册",
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
        $DdMember = new DdMember();
        $data = Yii::$app->request->post();
        $username = $data['username'];
        $mobile = $data['mobile'];
        $password = $data['password'];

        /* @var $member \common\models\backend\Member */
        $code = $data['code'];
        $sendcode = Yii::$app->cache->get($mobile . '_code');



        if (empty($username) && empty($mobile)) {
            return ResultHelper::json(401, '用户名或手机号不能为空', []);
        }

        if (empty($password)) {
            return ResultHelper::json(401, '密码不能为空', []);
        }

        if (empty($code)) {
            return ResultHelper::json(401, 'code不能为空', []);
        }

        if ($code != $sendcode) {
            return ResultHelper::json(401, '验证码错误');
        }

        $res = $DdMember->signup($username, $mobile, $password);

        return ResultHelper::json(200, '注册成功', $res);
    }

    public function actionRegister()
    {
        global $_GPC;
        $DdMember = new DdMember();
        $data = Yii::$app->request->post();
        $username = $data['username'];
        $password = $data['password'];



        if (empty($username)) {
            return ResultHelper::json(401, '用户名不能为空', []);
        }

        if (empty($password)) {
            return ResultHelper::json(401, '密码不能为空', []);
        }


        $mobile = '';

        $res = $DdMember->signup($username, $mobile, $password);

        return ResultHelper::json(200, '注册成功', $res);
    }

    /**
     * @SWG\Post(path="/user/login",
     *     tags={"登录与注册"},
     *     summary="登录",
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
     *
     * )
     */
    public function actionLogin()
    {
        global $_GPC;
        $model = new LoginForm();
        if ($model->load($_GPC, '') && $userinfo = $model->login()) {
            return ResultHelper::json(200, '登录成功', $userinfo);
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json('401', $message);
        }
    }

    /**
     * @SWG\Post(path="/user/repassword",
     *     tags={"密码设置"},
     *     summary="重置密码",
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
        global $_GPC;
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

            $member = DdMember::findByMobile($data['mobile']);

            $member->password_hash = Yii::$app->security->generatePasswordHash($model->newpassword);
            $member->generatePasswordResetToken();
            if ($member->save()) {
                Yii::$app->user->logout();
                $service = Yii::$app->service;
                $service->namespace = 'api';
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

    public function actionUpRepassword()
    {
        global $_GPC;
        $newpassword = $_GPC['password'];
        $member_id = Yii::$app->user->identity->member_id;
        if (empty($member_id)) {
            return ResultHelper::json(401, 'member_id为空');
        }
        $member = DdMember::findIdentity($member_id);
        if (empty($member)) {
            return ResultHelper::json(401, '用户不存在');
        }
        $member->password_hash = Yii::$app->security->generatePasswordHash($newpassword);
        $member->generatePasswordResetToken();
        if ($member->save()) {
            Yii::$app->user->logout();
            $service = Yii::$app->service;
            $service->namespace = 'api';
            $userinfo = $service->AccessTokenService->getAccessToken($member, 1);

            return ResultHelper::json(200, '修改成功', $userinfo);
        }

        return ResultHelper::json(404, $this->analyErr($member->getFirstErrors()));
    }

    /**
     * @SWG\Post(path="/user/userinfo",
     *     tags={"会员资料"},
     *     summary="获取会员资料",
     *     @SWG\Response(
     *         response = 200,
     *         description = "会员资料",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
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

        $data = Yii::$app->request->post();

        $member_id = Yii::$app->user->identity->member_id;

        if (!empty($mobile)) {
            $userobj = DdMember::findByMobile($data['mobile']);
        } else {
            $userobj = DdMember::findIdentity($member_id);
        }

        $userobj['avatarUrl'] = ImageHelper::tomedia($userobj['avatarUrl'], 'avatar.jpg');
        $userobj['avatar'] = ImageHelper::tomedia($userobj['avatar'], 'avatar.jpg');

        $service = Yii::$app->service;
        $service->namespace = 'api';
        $userinfo =  [];
        if ($userobj) {
            $userinfo = $service->AccessTokenService->getAccessToken($userobj, 1);
        }

        return ResultHelper::json(200, '获取成功', ['userinfo' => $userinfo]);
    }

    /**
     * @SWG\Post(path="/user/bindmobile",
     *     tags={"会员资料"},
     *     summary="绑定手机号",
     *     @SWG\Response(
     *         response = 200,
     *         description = "绑定手机号",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
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
        $sendcode = Yii::$app->cache->get($mobile . '_code');

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
     *     summary="修改资料",
     *     @SWG\Response(
     *         response = 200,
     *         description = "修改资料",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
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
     *     summary="忘记密码",
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
     *      name="code",
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
     * )
     */
    public function actionForgetpass()
    {
        $data = Yii::$app->request->post();
        $mobile = $data['mobile'];
        $password = $data['password'];
        $code = $data['code'];
        $sendcode = Yii::$app->cache->get($mobile . '_code');
        if ($code != $sendcode) {
            return ResultHelper::json(401, '验证码错误');
        }
        $member = DdMember::findByMobile($mobile);
        $res = Yii::$app->service->apiAccessTokenService->forgetpassword($member, $mobile, $password);
        if ($res) {
            // 清除验证码
            Yii::$app->cache->delete($mobile . '_code');

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
            return ResultHelper::json(401, '验证码请求不合法，请传入字段类型type');
        }

        $data = Yii::$app->request->post();
        $mobile = $data['mobile'];
        if (empty($mobile)) {
            return ResultHelper::json(401, '手机号不能为空');
        }

        $where = [];
        $where['mobile'] = $mobile;

        $bloc_id = yii::$app->params['bloc_id'];
        $store_id = yii::$app->params['store_id'];

        // 首先校验手机号是否重复
        $member = ModelsDdMember::find()->where([
            'mobile' => $mobile,
            'bloc_id' => $bloc_id,
            'store_id' => $store_id,
        ])->asArray()->one();

        if ($member && $type == 'register') {
            return ResultHelper::json(401, '手机号已经存在', []);
        }

        $code = random_int(1000, 9999);
        Yii::$app->cache->set((int) $mobile . '_code', $code);

        $usage = '忘记密码验证';

        $res = Yii::$app->service->apiSmsService->send($mobile, $code, $usage);

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
            return ResultHelper::json(403, '令牌错误，找不到用户!');
        }

        $access_token = Yii::$app->service->apiAccessTokenService->RefreshToken($user['member_id'], $user['group_id']);

        // findIdentity
        $member = DdMember::findIdentity($user['member_id']);
        $userinfo = Yii::$app->service->apiAccessTokenService->getAccessToken($member, 1);

        return ResultHelper::json(200, '发送成功', $userinfo);
    }

    /**
     * @SWG\Post(path="/user/feedback",
     *     tags={"反馈问题"},
     *     summary="反馈问题",
     *     @SWG\Response(
     *         response = 200,
     *         description = "反馈问题",
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="name",
     *      type="string",
     *      description="姓名",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="contact",
     *      type="string",
     *      description="联系方式",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="feedback",
     *      type="string",
     *      description="反馈说明",
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

    public function actionSmsconf()
    {
        $sms = Yii::$app->params['conf']['sms'];

        return ResultHelper::json(200, '短信配置或者成功', ['is_login' => $sms['is_login']]);
    }

    public function actionRelations()
    {
        $model = new DdWebsiteContact();
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '留言成功');
            } else {
                return ResultHelper::json(400, '留言失败');
            }
        }
    }
}
