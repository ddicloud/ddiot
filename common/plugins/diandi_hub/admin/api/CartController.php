<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-10 14:00:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:25
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\models\goods\HubGoodsBaseCollect;
use common\plugins\diandi_hub\services\CartService;
use admin\controllers\AController;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;

/**
 * Class CartController.
 */
class CartController extends AController
{
    public $modelClass = '\common\models\DdGoods';

    public int $searchLevel = 0;


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
    public function actionAdd(): array
    {
        global $_GPC;
        $user_id = Yii::$app->user->identity->user_id;

        $goods_id = intval(Yii::$app->request->input('goods_id'));
        $num = intval(Yii::$app->request->input('num'));
        $spec_id = Yii::$app->request->input('spec_id');

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
    public function actionList(): array
    {
        global $_GPC;
        $user_id = Yii::$app->user->identity->user_id;
        $cart_ids = [];
        if (Yii::$app->request->input('cart_ids') !== null) {
            if (is_array(Yii::$app->request->input('cart_ids'))) {
                $cart_ids = Yii::$app->request->input('cart_ids');
            } else {
                $cart_ids = explode(',', Yii::$app->request->input('cart_ids'));
            }
        }

        $express_type = Yii::$app->request->input('express_type');
        $region_id = Yii::$app->request->input('region_id');
        $goods_id = Yii::$app->request->input('goods_id');
        $goods_type = Yii::$app->request->input('goods_type');
        $express_id = Yii::$app->request->input('express_id');
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
    public function actionClear(): array
    {
        $user_id = Yii::$app->user->identity->user_id;
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

        $user_id = Yii::$app->user->identity->user_id;
        $data = Yii::$app->request->post();
        $cart_ids = Yii::$app->request->input('cart_ids');

        $list = CartService::deleteCart($user_id, $cart_ids);

        return ResultHelper::json(200, '删除成功', $list);
    }
}
