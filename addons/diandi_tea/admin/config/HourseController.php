<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-16 15:08:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-13 10:06:20
 */

namespace addons\diandi_tea\admin\config;

use addons\diandi_tea\models\config\TeaHourse;
use addons\diandi_tea\models\marketing\TeaSetMeal;
use addons\diandi_tea\models\searchs\config\TeaHourse as TeaHourseSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * HourseController implements the CRUD actions for TeaHourse model.
 */
class HourseController extends AController
{
    public string $modelSearchName = 'TeaHourse';

    public $modelClass = '';


    public function actionIndex(): array
    {
        $searchModel = new TeaHourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_tea/config/hourse/view",
     *    tags={"商铺包间"},
     *    summary="包间详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "包间详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionView($id): array
    {
        $view = TeaHourse::find()->where(['id' => $id])->asArray()->one();

        // $view['picture'] = ImageHelper::tomedia($view['picture']);
        if ($view['slide']) {
            $view['slide'] = json_decode($view['slide'], true);
        }
        if (!empty($view['set_meal_ids'])) {
            $set_meal_ids = explode(',', $view['set_meal_ids']);
            $list = TeaSetMeal::find()
                    ->where(['id' => $set_meal_ids])
                    ->asArray()
                    ->all();
        }
        $view['set_meal_name'] = $list;

        return ResultHelper::json(200, '获取成功', $view);
    }


    public function actionCreate(): array
    {
        $model = new TeaHourse();

        $data = Yii::$app->request->post();
        if ($data['slide']) {
            $data['slide'] = json_encode($data['slide']);
        }

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }


    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

        $data = Yii::$app->request->post();
        if ($data['slide']) {
            $data['slide'] = json_encode($data['slide']);
        }
        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * @SWG\Get(path="/diandi_tea/config/hourse/delete",
     *    tags={"商铺包间"},
     *    summary="删除包间",
     *     @SWG\Response(
     *         response = 200,
     *         description = "包间详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     * )
     */
    public function actionDelete($id): array
    {
        try {
            $this->findModel($id)->delete();
        } catch (StaleObjectException|NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the TeaHourse model based on its primary key value.
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
        if (($model = TeaHourse::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
