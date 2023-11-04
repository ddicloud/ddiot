<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-10 04:14:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-12-28 20:47:07
 */

namespace addons\diandi_integral\api;

use api\controllers\AController;
use addons\diandi_integral\services\GoodsService;
use common\helpers\ResultHelper;
use Yii;
use yii\base\DynamicModel;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;

/**
 * Class GoodsController.
 */
class GoodsController extends AController
{
    public $modelClass = '\common\models\IntegralGoods';
    protected array $authOptional = ['search','lists','getslide'];


    public function actionSearch(): array
   {
        $keytwords = Yii::$app->request->get('keywords');
        $pageSize = Yii::$app->request->get('pageSize');
        $user_id = Yii::$app->user->identity->member_id??0;

        $list = GoodsService::getList(0, 0, $keytwords, $pageSize, $user_id);

        return ResultHelper::json(200, '获取成功', $list);
    }


    public function actionDetail(): array
    {
        $goods_id = Yii::$app->request->get('goods_id');

        $list = GoodsService::getDetail($goods_id);
        
        return ResultHelper::json(200, '获取成功', [
            'goods' => $list,
            'order_type' => 0,
        ]);
    }


    /**
     * @return array
     * @throws ErrorException
     * @throws InvalidConfigException
     */
    public function actionLists(): array
   {

        // 定义需要验证的参数规则
        $rules = [
            [['pageSize', 'goods_price','sales_initial'], 'required'],
            [['goods_price','sales_initial'], 'in', 'range' => ['desc','asc']],
            [['pageSize'], 'integer', 'min' => 0, 'max' => 50],
            [['category_pid','category_id'], 'integer']
        ];

        $this->validateParams($rules);

        $pageSize =\Yii::$app->request->input('pageSize');
        $goods_price =\Yii::$app->request->input('goods_price');
        $sales_initial =\Yii::$app->request->input('sales_initial');

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

        $user_id = Yii::$app->user->identity ? Yii::$app->user->identity->member_id : 0;

        $keytwords =\Yii::$app->request->input('keywords')??'';

        $list = GoodsService::getList(Yii::$app->request->input('category_pid')??0,\Yii::$app->request->input('category_id')??0, $keytwords, $pageSize, $orderby);

        return ResultHelper::json(200, '获取成功', $list);
    }


    /**
     * @SWG\Get(path="/diandi_integral/goods/getslide",
     *     tags={"商品"},
     *     summary="首页幻灯片",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Goods collection response",
     *     ),
     * )
     */
    public function actionGetslide(){Yii::$app->request->input('store_id',0)
        $store_id =\Yii::$app->request->input('store_id',0);
        $bloc_id =\Yii::$app->request->input('bloc_id',0);
        
        $list = GoodsService::getSlides($store_id,$bloc_id);
        
        
        return ResultHelper::json(200, '获取成功', $list);
    }

}
