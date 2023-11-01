<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-04 17:15:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:42
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\models\enums\GiftCate;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseCollect;
use common\plugins\diandi_hub\services\GoodsService;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class GoodsController extends AController
{
    public $modelClass = '';
    protected array $authOptional = ['goodgift', 'detail', 'lists', 'search'];

    public int $searchLevel = 0;

    /**
     * @SWG\Get(path="/diandi_hub/goods/search",
     *     tags={"商品"},
     *     summary="商品检索",
     *     @SWG\Response(
     *          response = 200,
     *          description = "关键词商品检索",
     *     ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="page",
     *          type="integer",
     *          description="分页",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="query",
     *          name="pageSize",
     *          type="integer",
     *          description="显示条数",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="query",
     *          name="keywords",
     *          type="string",
     *          description="关键词",
     *          required=false,
     *   ),
     * )
     */
    public function actionSearch(): array
    {
        global $_GPC;
        $keytwords = $_GPC['keywords'];
        $pageSize = Yii::$app->request->input('pageSize',10);
        $user_id = Yii::$app->user->identity->user_id;

        $list = GoodsService::getList(0, $keytwords, 'not in', $pageSize, $user_id);

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * @SWG\Get(path="/diandi_hub/goods/detail",
     *     tags={"商品"},
     *     summary="商品详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "商品详情",
     *     ),
     *     @SWG\Parameter(
     *        in="query",
     *        name="access-token",
     *        type="string",
     *        description="用户秘钥",
     *        required=true,
     *   ),
     *     @SWG\Parameter(
     *            in="query",
     *            name="goods_id",
     *            type="integer",
     *            description="商品id",
     *            required=true,
     *   ),
     * )
     */
    public function actionDetail(): array
    {
        global $_GPC;
        $goods_id = $_GPC['goods_id'];
        $member_id = Yii::$app->user->identity->user_id;

        if (HubGoodsBaseCollect::find()->where(['member_id' => $member_id, 'goods_id' => $goods_id])->one()) {
            $collected = true;
        } else {
            $collected = false;
        }
        $goods_type = $_GPC['goods_type'] ? $_GPC['goods_type'] : 2;
        $order_type = $_GPC['order_type'];

        switch ($goods_type) {
            case GoodsTypeStatus::getValueByName('店铺商品'):
                // 店铺商品
                $lists = GoodsService::getDetail($goods_id);
                $list['goods'] = $lists;
                $list['dis'] = $lists;
                $order_type = OrderTypeStatus::getValueByName('在线订单');
                break;
            case  GoodsTypeStatus::getValueByName('礼包商品'):
                // 礼包商品
                $list = GoodsService::Giftsdetail($goods_id);
                $order_type = OrderTypeStatus::getValueByName('尊享订单');

                break;
            case  GoodsTypeStatus::getValueByName('自营商品'):
                // 自营商品
                $list = GoodsService::getSelfDetail($goods_id);
                $order_type = OrderTypeStatus::getValueByName('自营订单');

                break;
        }
        if (isset($list['goods']['label'])) {
            $list['goods']['label'] = unserialize($list['goods']['label']);
        }

        return ResultHelper::json(200, '获取成功', [
            'goods' => $list['goods'],
            'dis' => $list['dis'],
            'order_type' => $order_type,
            'collected' => $collected,
        ]);
    }

    // 获取礼包商品
    public function actionGoodgift(): array
    {
        global $_GPC;

        $page = Yii::$app->request->get('page', 1);
        $pageSize = 100; // $_GPC['pageSize'];
        $keywords = $_GPC['keywords'];
        $list = GoodsService::goodsGifts($keywords, $page, $pageSize);
        $navbar = GiftCate::listData();
        $navbars = [];
        foreach ($navbar as $key => $value) {
            $navbars[$key] = [
                'name' => $value,
            ];
        }

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
            'navbar' => $navbars,
        ]);
    }

    public function actionCollect(): array
    {
        global $_GPC;
        $user_id = Yii::$app->user->identity->user_id;

        $goods_id = $_GPC['goods_id'];
        $goods_type = $_GPC['goods_type'];
        $HubGoodsCollect = new HubGoodsBaseCollect();
        $is_collect = HubGoodsBaseCollect::find()->where(['goods_id' => $goods_id, 'member_id' => $user_id, 'goods_type' => $goods_type])->asArray()->one();
        $data = [
            'goods_id' => $goods_id,
            'goods_type' => $goods_type,
            'member_id' => $user_id,
        ];
        if (empty($is_collect)) {
            $HubGoodsCollect->load($data, '');

            if ($HubGoodsCollect->save()) {
                return ResultHelper::json(200, '收藏成功', []);
            } else {
                return ResultHelper::json(400, '收藏失败', []);
            }
        } else {
            $HubGoodsCollect->deleteAll($data);

            return ResultHelper::json(200, '取消成功', []);
        }
    }

    /**
     * @SWG\Get(path="/diandi_hub/goods/lists",
     *     tags={"商品"},
     *     summary="Retrieves the collection of Goods resources.",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Goods collection response",
     *     ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="bloc_id",
     *          type="number",
     *          description="公司id",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="query",
     *          name="store_id",
     *          type="number",
     *          description="商户id",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="query",
     *          name="page",
     *          type="string",
     *          description="分页",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="query",
     *          name="pageSize",
     *          type="string",
     *          description="显示条数",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="query",
     *          name="category_pid",
     *          type="integer",
     *          description="父级分类id",
     *          required=false,
     *   ),
     *   @SWG\Parameter(
     *          in="query",
     *          name="category_id",
     *          type="integer",
     *          description="分类id",
     *          required=false,
     *   ),
     * )
     */
    public function actionLists(): array
    {
        global $_GPC;
        $pageSize = $_GPC['pageSize'];
        $keywords = $_GPC['keywords'];
        $goods_price = $_GPC['goods_price'];
        $sales_initial = $_GPC['sales_initial'];
        $label_id = $_GPC['label_id'];
        $orderby = ' goods_sort desc';
        // 降序
        if ($goods_price == 'desc') {
            $orderby .= ' , goods_price desc';
        } elseif ($goods_price == 'asc') {
            // 升序
            $orderby .= ' , goods_price asc';
        }

        // 降序
        if ($sales_initial == 'desc') {
            $orderby .= ' , sales_initial desc';
        } elseif ($sales_initial == 'asc') {
            // 升序
            $orderby .= ' , sales_initial asc';
        }

        $user_id = Yii::$app->user->identity->user_id;

        $list = GoodsService::getLists($_GPC['category_pid'], $_GPC['category_id'], $keywords, $pageSize, $user_id, $orderby, $label_id);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionPainter(): array
    {
        global $_GPC;

        $user_id = Yii::$app->user->identity->user_id;
        $goods_id = $_GPC['goods_id'];
        $conf = GoodsService::CreatePainter($goods_id, $user_id);

        return ResultHelper::json(200, '获取成功', $conf);
    }
}
