<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-30 02:12:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-19 10:48:53
 */

namespace common\plugins\diandi_hub\admin\goods;

use common\plugins\diandi_hub\models\advertising\HubLocation as AdvertisingHubLocation;
use common\plugins\diandi_hub\models\advertising\HubLocationGoods;
use common\plugins\diandi_hub\models\goods\HubGoods as GoodsHubGoods;
use common\plugins\diandi_hub\models\Searchs\location\LocationGoodsSearch as LocationLocationGoodsSearch;
use common\plugins\diandi_hub\services\GoodsService;
use common\plugins\diandi_hub\services\levelService;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;
use yii2mod\editable\EditableAction;

/**
 * LocationGoodsController implements the CRUD actions for LocationGoods model.
 */
class LocationGoodsController extends AController
{
    public string $modelSearchName = 'LocationGoodsSearch';

    public function actions()
    {
        return [
            'change-order' => [
                'class' => EditableAction::class,
                'modelClass' => HubLocationGoods::class,
            ],
        ];
    }

    /**
     * Lists all LocationGoods models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new LocationLocationGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $where = [];

        $where['store_id'] = Yii::$app->params['store_id'];
        $where['bloc_id'] = Yii::$app->params['bloc_id'];

        $list = AdvertisingHubLocation::find()->select(['name', 'id'])->indexBy('id')->where($where)->all();

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'list' => $list,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGoodslocation()
    {
        global $_GPC;

        $adv_id =\Yii::$app->request->input('adv_id');
        $good_ids =\Yii::$app->request->input('good_ids');

        if (empty($adv_id)) {
            return ResultHelper::json(400, '请选择广告位置');
        }
        if (empty($good_ids)) {
            return ResultHelper::json(400, '请选择商品id');
        }
        $location = AdvertisingHubLocation::findOne($adv_id);
        $model = new HubLocationGoods();

        foreach ($good_ids as $key => $value) {
            $_model = clone $model;
            $data = [
                'store_id' => Yii::$app->params['store_id'],
                'bloc_id' => Yii::$app->params['bloc_id'],
                'goods_id' => $value,
                'location_id' => $adv_id,
                'mark' => $location['mark'],
                'is_show' => 0,
            ];
            $_model->setAttributes($data);
            $_model->save();
        }

        return ResultHelper::json(200, '创建成功', []);
    }

    /**
     * Displays a single LocationGoods model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return ResultHelper::json(200, '获取成功', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionGoodslist()
    {
        global $_GPC;
        $keywords =\Yii::$app->request->input('keywords');

        $adv_id =\Yii::$app->request->input('adv_id');

        if (!empty(Yii::$app->request->input('type')) ||\Yii::$app->request->input('type') == 0) {
            // 0 不存在,1存在
            $type = intval(Yii::$app->request->input('type'));
        } else {
            return ResultHelper::json(400, '缺少类型');
        }

        if (empty($adv_id)) {
            return ResultHelper::json(400, '请选择广告位置');
        }

        $pageSize = intval(Yii::$app->request->input('pageSize'), 10);

        $lists = [];

        $Location = GoodsService::getListLocation($adv_id, $keywords, $type, $pageSize);
        $lists = $Location['list'];
        $count = $Location['count'];
        if (is_array($lists)) {
            foreach ($lists as $key => &$value) {
                $value['images'] = is_array($value['images']) ? $value['images'] : [];
            }
        }

        $model = new GoodsHubGoods();

        $levels = [];

        $levels = levelService::getLevels();
        foreach ($levels as $key => &$value) {
            $value['money1'] = $value['money2'] = $value['money3'] = '';
        }

        return ResultHelper::json(200, '请求成功', [
             'list' => $lists,
             '_GPC' => $_GPC,
             'pageSize' => $pageSize,
             'count' => $count,
             'levels' => $levels,
            ]);
    }

    public function actionAdvlist()
    {
        global $_GPC;
        $where = [];

        $where['store_id'] = Yii::$app->params['store_id'];
        $where['bloc_id'] = Yii::$app->params['bloc_id'];
        if (empty(Yii::$app->request->input('type'))) {
            $where['type'] = 2;
        } else {
            $where['type'] =\Yii::$app->request->input('type');
        }

        $list = AdvertisingHubLocation::find()->where($where)->select(['*', 'name as text', 'id as value'])->asArray()->all();
        foreach ($list as $key => &$value) {
            $value['thumb'] = ImageHelper::tomedia($value['thumb']);
        }

        return ResultHelper::json(200, '获取成功', ['list' => $list]);
    }

    /**
     * Creates a new LocationGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubLocationGoods();

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
     * Updates an existing LocationGoods model.
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
     * Deletes an existing LocationGoods model.
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
        $res = $this->findModel($id)->delete();

        if ($res) {
            return ResultHelper::json(200, '删除成功', []);
        } else {
            return ResultHelper::json(401, '删除失败', []);
        }
    }

    public function actionDeletegoods()
    {
        global $_GPC;

        if (yii::$app->request->isPost) {
            $goods_id =\Yii::$app->request->input('goods_id');
            $location_id =\Yii::$app->request->input('adv_id');
            if (empty($goods_id)) {
                return ResultHelper::json(401, '缺少商品id');
            }
            if (empty($location_id)) {
                return ResultHelper::json(401, '广告位置id');
            }

            $res = HubLocationGoods::deleteAll([
                'goods_id' => $goods_id,
                'location_id' => $location_id,
                ]);

            if ($res) {
                return ResultHelper::json(200, '删除成功', []);
            } else {
                return ResultHelper::json(401, '删除失败', []);
            }
        }
    }

    /**
     * Finds the LocationGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return LocationGoods the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubLocationGoods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
