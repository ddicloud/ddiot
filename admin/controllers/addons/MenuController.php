<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 13:30:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:00:32
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use diandi\addons\models\searchs\DdAddons;
use diandi\addons\services\addonsService;
use diandi\admin\components\Helper;
use diandi\admin\models\Menu;
use diandi\admin\models\searchs\Menu as MenuSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii2mod\editable\EditableAction;

/**
 * MenuController implements the CRUD actions for Menu model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class MenuController extends AController
{
    public $modelClass = '';

    public $searchLevel = 0;

    public function actions()
    {
        return [
            'update-files' => [
                'class' => EditableAction::class,
                'modelClass' => Menu::class,
                'pkColumn' => 'id',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        Yii::$app->params['plugins'] = 'sysai';

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $addon = Yii::$app->request->get('addon');
        $rules = addonsService::addonsRules($addon);
        $parentMenu = Menu::findAll(['parent' => 0]);

        $query = Menu::find()->where(['is_sys' => 'addons', 'module_name' => $addon]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'rules' => $rules,
            'parentMenu' => $parentMenu,
        ]);
    }

    /**
     * Displays a single Menu model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();
        $addon = Yii::$app->request->get('addon');
        $rules = addonsService::addonsRules($addon);

        $defaultroute = "/{$addon}/default/index";
        $sql = "`route` <> '{$defaultroute}' || route is NULL";

        $parentMenus = Menu::find()->where(['module_name' => $addon])->andWhere($sql)->asArray()->all();
        $parentMenu = ArrayHelper::itemsMergeDropDown(ArrayHelper::itemsMerge($parentMenus, 0, 'id', 'parent', $child = '-'), 'id', 'name');
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if ($model->load($data) && $model->save()) {
                Helper::invalidate();

                return $this->redirect(['view', 'id' => $model->id, 'addon' => $addon]);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                throw new BadRequestHttpException($msg);
            }
        } else {
            $addons = DdAddons::find()->asArray()->all();
            $route = Menu::getSavedRoutes();
            foreach ($route as $key => &$value) {
                if ($addon && strpos($value, $addon) !== false) {
                    $routes[] = $value;
                }
            }

            return $this->render('create', [
                'model' => $model,
                'addon' => $addon,
                'rules' => $rules,
                'routes' => $routes,
                'parentMenu' => $parentMenu,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $addon = $this->findModel($id)->module_name;

        if ($model->menuParent) {
            $model->parent_name = $model->menuParent->name;
        }
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $data['Menu']['parent'] = $data['Menu']['parent'] == '顶级导航' ? null : $data['Menu']['parent'];

            if ($model->load($data) && $model->save()) {
                Helper::invalidate();

                return $this->redirect(['view', 'addon' => $addon, 'id' => $model->id]);
            }
        } else {
            $addons = DdAddons::find()->asArray()->all();
            $rules = addonsService::addonsRules($addon);

            $defaultroute = "/{$addon}/default/index";
            $sql = "`route` <> '{$defaultroute}' || route is NULL";

            $parentMenus = Menu::find()->where(['module_name' => $addon])->andWhere($sql)->asArray()->all();
            $parentMenu = ArrayHelper::itemsMergeDropDown(ArrayHelper::itemsMerge($parentMenus, null, 'id', 'parent', $child = '-'), 'id', 'name');

            $addons = DdAddons::find()->asArray()->all();
            $route = Menu::getSavedRoutes();
            foreach ($route as $key => &$value) {
                if ($addon && strpos($value, $addon) !== false) {
                    $routes[] = $value;
                }
            }

            return $this->render('update', [
                'model' => $model,
                'addons' => $addons,
                'addon' => $addon,
                'rules' => $rules,
                'routes' => $routes,
                'parentMenu' => $parentMenu,
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $addon = $this->findModel($id)->module_name;

        $this->findModel($id)->delete();
        Helper::invalidate();

        return $this->redirect(['index', 'addon' => $addon]);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Menu the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请检查数据是否存在');
        }
    }
}
