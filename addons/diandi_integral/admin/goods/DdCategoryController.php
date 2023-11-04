<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-08 10:19:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-16 14:39:36
 */

namespace addons\diandi_integral\admin\goods;

use addons\diandi_integral\models\IntegralCategory;
use addons\diandi_integral\models\searchs\IntegralCategorySearch;
use addons\diandi_integral\services\GoodsService;
use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * DdCategoryController implements the CRUD actions for DdCategory model.
 */
class DdCategoryController extends AController
{
    public string $modelSearchName = 'IntegralCategorySearch';

    public function actionIndex(): array
    {
        $searchModel = new IntegralCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = ArrayHelper::objectToarray($dataProvider);
        $list = $dataProvider['allModels'];
        foreach ($list as $key => &$value) {
            $value['image_id'] = ImageHelper::tomedia($value['image_id']);
        }
        $lists = ArrayHelper::itemsMerge($list, 0, 'category_id', 'parent_id', 'children');

        return ResultHelper::json(200, '获取成功', [
            'lists' => $lists,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id): array
    {
        $model = IntegralCategory::find()->where(['category_id' => $id])->asArray()->one();

        $model['blocs'] = [$model['bloc_id'], $model['store_id']];


        return ResultHelper::json(200, '获取成功', ['model' => $model]);
    }


    public function actionInit(): array
   {
        $model = new IntegralCategory();

        $where = [];
        $lists = [];
        $blocs =\Yii::$app->request->input('blocs');

        $bloc_id = $blocs['bloc_id'];

        $store_id = $blocs['store_id'];

        if ($bloc_id) {
            $where['bloc_id'] = $bloc_id;
        }
        if ($store_id) {
            $where['store_id'] = $store_id;
        }

        if (Yii::$app->request->input('cate_level') === 1) {
            $where['parent_id'] = 0;
        }

        $catedata = $model::find()->where($where)->asArray()->all();

        $lists = ArrayHelper::itemsMerge($catedata, 0, 'category_id', 'parent_id', 'child');

        return ResultHelper::json(200, '获取成功',\Yii::$app->request->input('cate_level') === 1 ? $catedata : $lists);
    }


    public function actionCreate(): array
   {
        $model = new IntegralCategory();
        $data = \Yii::$app->request->input();
        $blocs =\Yii::$app->request->input('blocs');
        $data['bloc_id'] = $blocs[0];
        $data['store_id'] = $blocs[1];

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '添加成功');
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $message);
        }
    }


    public function actionUpdate($id): array
   {
        try {
            $model = $this->findModel($id);
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        $data = \Yii::$app->request->input();
        $blocs =\Yii::$app->request->input('blocs');
        $data['bloc_id'] = $blocs[0];
        $data['store_id'] = $blocs[1];

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '添加成功');
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $message);
        }
    }


    public function actionGoodslist(): array
   {
        $keywords =\Yii::$app->request->input('keywords');
        $list = [];

        $list = GoodsService::getList(0, 0, $keywords, 10);

        foreach ($list as $key => &$value) {
            $value['images'] = is_array($value['images']) ? $value['images'] : [];
        }

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
        ]);
    }


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


    public function actionChildcate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Yii::$app->request->post();
        $parent_id = $data['parent_id'];
        $cates = IntegralCategory::findAll(['parent_id' => $parent_id]);

        return ResultHelper::json(200, '成功', $cates);

    }

    /**
     * Finds the DdCategory model based on its primary key value.
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
        if (($model = IntegralCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
