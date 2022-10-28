<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 11:58:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 16:59:53
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\services\common\AddonsService as CommonAddonsService;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\DdAddons;
use diandi\addons\models\searchs\DdAddons as DdAddonsSearch;
use diandi\addons\services\addonsService;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * AddonsController implements the CRUD actions for DdAddons model.
 */
class AddonsController extends AController
{
    public $modelClass = 'DdAddons';

    public $searchLevel = 0;

    public function actionInfo()
    {
        global $_GPC;
        $addons = $_GPC['addons'];
        $info = CommonAddonsService::getAddonsInfo($addons);

        return ResultHelper::json(200, '获取成功', $info);
    }

    /**
     * Lists all DdAddons models.
     *
     * @return mixed
     */
    public function actionList()
    {
        $module_names = [];
        $AddonsUser = new AddonsUser();

        // 根据用户获取应用权限
        $module_names = $AddonsUser->find()->where([
            'user_id' => Yii::$app->user->id,
        ])->select(['module_name'])->column();

        $searchModel = new DdAddonsSearch([
            'module_names' => $module_names,
            // 'parent_mids' => 0,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'userId' => Yii::$app->user->id,
        ]);
    }

    public function actionChild()
    {
        global $_GPC;
        $parent_mid = $_GPC['parent_mid'];
        if (empty($parent_mid)) {
            return ResultHelper::json(400, '父级应用parent_mid不能为空');
        }
        $AddonsUser = new AddonsUser();

        // 根据用户获取应用权限
        $module_names = $AddonsUser->find()->where([
            'user_id' => Yii::$app->user->id,
        ])->select(['module_name'])->column();
        $list = DdAddons::find()->where(['identifie' => $module_names])->andWhere("FIND_IN_SET($parent_mid,parent_mids)")->asArray()->all();

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * 未安装.
     */
    public function actionUninstalled()
    {
        global $_GPC;
        $title = $_GPC['title'];
        $list = addonsService::unAddons($title);

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
        ]);
    }

    /**
     * Displays a single DdAddons model.
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
        ]);
    }

    // 显示logo
    public function actionLogo()
    {
        $this->layout = false;
        $identifie = Yii::$app->request->get('addon');
        $logo = addonsService::getLogo($identifie);

        return $this->render('logo', [
            'logo' => $logo,
        ]);
    }

    /**
     * Creates a new DdAddons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DdAddons();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->mid]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DdAddons model.
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
            return $this->redirect(['view', 'id' => $model->mid]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DdAddons model.
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

        return $this->redirect(['index']);
    }

    /**
     * Finds the DdAddons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DdAddons the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DdAddons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
