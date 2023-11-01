<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-20 01:45:07
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-26 17:42:44
 */

namespace common\plugins\diandi_hub\admin\store;

use common\plugins\diandi_hub\models\enums\StorePayStatus;
use common\plugins\diandi_hub\models\Searchs\store\HubAccountStorePay as HubAccountStorePaySearch;
use common\plugins\diandi_hub\models\store\HubAccountStorePay;
use common\plugins\diandi_hub\services\StoreService;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * StorepayController implements the CRUD actions for HubAccountStorePay model.
 */
class StorepayController extends AController
{
    public $modelName = 'HubAccountStorePay';

    public string $modelSearchName = 'HubAccountStorePay';

    /**
     * Lists all HubAccountStorePay models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubAccountStorePaySearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubAccountStorePay model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = HubAccountStorePay::find()->where(['id' => $id])->with(['member', 'affirm', 'operation'])->one();

        $status = StorePayStatus::listData();
        $model['create_time'] = date('Y-m-d H:i', $model['create_time']);
        $model['confirm_time'] = date('Y-m-d H:i', $model['confirm_time']);
        $model['update_time'] = date('Y-m-d H:i', $model['update_time']);
        $model['status'] = $status[$model['status']];

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new HubAccountStorePay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubAccountStorePay();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubAccountStorePay model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
   {
        $model = HubAccountStorePay::find()->where(['id' => $id])->with(['userbank'])->one();

        $member_id = $model['member_id'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->input('HubAccountStorePay')['status'] == 2) {
                $Res = StoreService::thawMoney($id);

                loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '后台确认订单结果', $Res);
            }
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubAccountStorePay model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the HubAccountStorePay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubAccountStorePay the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubAccountStorePay::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
