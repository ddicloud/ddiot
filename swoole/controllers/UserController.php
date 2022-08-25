<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-05 11:45:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-25 09:32:12
 */

namespace swooleService\controllers;
 
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\forms\EdituserinfoForm;
use common\models\forms\PasswdForm;
use swooleService\models\forms\LoginForm;
use swooleService\models\SwooleAccessToken;
use swooleService\models\SwooleMember;
use Yii;

class UserController extends AController
{
    public $modelClass = '';
    
    protected $authOptional = ['login', 'signup', 'repassword', 'sendcode', 'forgetpass', 'refresh', 'smsconf'];

  
    public function actionSignup()
    {
        $DdMember = new SwooleMember();
        $data = Yii::$app->request->post();
        $username = $data['username'];
        $mobile = $data['mobile'];
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

        $res = $DdMember->signup($username, $mobile, $password);

        if($res){
         return ResultHelper::json(200, '注册成功', $res);
            
        }
        
        return ResultHelper::json(401, '注册失败');
    }

    
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
            $sendcode = Yii::$app->cache->get($mobile.'_code');
            if ($code != $sendcode) {
                return ResultHelper::json(401, '验证码错误');
            }

            $member = SwooleMember::findByMobile($data['mobile']);

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

    public function actionUpRepassword()
    {
        global $_GPC;
        $newpassword = $_GPC['password'];
        $member_id = Yii::$app->user->identity->member_id;
        if (empty($member_id)) {
            return ResultHelper::json(401, 'member_id为空');
        }
        $member = SwooleMember::findIdentity($member_id);
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

   
    public function actionUserinfo()
    {
        global $_GPC;

        $mobile = $_GPC['mobile'];

        $data = Yii::$app->request->post();

        $member_id = Yii::$app->user->identity->member_id;

        if (!empty($mobile)) {
            $userobj = SwooleMember::findByMobile($data['mobile']);
        } else {
            $userobj = SwooleMember::findIdentity($member_id);
        }

        $userobj['avatarUrl'] = ImageHelper::tomedia($userobj['avatarUrl'], 'avatar.jpg');
        $userobj['avatar'] = ImageHelper::tomedia($userobj['avatar'], 'avatar.jpg');

        $service = Yii::$app->service;
        $service->namespace = 'api';
        $userinfo = $service->AccessTokenService->getAccessToken($userobj, 1);

        return ResultHelper::json(200, '获取成功', ['userinfo' => $userinfo]);
    }

   
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
        $data = Yii::$app->request->post();
        $mobile = $data['mobile'];
        $password = $data['password'];
        $code = $data['code'];
        $sendcode = Yii::$app->cache->get($mobile.'_code');
        if ($code != $sendcode) {
            return ResultHelper::json(401, '验证码错误');
        }
        $member = SwooleMember::findByMobile($mobile);
        $res = Yii::$app->service->apiAccessTokenService->forgetpassword($member, $mobile, $password);
        if ($res) {
            // 清除验证码
            Yii::$app->cache->delete($mobile.'_code');

            return ResultHelper::json(200, '修改成功', []);
        } else {
            return ResultHelper::json(401, '修改失败', []);
        }
    }

   
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
        $member = SwooleMember::find()->where([
            'mobile' => $mobile,
            'bloc_id' => $bloc_id,
            'store_id' => $store_id,
        ])->asArray()->one();

        if ($member && $type == 'register') {
            return ResultHelper::json(401, '手机号已经存在', []);
        }

        $code = random_int(1000, 9999);
        Yii::$app->cache->set($mobile.'_code', $code);

        $usage = '忘记密码验证';

        $res = Yii::$app->service->apiSmsService->send($mobile, $code, $usage);

        return ResultHelper::json(200, '发送成功', $res);
    }

   
    public function actionRefresh()
    {
        global $_GPC;

        $refresh_token = $_GPC['refresh_token'];

        $user = SwooleAccessToken::find()
            ->where(['refresh_token' => $refresh_token])
            ->one();

        if (!$user) {
            return ResultHelper::json(403, '令牌错误，找不到用户!');
        }

        $access_token = Yii::$app->service->apiAccessTokenService->RefreshToken($user['member_id'], $user['group_id']);

        // findIdentity
        $member = SwooleMember::findIdentity($user['member_id']);
        $userinfo = Yii::$app->service->apiAccessTokenService->getAccessToken($member, 1);

        return ResultHelper::json(200, '发送成功', $userinfo);
    }

    
}
