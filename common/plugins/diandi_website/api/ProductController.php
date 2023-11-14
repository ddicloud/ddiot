<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-22 17:21:59
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-28 11:52:39
 */

namespace common\plugins\diandi_website\api;

use api\controllers\AController;
use common\plugins\diandi_website\services\ProductService;

class ProductController extends AController
{
    use \addons\diandi_website\components\ResultTrait;

    protected array $authOptional = ['*'];

    public $modelClass = '';


    public function actionSlide(): array
    {
        return $this->_json(ProductService::getSlide($this->getPageInfo()));
    }


    public function actionVersion(): array
    {
        return $this->_json(ProductService::getVersion($this->getPageInfo()));
    }


    public function actionPlug(): array
    {
        return $this->_json(ProductService::getPlug($this->getPageInfo()));
    }


    public function actionCustomerList(): array
    {
        return $this->_json(ProductService::getCustomer($this->getPageInfo(), $this->_fillWhere(['solution_id', 'is_website'])));
    }
    /**
     * @SWG\Get(path="/diandi_website/product/customer-view",
     *    tags={"产品"},
     *    summary="客户案例详情 - (后台：客户案例)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "客户案例详情 - (后台：客户案例)",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="integer",
     *     description="客户案例 - ID",
     *     required=true,
     *   )
     * )
     */
    public function actionCustomerView($id)
    {
        return $this->_json(ProductService::getCustomerView($id));
    }

    /**
     * @SWG\Get(path="/diandi_website/product/selling-list",
     *    tags={"产品"},
     *    summary="核心卖点列表 - (后台：核心卖点)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "核心卖点列表 - (后台：核心卖点)",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="limit_start",
     *     type="integer",
     *     description="是否开启分页（-1：不开启，1：开启）默认：-1",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="path",
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10) - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1） - 开启分页时有效",
     *     required=false,
     *   ),
     * )
     */
    public function actionSellingList()
    {
        return $this->_json(ProductService::getSelling($this->getPageInfo()));
    }
    /**
     * @SWG\Get(path="/diandi_website/product/selling-view",
     *    tags={"产品"},
     *    summary="核心卖点详情 - (后台：核心卖点)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "核心卖点详情 - (后台：核心卖点)",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="integer",
     *     description="核心卖点 - ID",
     *     required=true,
     *   )
     * )
     */
    public function actionSellingView($id)
    {
        return $this->_json(ProductService::getSellingView($id));
    }

    /**
     * @SWG\Get(path="/diandi_website/product/core-list",
     *    tags={"产品"},
     *    summary="核心功能列表 - (后台：核心功能)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "核心功能列表 - (后台：核心功能)",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="limit_start",
     *     type="integer",
     *     description="是否开启分页（-1：不开启，1：开启）默认：-1",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="path",
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10) - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1） - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="solution_id",
     *     type="integer",
     *     description="解决方案ID",
     *     required=true,
     *   ),
     * )
     */
    public function actionCoreList()
    {
        return $this->_json(ProductService::getCore($this->getPageInfo(), $this->_fillWhere(['solution_id'])));
    }
    /**
     * @SWG\Get(path="/diandi_website/product/core-view",
     *    tags={"产品"},
     *    summary="核心功能详情 - (后台：核心功能)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "核心功能详情 - (后台：核心功能)",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="integer",
     *     description="核心功能 - ID",
     *     required=true,
     *   )
     * )
     */
    public function actionCoreView($id)
    {
        return $this->_json(ProductService::getCoreView($id));
    }

    /**
     * @SWG\Get(path="/diandi_website/product/App-list",
     *    tags={"产品"},
     *    summary="应用中心列表 - (后台：应用中心)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "应用中心列表 - (后台：应用中心)",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),  
     *    @SWG\Parameter(
     *     in="path",
     *     name="limit_start",
     *     type="integer",
     *     description="是否开启分页（-1：不开启，1：开启）默认：-1",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="path",
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10) - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1） - 开启分页时有效",
     *     required=false,
     *   ),
     * )
     */
    public function actionAppList()
    {
        return $this->_json(ProductService::getApp($this->getPageInfo()));
    }
    /**
     * @SWG\Get(path="/diandi_website/product/App-view",
     *    tags={"产品"},
     *    summary="应用中心详情 - (后台：应用中心)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "应用中心详情 - (后台：应用中心)",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="integer",
     *     description="应用中心 - ID",
     *     required=true,
     *   ),
     * )
     */
    public function actionAppView($id)
    {
        return $this->_json(ProductService::getAppView($id));
    }

    /**
     * @SWG\Get(path="/diandi_website/product/config",
     *    tags={"产品"},
     *    summary="产品全局配置 - (后台：全局配置)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "产品全局配置 - (后台：全局配置)",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     * )
     */
    public function actionConfig()
    {
        return $this->_json(ProductService::getConfig());
    }

    /**
     * @SWG\Get(path="/diandi_website/product/price",
     *    tags={"产品"},
     *    summary="产品价格 - 202206",
     *     @SWG\Response(
     *         response = 200,
     *         description = "产品价格 - 202206",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="solution_id",
     *     type="integer",
     *     description="解决方案ID",
     *     required=true,
     *   ),
     * )
     */
    public function actionPrice()
    {
        return $this->_json(ProductService::getPrice($this->getPageInfo(), $this->_fillWhere(['solution_id'])));
    }
}
