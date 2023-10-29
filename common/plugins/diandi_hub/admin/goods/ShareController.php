<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-07 10:35:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 14:16:19
 */

namespace common\plugins\diandi_hub\admin\goods;

use common\plugins\diandi_hub\models\goods\HubGoodsSubsidy;
use common\plugins\diandi_hub\models\Searchs\goods\HubGoodsSubsidy as HubGoodsSubsidySearch;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ShareController implements the CRUD actions for HubGoodsSubsidy model.
 */
class ShareController extends AController
{
    public string $modelSearchName = 'HubGoodsSubsidySearch';

    /**
     * Lists all HubGoodsSubsidy models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        global $_GPC;
        $goods_id = $_GPC['goods_id'];
        $searchModel = new HubGoodsSubsidySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'goods_id' => $goods_id,
        ]);
    }

    /**
     * Displays a single HubGoodsSubsidy model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;
        $goods_id = $_GPC['goods_id'];

        return ResultHelper::json(200,'获取成功',[
            'model' => $this->findModel($id),
            'goods_id' => $goods_id,
        ]);
    }

    /**
     * Creates a new HubGoodsSubsidy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        global $_GPC;
        $goods_id = $_GPC['goods_id'];
        $model = new HubGoodsSubsidy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'goods_id' => $goods_id]);
        }

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
        'goods_id' => $goods_id,
        ]);
    }

    /**
     * Updates an existing HubGoodsSubsidy model.
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
        global $_GPC;
        $goods_id = $_GPC['goods_id'];
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'goods_id' => $goods_id]);
        }

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
            'goods_id' => $goods_id,
        ]);
    }

    /**
     * Deletes an existing HubGoodsSubsidy model.
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
        global $_GPC;
        $goods_id = $_GPC['goods_id'];

        $this->findModel($id)->delete();

        return $this->redirect(['index', 'goods_id' => $goods_id]);
    }

    /**
     * Finds the HubGoodsSubsidy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubGoodsSubsidy the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubGoodsSubsidy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
