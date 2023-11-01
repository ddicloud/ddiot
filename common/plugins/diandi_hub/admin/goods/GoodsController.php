<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-01 20:28:55
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-28 16:43:56
 */

namespace common\plugins\diandi_hub\admin\goods;

use common\plugins\diandi_hub\models\goods\HubGoods as GoodsHubGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpec;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpecRel;
use common\plugins\diandi_hub\models\money\HubPriceConf;
use common\plugins\diandi_hub\models\Searchs\goods\HubGoodsSearch;
use common\plugins\diandi_hub\services\GoodsService;
use common\plugins\diandi_hub\services\GoodsService as ServicesGoodsService;
use common\plugins\diandi_hub\services\levelService;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * GoodsController implements the CRUD actions for HubGoods model.
 */
class GoodsController extends AController
{
    public $prices;

    public string $modelSearchName = 'HubGoodsSearch';

    public function actions()
    {
        $HubPriceConf = new HubPriceConf();
        $this->prices = $HubPriceConf->find()->where(['is_use' => 1])->indexBy('pricefield')->asArray()->all();
    }

    public function actionAttribute()
    {
        global  $_GPC;
        if (Yii::$app->request->isPost) {
            $model = new GoodsHubGoods();
            $attribute = $model->attributeLabels();

            return ResultHelper::json(200, '初始化成功', [
                'attribute' => $attribute,
                'prices' => $this->prices,
            ]);
        }
    }

    /**
     * Lists all HubGoods models.
     *
     * @return array
     */
    public function actionIndex()
    {
        global  $_GPC;
        $searchModel = new HubGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'prices' => $this->prices,
        ]);
    }

    /**
     * Displays a single HubGoods model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $detail = GoodsHubGoods::find()->where(['id' => $id])->with('goods')->asArray()->one();

        $detail['oneOptions'] = $detail['one_options'];
        $detail['twoOptions'] = $detail['two_options'];
        $detail['threeOptions'] = $detail['three_options'];

        $detail['levelsValue'] = ServicesGoodsService::getGoodsRules($id);
        return ResultHelper::json(200, '获取成功', $detail);
    }

    /**
     * Creates a new HubGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        global  $_GPC;
        // 商品ID
        $goods_id = Yii::$app->request->input('goods_id');
        // 分销类型（比例和价格）
        $type = Yii::$app->request->input('type');
        // 不同等级对应的分销参数
        $levelsValue = Yii::$app->request->input('levelsValue');
        // 商品价格
        $goods_price = Yii::$app->request->input('goods_price');
        // 默认一级分销比例
        $oneOptions = Yii::$app->request->input('oneOptions');
        // 默认二级分销比例
        $twoOptions = Yii::$app->request->input('twoOptions');
        // 默认三级分销比例
        $threeOptions = Yii::$app->request->input('threeOptions');

        $share_title = Yii::$app->request->input('share_title');
        $share_desc = Yii::$app->request->input('share_desc');
        $share_img = Yii::$app->request->input('share_img');

        $Res = ServicesGoodsService::addGoodsRule($goods_id, $share_title, $share_desc, $share_img, $type, $levelsValue, $oneOptions, $twoOptions, $threeOptions);

        if ($Res) {
            return ResultHelper::json(200, '添加成功');
        }

        return ResultHelper::json(401, '添加失败');
    }

    public function actionPostdata()
    {
        global  $_GPC;
        $goods_id = Yii::$app->request->input('goods_id');
    }

    public function actionDetail()
    {
        global  $_GPC;
        $model = $this->findModel(Yii::$app->request->input('id'));
        $goods_id = $model['goods_id'];

        $list = ServicesGoodsService::goodsDis($goods_id);

        $levels = [];

        $levels = levelService::getLevels();
        foreach ($levels as $key => &$value) {
            $value['money1'] = $value['money2'] = $value['money3'] = '';
        }

        return ResultHelper::json(200, '获取成功', ['list' => $list, 'levels' => $levels]);
    }

    public function actionGethtml()
    {
        global  $_GPC;
        if (Yii::$app->request->isPost) {
            $DdGoodsSpecRel = new HubGoodsBaseSpecRel();
            $html = $DdGoodsSpecRel->buildHtml(Yii::$app->request->input('goods_id'));

            return ResultHelper::json(200, '请求成功', $html);
        }
    }

    /**
     * Updates an existing HubGoods model.
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
        global $_GPC;

        $model = $this->findModel($id);

        // 商品ID
        $goods_id = Yii::$app->request->input('goods_id');
        // 分销类型（比例和价格）
        $type = Yii::$app->request->input('type');
        // 不同等级对应的分销参数
        $levelsValue = Yii::$app->request->input('levelsValue');
        // 商品价格
        $goods_price = Yii::$app->request->input('goods_price');
        // 默认一级分销比例
        $oneOptions = Yii::$app->request->input('oneOptions');
        // 默认二级分销比例
        $twoOptions = Yii::$app->request->input('twoOptions');
        // 默认三级分销比例
        $threeOptions = Yii::$app->request->input('threeOptions');

        $share_title = Yii::$app->request->input('share_title');
        $share_desc = Yii::$app->request->input('share_desc');
        $share_img = Yii::$app->request->input('share_img');

        $Res = ServicesGoodsService::upGoodsRule($id, $goods_id, $share_title, $share_desc, $share_img, $type, $levelsValue, $oneOptions, $twoOptions, $threeOptions);

        if ($Res) {
            return ResultHelper::json(200, '编辑成功');
        }

        return ResultHelper::json(401, '编辑失败');
    }

    /**
     * Deletes an existing HubGoods model.
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
        $model = $this->findModel($id);
        $goods_id = $model['goods_id'];
        ServicesGoodsService::deleteGoodsRule($id);
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    public function actionGoodslist()
    {
        global  $_GPC;
        $keywords = Yii::$app->request->input('keywords');
        $list = [];

        $list = GoodsService::getList(0, $keywords);

        foreach ($list as $key => &$value) {
            $value['images'] = is_array($value['images']) ? $value['images'] : [];
        }

        $model = new GoodsHubGoods();

        $levels = [];

        $levels = levelService::getLevels();
        foreach ($levels as $key => &$value) {
            $value['money1'] = $value['money2'] = $value['money3'] = '';
        }

        return ResultHelper::json(200, '请求成功', [
            'list' => $list,
            'levels' => $levels,
        ]);
    }

    public function actionSpechtml()
    {
        global  $_GPC;
        $goods_id = Yii::$app->request->post();
        $DdGoodsSpecRel = new HubGoodsBaseSpecRel();
        $DdGoodsSpecRel->buildHtml($goods_id);
    }

    /**
     * Finds the HubGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubGoods the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsHubGoods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
