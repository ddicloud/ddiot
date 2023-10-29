<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-10 14:00:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-29 11:52:40
 */

namespace common\plugins\diandi_hub\api;

use common\plugins\diandi_hub\models\goods\HubGoodsBaseCollect;
use common\plugins\diandi_hub\services\CartService;
use api\controllers\AController;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;

/**
 * Class CartController.
 */
class CartController extends AController
{
    public $modelClass = '\common\models\DdGoods';

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

    /**
     * @SWG\Post(path="/diandi_hub/cart/add",
     *     tags={"购物车"},
     *     summary="Retrieves the collection of Goods resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Goods collection response",
     *     ),
     *     @SWG\Parameter(
     *     in="query",
     *     name="access-token",
     *     type="string",
     *     description="用户验证token",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="goods_id",
     *     type="string",
     *     description="商品id",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="num",
     *     type="integer",
     *     description="商品数量",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="spec_id",
     *     type="string",
     *     description="规格组合id",
     *     required=false,
     *   ),
     * )
     */
    public function actionAdd()
    {
        global $_GPC;
        $user_id = Yii::$app->user->identity->member_id??0;

        $goods_id = intval($_GPC['goods_id']);
        $num = intval($_GPC['num']);
        $spec_id = $_GPC['spec_id'];

        $list = CartService::confirm($user_id, $goods_id, $num, $spec_id);

        return ResultHelper::json(200, '加入购物车成功', $list);
    }

    /**
     * @SWG\Post(path="/diandi_hub/cart/list",
     *     tags={"购物车"},
     *     summary="获取购物车列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "获取购物车列表",
     *     ),
     *     @SWG\Parameter(
     *     in="query",
     *     name="access-token",
     *     type="string",
     *     description="用户验证token",
     *     required=true,
     *   )
     * )
     */
    public function actionList()
    {
        global $_GPC;
        $user_id = Yii::$app->user->identity->member_id??0;
        $cart_ids = [];
        if (isset($_GPC['cart_ids'])) {
            if (is_array($_GPC['cart_ids'])) {
                $cart_ids = $_GPC['cart_ids'];
            } else {
                $cart_ids = explode(',', $_GPC['cart_ids']);
            }
        }

        $express_type = $_GPC['express_type'];
        $region_id = $_GPC['region_id'];
        $goods_id = $_GPC['goods_id'];
        $goods_type = $_GPC['goods_type'];
        $express_id = $_GPC['express_id'];
        $list = CartService::list($user_id, $cart_ids, $express_type, $region_id, $express_id);

        $is_collect = HubGoodsBaseCollect::find()->where(['goods_id' => $goods_id, 'member_id' => $user_id, 'goods_type' => $goods_type])->one();

        $list['is_collect'] = $is_collect;
        $list['logo'] = ImageHelper::tomedia($list['logo']);

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * @SWG\Post(path="/diandi_hub/cart/clear",
     *     tags={"购物车"},
     *     summary="清空购物车",
     *     @SWG\Response(
     *         response = 200,
     *         description = "清空购物车",
     *     ),
     *     @SWG\Parameter(
     *     in="query",
     *     name="access-token",
     *     type="string",
     *     description="用户验证token",
     *     required=true,
     *   )
     * )
     */
    public function actionClear()
    {
        $user_id = Yii::$app->user->identity->member_id??0;
        $list = CartService::clearAll($user_id);

        return ResultHelper::json(200, '清空成功', $list);
    }

    /**
     * @SWG\Post(path="/diandi_hub/cart/deletecart",
     *     tags={"购物车"},
     *     summary="Retrieves the collection of Goods resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Goods collection response",
     *     ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="access-token",
     *          type="string",
     *          description="用户验证token",
     *          required=true,
     *     ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="cart_ids",
     *     type="string",
     *     description="购物车id集合",
     *     required=false,
     *   )
     * )
     */
    public function actionDeletecart()
    {
        global $_GPC;

        $user_id = Yii::$app->user->identity->member_id??0;
        $data = Yii::$app->request->post();
        $cart_ids = $_GPC['cart_ids'];

        $list = CartService::deleteCart($user_id, $cart_ids);

        return ResultHelper::json(200, '删除成功', $list);
    }
}
