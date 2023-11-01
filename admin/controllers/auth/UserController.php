<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-12 13:39:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 19:47:03
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\Bloc;
use diandi\addons\models\DdAddons;
use diandi\admin\components\UserStatus;
use diandi\admin\models\Assignment;
use diandi\admin\models\form\ChangePassword;
use diandi\admin\models\form\PasswordResetRequest;
use diandi\admin\models\form\ResetPassword;
use diandi\admin\models\form\Signup;
use diandi\admin\models\searchs\User as UserSearch;
use diandi\admin\models\User;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\UserException;
use yii\db\StaleObjectException;
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

    private string|null $_oldMailPath;

    public string $module_name;
    public int $type;

    public function actions(): array
    {
        $this->module_name = Yii::$app->request->get('module_name', 'sys');
        $this->type = $this->module_name == 'sys' ? 0 : 1;
        return  parent::actions();
    }

    /**
     * {@inheritdoc}
     * @throws NotFoundHttpException
     */
    public function beforeAction($action): bool
    {
        if (parent::beforeAction($action)) {
            try {
                if (Yii::$app->has('mailer') && ($mailer = Yii::$app->getMailer()) instanceof BaseMailer) {
                    /* @var $mailer BaseMailer */
                    $this->_oldMailPath = $mailer->getViewPath();
                    $mailer->setViewPath('@diandi/admin/mail');
                }
            } catch (InvalidConfigException $e) {
                throw new NotFoundHttpException($e->getMessage(),500);
            }

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function afterAction($action, $result)
    {
        if ($this->_oldMailPath !== null) {
            try {
                Yii::$app->getMailer()->setViewPath($this->_oldMailPath);
            } catch (InvalidConfigException $e) {
                throw new Exception($e->getMessage(),500);
            }
        }

        return parent::afterAction($action, $result);
    }

    /**
     * Lists all User models.
     *
     * @return array
     * @throws HttpException
     */
    public function actionIndex(): array
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

        return ResultHelper::json(200, '获取成功',[
            'module_name' => $this->module_name,
            'user_ids' => $user_ids,
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
     * @return array
     *
     * @throws BadRequestHttpException if the model cannot be found
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return ResultHelper::json(200, '获取成功',[
                    'id' => $model->id, 'module_name' => $this->module_name
                ]);
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

            return ResultHelper::json(200, '获取成功',[
                'model' => $model,
                'assign' => $assign,
                'business_name' => $Bloc['business_name'] ?? '暂未分配',
            ]);
        }
    }

    // 修改别人的密码

    /**
     * @throws Exception
     * @throws BadRequestHttpException
     */
    public function actionChangePass(): array
    {
        global $_GPC;

        $id =\Yii::$app->request->input('id');

        $user = $this->findModel($id);
        $title = $user->username;

        if (!ResetPassword::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
        }

        $token = $user->password_reset_token;

        if (Yii::$app->request->isPost) {
            try {
                $user = new ResetPassword($token);
            } catch (\Exception $e) {
                throw new BadRequestHttpException($e->getMessage());
            }

            if ($user->load(Yii::$app->getRequest()->post()) && $user->validate() && $user->resetPassword()) {
                return ResultHelper::json(500, '密码修改成功');
            }
        }

        if (!$user->save()) {
            // 修改密码
            return ResultHelper::json(500, '重置验证失败');
        }

        try {
            $ResetPassword = new ResetPassword($token);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return ResultHelper::json(200, '获取成功', [
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
     * @return array
     */
    public function actionView($id): array
    {
        $AddonsUser = new AddonsUser([
            'user_id' => $id,
        ]);
        $opts = $AddonsUser->getItems();
        $animateIcon = '';

        return ResultHelper::json(200, '获取成功', [
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
     * @return array
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '获取成功', ['module_name' => $this->module_name]);
    }

    public function actionAssign($id): array
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

    public function actionRemove($id): array
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
     * Logout.
     *
     * @return array
     */
    public function actionLogout(): array
    {
        Yii::$app->getUser()->logout();

        return ResultHelper::json(200, '退出成功');
    }

    /**
     * Signup new user.
     *
     * @return array|object[]|string|string[]
     */
    public function actionSignup(): array|string
    {
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                if ($this->module_name) {
                    $id = $user->id;
                    $childmodel = $this->findModel($id);
                    $childmodel->addChildren([$this->module_name]);
                }
            }
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'module_name' => $this->module_name,
        ]);
    }

    /**
     * Request reset password.
     *
     * @return array|object[]|string|string[]
     */
    public function actionRequestPasswordReset(): array|string
    {
        $model = new PasswordResetRequest();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                return ResultHelper::json(200, 'Check your email for further instructions.', [
                    'model' => $model
                ]);
            } else {
                return ResultHelper::json(500, 'Sorry, we are unable to reset password for email provided.', [
                    'model' => $model
                ]);
            }
        }else{
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(500, $msg);
        }
    }

    /**
     * Reset password.
     *
     * @param $token
     * @return array|object[]|string|string[]
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token): array|string
    {
        try {
            $model = new ResetPassword($token);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
            return ResultHelper::json(200, 'New password was saved.', [
                'model' => $model
            ]);
        }else{
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(500, $msg);
        }

    }

    /**
     * Reset password.
     *
     * @return array|object[]|string|string[]
     */
    public function actionChangePassword(): array|string
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->change()) {
            return ResultHelper::json(200, '修改成功');
        }else{
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(500, $msg);
        }
    }

    /**
     * Activate new user.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws UserException
     * @throws NotFoundHttpException
     */
    public function actionActivate(int $id): array
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
     * @return array|User
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = User::findOne($id)) !== null) {

            return $model;

        } else {
            return ResultHelper::json(500, '请检查数据是否存在');
        }
    }
}
