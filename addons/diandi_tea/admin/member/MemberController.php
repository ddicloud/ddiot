<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 14:06:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-24 11:09:47
 */

namespace addons\diandi_tea\admin\member;

use addons\diandi_tea\models\member\DiandiTeaMember;
use addons\diandi_tea\models\searchs\member\DiandiTeaMember as DiandiTeaMemberSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * MemberController implements the CRUD actions for DiandiTeaMember model.
 */
class MemberController extends AController
{
    public string $modelSearchName = 'DiandiTeaMember';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/member/index",
     *    tags={"会员"},
     *    summary="列表数据",
     *     @SWG\Response(
     *         response = 200,
     *         description = "列表数据",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="HonoraryAar[title]",
     *     type="string",
     *     description="标题",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="HonoraryAar[status]",
     *     type="integer",
     *     description="状态",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="HonoraryAar[type]",
     *     type="integer",
     *     description="类型",
     *     required=false,
     *   )
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new DiandiTeaMemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DiandiTeaMember model.
     *
     * @param int $id
     *
     * @return mixed
     *
     */
    public function actionView($id): array
    {
         try {
            $view = $this->findModel($id)->toArray();
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new DiandiTeaMember model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate(): array
    {
        $model = new DiandiTeaMember();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * Updates an existing DiandiTeaMember model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Deletes an existing DiandiTeaMember model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the DiandiTeaMember model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|ActiveRecord the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = DiandiTeaMember::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
