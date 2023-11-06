<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-22 17:21:59
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-23 16:26:32
 */

namespace common\plugins\diandi_website\api;

use api\controllers\AController;
use common\plugins\diandi_website\models\WebsiteProH5Body;
use common\plugins\diandi_website\services\ProductHService;

class ProductHController extends AController
{
    use \addons\diandi_website\components\ResultTrait;

    protected array $authOptional = ['*'];

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_website/product-h/body-list",
     *    tags={"产品"},
     *    summary="H5页面展示列表 - (后台：产品营销)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "H5页面展示列表",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="limit_start",
     *     type="integer",
     *     description="是否开启分页（-1：不开启，1：开启）默认：-1",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="path",
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10) - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1） - 开启分页时有效",
     *     required=false,
     *   ),
     * )
     */
    public function actionH5BodyList()
    {
        return $this->_json(ProductHService::getH5BodyList($this->getPageInfo()));
    }
    /**
     * @SWG\Get(path="/diandi_website/product-h/body-view",
     *    tags={"产品"},
     *    summary="H5页面展示详情 - (后台：产品营销)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "H5页面展示详情",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="integer",
     *     description="H5页面展示 - ID",
     *     required=true,
     *   )
     * )
     */
    public function actionH5BodyView($id)
    {
        return $this->_json(ProductHService::getH5BodyView($id));
    }

    /**
     * @SWG\Get(path="/diandi_website/product-h/top-list",
     *    tags={"产品"},
     *    summary="H5前端界面展示列表 - (后台：产品介绍)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "H5前端界面展示列表 - (后台：产品介绍)",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="limit_start",
     *     type="integer",
     *     description="是否开启分页（-1：不开启，1：开启）默认：-1",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="path",
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10) - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1） - 开启分页时有效",
     *     required=false,
     *   ),
     * )
     */
    public function actionH5TopList()
    {
        return $this->_json(ProductHService::getH5TopList($this->getPageInfo()));
    }
    /**
     * @SWG\Get(path="/diandi_website/product-h/top-view",
     *    tags={"产品"},
     *    summary="H5前端界面展示详情 - (后台：产品介绍)",
     *     @SWG\Response(
     *         response = 200,
     *         description = "H5前端界面展示详情 - (后台：产品介绍)",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="integer",
     *     description="H5前端界面展示 - ID",
     *     required=true,
     *   )
     * )
     */
    public function actionH5TopView($id)
    {
        return $this->_json(ProductHService::getH5TopView($id));
    }
}
