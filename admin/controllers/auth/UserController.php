<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-12 13:39:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-18 17:30:12
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\Bloc;
use diandi\addons\models\DdAddons;
use diandi\admin\components\UserStatus;
use diandi\admin\models\Assignment;
use diandi\admin\models\form\ChangePassword;
use diandi\admin\models\form\Login;
use diandi\admin\models\form\PasswordResetRequest;
use diandi\admin\models\form\ResetPassword;
use diandi\admin\models\form\Signup;
use diandi\admin\models\searchs\User as UserSearch;
use diandi\admin\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\mail\BaseMailer;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * User controller.
 */
class UserController extends AController
{
    public $modelClass = '';

    private $_oldMailPath;

    public $module_name;
    public $type;

    public function actions()
    {
        $this->module_name = Yii::$app->request->get('module_name', 'sys');
        $this->type = $this->module_name == 'sys' ? 0 : 1;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'logout' => ['post'],
                    'activate' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (Yii::$app->has('mailer') && ($mailer = Yii::$app->getMailer()) instanceof BaseMailer) {
                /* @var $mailer BaseMailer */
                $this->_oldMailPath = $mailer->getViewPath();
                $mailer->setViewPath('@diandi/admin/mail');
            }

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function afterAction($action, $result)
    {
        if ($this->_oldMailPath !== null) {
            Yii::$app->getMailer()->setViewPath($this->_oldMailPath);
        }

        return parent::afterAction($action, $result);
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $module_name = $this->module_name;
        $AddonsUser = new AddonsUser();
        $user_ids = [];
        if ($module_name != 'sys') {
            $list = DdAddons::findOne(['identifie' => $module_name]);
            if (!$list) {
                throw new HttpException('400', '扩展功能不存在！');
            }
            $user_ids = $AddonsUser->find()->where(['module_name' => $module_name])->select(['user_id'])->column();

            $searchModel = new UserSearch([
                'user_ids' => $user_ids,
            ]);
        } else {
            $searchModel = new UserSearch([]);
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'module_name' => $this->module_name,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider->getModels(),
        ]);
    }

    /**
     * Updates an existing DdUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'module_name' => $this->module_name]);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                throw new BadRequestHttpException($msg);
            }
        } else {
            // 获取用户角色
            $user = User::findIdentity($id);

            $userassign = new Assignment(['id' => $id, 'type' => $this->type], $user);
            $assigns = $userassign->getItems();

            $assign = [];
            if ($assigns['assigned']) {
                foreach ($assigns['assigned'] as $key => $item) {
                    $assign[$item][] = $key;
                }
            }
            // 获取集团与分公司
            $Bloc = Bloc::find()->where(['bloc_id' => $model->bloc_id])->select(['business_name'])->one();
            // $ResetPassword = new  ResetPassword($model->password_reset_token);

            return $this->render('update', [
                'model' => $model,
                'assign' => $assign,
                'business_name' => $Bloc['business_name'] ? $Bloc['business_name'] : '暂未分配',
            ]);
        }
    }

    // 修改别人的密码
    public function actionChangePass($id)
    {
        global $_GPC;

        $id = $_GPC['id'];

        $user = $this->findModel($id);
        $title = $user->username;

        if (!ResetPassword::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
        }

        $token = $user->password_reset_token;

        if (Yii::$app->request->isPost) {
            try {
                $user = new ResetPassword($token);
            } catch (InvalidParamException $e) {
                throw new BadRequestHttpException($e->getMessage());
            }

            if ($user->load(Yii::$app->getRequest()->post()) && $user->validate() && $user->resetPassword()) {
                Yii::$app->session->setFlash('success', '密码修改成功');

                return $this->redirect(['update', 'id' => $id]);
            }
        }

        if (!$user->save()) {
            // 修改密码
            Yii::$app->session->setFlash('success', '重置验证失败');

            return $this->redirect(['index']);
        }

        try {
            $ResetPassword = new ResetPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return $this->render('password', [
            'ResetPassword' => $ResetPassword,
            'title' => $title,
            'id' => $id,
        ]);
    }

    /**
     * Displays a single User model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $AddonsUser = new AddonsUser([
            'user_id' => $id,
        ]);
        $opts = $AddonsUser->getItems();
        $animateIcon = '';

        return $this->render('view', [
            'animateIcon' => $animateIcon,
            'model' => $this->findModel($id),
            'opts' => Json::htmlEncode($opts),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'module_name' => $this->module_name]);
    }

    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->addChildren($items);
        Yii::$app->getResponse()->format = 'json';

        $AddonsUser = new AddonsUser([
            'user_id' => $id,
        ]);
        $opts = $AddonsUser->getItems();

        return array_merge($opts, ['success' => $success]);
    }

    public function actionRemove($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->removeChildren($items);
        Yii::$app->getResponse()->format = 'json';

        $AddonsUser = new AddonsUser([
            'user_id' => $id,
        ]);
        $opts = $AddonsUser->getItems();

        return array_merge($opts, ['success' => $success]);
    }

    /**
     * Login.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        $model = new Login();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }

    /**
     * Signup new user.
     *
     * @return string
     */
    public function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                if ($this->module_name) {
                    $id = $user->id;
                    $childmodel = $this->findModel($id);
                    $childmodel->addChildren([$this->module_name]);
                }
                Yii::$app->session->setFlash('success', '添加成功');
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'module_name' => $this->module_name,
        ]);
    }

    /**
     * Request reset password.
     *
     * @return string
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequest();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Reset password.
     *
     * @return string
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Reset password.
     *
     * @return string
     */
    public function actionChangePassword()
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->change()) {
            return $this->goHome();
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    /**
     * Activate new user.
     *
     * @param int $id
     *
     * @return type
     *
     * @throws UserException
     * @throws NotFoundHttpException
     */
    public function actionActivate($id)
    {
        /* @var $user User */
        $user = $this->findModel($id);
        if ($user->status == UserStatus::INACTIVE) {
            $user->status = UserStatus::ACTIVE;
            if ($user->save()) {
                Yii::$app->session->setFlash('success', '用户审核成功');
            } else {
                $errors = $user->firstErrors;
                throw new UserException(reset($errors));
            }
        }

        return $this->actionIndex();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return User the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return  $model;
        } else {
            throw new NotFoundHttpException('请检查数据是否存在');
        }
    }
}
