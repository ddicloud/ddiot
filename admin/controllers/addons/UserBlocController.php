<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-01 11:43:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-10 18:55:53
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\UserStore;
use diandi\addons\components\BlocUser;
use diandi\addons\models\BlocStore;
use diandi\addons\models\searchs\UserBlocSearch;
use diandi\addons\models\UserBloc;
use diandi\admin\models\User as ModelsUser;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * UserBlocController implements the CRUD actions for UserBloc model.
 */
class UserBlocController extends AController
{
    public $modelClass = '';

    public $bloc_id;

    public $searchLevel = 0;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        $bloc_id = Yii::$app->request->get('bloc_id');
        $this->bloc_id = $bloc_id;
    }

    /**
     * Lists all UserBloc models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $bloc_id = Yii::$app->request->get('bloc_id');
        $searchModel = new UserBlocSearch(['bloc_id' => $bloc_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // 获取当前用户所有的公司
        $blocs = BlocUser::getMybloc();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'bloc_id' => $this->bloc_id,
        ]);
    }

    /**
     * Displays a single UserBloc model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'bloc_id' => $this->bloc_id,
        ]);
    }

    /**
     * Creates a new UserBloc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserBloc();
        $model->status = 1;

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $user_id = $data['user_id'];
            $store_id = $data['store_id'];
            $status = $data['status'];
            $bloc_id = 0;
            $list = BlocStore::find()->where(['store_id' => $store_id])->select(['bloc_id', 'store_id'])->asArray()->all();
            foreach ($list as $key => $value) {
                $_model = clone $model;
                $_model->setAttributes([
                    'user_id' => $user_id,
                    'bloc_id' => $value['bloc_id'],
                    'store_id' => $value['store_id'],
                    'status' => $status,
                    'create_time' => time(),
                ]);
                if (!$_model->save()) {
                    $msg = ErrorsHelper::getModelError($_model);

                    return ResultHelper::json(400, $msg, []);
                }

                $bloc_id = $value['bloc_id'];
            }

            return ResultHelper::json(200, '添加成功', [
                'url' => Url::to(['index', 'bloc_id' => $bloc_id]),
                ]);
        }

        return $this->render('create', [
            'model' => $model,
            'bloc_id' => $this->bloc_id,
        ]);
    }

    /**
     * Updates an existing UserBloc model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'bloc_id' => $model->bloc_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'bloc_id' => $this->bloc_id,
        ]);
    }

    public function actionGetstore()
    {
        global $_GPC;

        $bloc_id = $_GPC['bloc_id'];

        $user_id = $_GPC['user_id'];

        if (!$user_id) {
            return ResultHelper::json(400, '请先选择管理员', []);
        }

        $userStore = UserStore::find()->where([
                'user_id' => $user_id,
            ])->select('store_id')->asArray()->column();

        $list = BlocStore::find()->where(['bloc_id' => $bloc_id])->asArray()->all();

        $lists = [];

        foreach ($list as $key => &$value) {
            if (!in_array($value['store_id'], $userStore)) {
                $value['logo'] = ImageHelper::tomedia($value['logo']);
                $lists[] = $value;
            }
        }

        return  ResultHelper::json(200, '请求成功', $lists);
    }

    public function actionGetuser()
    {
        global $_GPC;
        $bloc_id = $_GPC['bloc_id'];
        // 查询普通的管理员
        $userlist = ModelsUser::find()->where([])->select(['username', 'avatar', 'id'])->asArray()->all();
        foreach ($userlist as $key => &$value) {
            $value['avatar'] = ImageHelper::tomedia($value['avatar']);
        }

        return  ResultHelper::json(200, '请求成功', $userlist);
    }

    /**
     * Deletes an existing UserBloc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'bloc_id' => $this->findModel($id)->bloc_id]);
    }

    /**
     * Finds the UserBloc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return UserBloc the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserBloc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
