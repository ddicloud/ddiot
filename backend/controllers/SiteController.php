<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 21:40:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-27 00:44:50
 */


namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\helpers\Url;
use common\widgets\adminlte\AdminLteAsset;
use common\models\forms\ClearCache;
use yii\web\Controller;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use backend\models\PasswordResetRequestForm;
use backend\models\ResendVerificationEmailForm;
use backend\models\ResetPasswordForm;
use backend\models\SignupForm;
use backend\models\VerifyEmailForm;
use common\helpers\MapHelper;
use common\helpers\ResultHelper;
use common\models\DdUser;
use common\models\User;

/**
 * Site controllers
 */
class SiteController extends BaseController
{

    public $layout = "@backend/views/layouts/main-login";

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'signup', 'request-password-reset','setpassword'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'clear-cache', 'reset-password', 'resend-verification-email'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        /* 设置模板主题 */
        Yii::$container->set(
            AdminLteAsset::class,
            [
                'skin' => Yii::$app->settings->get('Website', 'themcolor'),
            ]
        );
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => "@backend/views/layouts/main"
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = "@backend/views/layouts/main-base";

        // Yii::$app->params['plugins'] = 'sysai';

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $last_login_ip = MapHelper::get_client_ip();
            $user = DdUser::find()->where([
                'id'=>Yii::$app->user->identity->id,
                'last_login_ip'=>$last_login_ip
            ])->select(['is_login'])->one();
            
            // if($user['is_login']==1 && $user['last_time']+60*5<time()){
            
            //     Yii::$app->user->logout();
            //     Yii::$app->session->setFlash('success', '该账户已在其他浏览器登录');
            //     return $this->goHome();
            // }    
            // 记录最后登录的时间
            $password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
            DdUser::updateAll([
                'last_time'=>time(),
                'is_login'=>1,
                'last_login_ip'=>$last_login_ip,
                'password_reset_token'=>$password_reset_token],['id'=>Yii::$app->user->identity->id]);
            return $this->goHome();
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        DdUser::updateAll([
            'is_login'=>0
        ],['id'=>Yii::$app->user->identity->id]);
        
        Yii::$app->user->logout();
        
        return ResultHelper::json(200,'退出成功',[
            'url'=>Url::to(['site/login'])
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', '感谢您的注册，请验证您的邮箱');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {

        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', '发送成功，请查收您的邮箱');
            } else {
                Yii::$app->session->setFlash('error', '对不起，我们无法为提供的电子邮件地址重置密码。');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

     /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionSetpassword($token)
    {
        $this->layout = "@backend/views/layouts/main-login";
        $isGuest =  Yii::$app->user->isGuest;
        if($isGuest){
            try {
                $model = new ResetPasswordForm($token);
            } catch (InvalidArgumentException $e) {
                throw new BadRequestHttpException($e->getMessage());
            }
        
        }else{
            $password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
            
            User::updateAll([
                'password_reset_token'=>$password_reset_token
            ],['id'=>Yii::$app->user->id]);
            $model = new ResetPasswordForm($password_reset_token);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', '密码修改成功');
            $this->redirect(['site/login']);
        }

        return $this->render('setpassword', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = "@backend/views/layouts/main";
        $isGuest =  Yii::$app->user->isGuest;
        if($isGuest){
            try {
                $model = new ResetPasswordForm($token);
            } catch (InvalidArgumentException $e) {
                throw new BadRequestHttpException($e->getMessage());
            }
        
        }else{
            $password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
            
            User::updateAll([
                'password_reset_token'=>$password_reset_token
            ],['id'=>Yii::$app->user->id]);
            $model = new ResetPasswordForm($password_reset_token);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', '密码修改成功');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', '发送成功，请注意查收');
                
                // return $this->goHome();
            }
            Yii::$app->session->setFlash('error', '邮件发送失败，请重试');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
