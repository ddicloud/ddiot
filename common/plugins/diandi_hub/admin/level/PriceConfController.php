<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-22 13:56:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:43:00
 */

namespace common\plugins\diandi_hub\admin\level;

use common\plugins\diandi_hub\models\HubPriceConf;
use common\plugins\diandi_hub\models\money\HubPriceConf as MoneyHubPriceConf;
use common\plugins\diandi_hub\models\Searchs\config\HubPriceConfSearch;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * PriceConfController implements the CRUD actions for HubPriceConf model.
 */
class PriceConfController extends AController
{
    /**
     * Lists all HubPriceConf models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubPriceConfSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubPriceConf model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return ResultHelper::json(200,'获取成功',[
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HubPriceConf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new MoneyHubPriceConf();

          if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
      return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubPriceConf model.
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
        $model = $this->findModel($id);

          if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
      return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubPriceConf model.
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
 return ResultHelper::json(200,'删除成功');
    }

    /**
     * Finds the HubPriceConf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubPriceConf the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MoneyHubPriceConf::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
