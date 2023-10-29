<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-08 10:19:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-09 11:56:42
 */

namespace common\plugins\diandi_hub\admin\goods;

use common\plugins\diandi_hub\models\DdCategory;
use common\plugins\diandi_hub\models\goods\HubCategory;
use common\plugins\diandi_hub\models\Searchs\goods\HubCategorySearch as SearchsHubCategorySearch;
use common\plugins\diandi_hub\services\GoodsService;
use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * DdCategoryController implements the CRUD actions for DdCategory model.
 */
class DdCategoryController extends AController
{
    public string $modelSearchName = 'HubCategorySearch';

    /**
     * Lists all DdCategory models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        global $_GPC;
        $searchModel = new SearchsHubCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = ArrayHelper::objectToarray($dataProvider);
        $list = $dataProvider['allModels'];
        foreach ($list as $key => &$value) {
            $value['image_id'] = ImageHelper::tomedia($value['image_id']);
        }
        $lists = ArrayHelper::itemsMerge($list, 0, 'category_id', 'parent_id', 'children');
        $one_category = HubCategory::find()->where(['parent_id' => 0, 'store_id' => $_GPC['store_id'], 'bloc_id' => $_GPC['bloc_id']])->asArray()->all();

        return ResultHelper::json(200, '获取成功', [
            'list' => $lists,
            'one_category' => $one_category,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdCategory model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $detail = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $detail);
    }

    public function actionInit()
    {
        $model = new HubCategory();

        $where = [];

        $bloc_id = Yii::$app->params['bloc_id'];

        $store_id = Yii::$app->params['store_id'];
        $where['parent_id'] = 0;

        if ($bloc_id) {
            $where['bloc_id'] = $bloc_id;
        }
        if ($store_id) {
            $where['store_id'] = $store_id;
        }

        $catedata = $model::find()->where($where)->asArray()->all();
        array_unshift($catedata, ['category_id' => 0, 'name' => '顶级分类']);

        return ResultHelper::json(200, '获取成功', $catedata);
    }

    /**
     * Creates a new DdCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HubCategory();
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '新建成功', []);
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $message, []);
        }
    }

    /**
     * Updates an existing DdCategory model.
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
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', []);
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $message, []);
        }
    }

    public function actionGoodslist()
    {
        global  $_GPC;
        $keywords = $_GPC['keywords'];
        $list = [];

        $list = GoodsService::getList(0, 0, $keywords, 10);

        foreach ($list as $key => &$value) {
            $value['images'] = is_array($value['images']) ? $value['images'] : [];
        }

        return ResultHelper::json(200, '请求成功', [
             'list' => $list,
            ]);
    }

    /**
     * Deletes an existing DdCategory model.
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

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * @return string
     */
    public function actionChildcate()
    {
        global $_GPC;
        $parent_id = $_GPC['parent_id'];
        $cates = HubCategory::findAll(['parent_id' => $parent_id]);

        return ResultHelper::json(200, '获取成功', $cates);
    }

    /**
     * Finds the DdCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DdCategory the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
