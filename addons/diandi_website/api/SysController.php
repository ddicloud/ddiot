<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-29 09:18:36
 */

namespace addons\diandi_website\api;

use addons\diandi_website\services\SysService;
use api\controllers\AController;
use common\helpers\ResultHelper;

class SysController extends AController
{
    use \addons\diandi_website\components\ResultTrait;

    protected array $authOptional = ['*'];

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_website/sys/base",
     *    tags={"官网全局"},
     *    summary="基础信息",
     *     @SWG\Response(
     *         response = 200,
     *         description = "基础信息",
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
     *   )
     * )
     */
    public function actionBase()
    {
        $detail = SysService::getBase();

        return ResultHelper::json(200, '请求成功', $detail);
    }

    /**
     * @SWG\Get(path="/diandi_website/sys/nav",
     *    tags={"官网全局"},
     *    summary="导航",
     *     @SWG\Response(
     *         response = 200,
     *         description = "导航",
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
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="导航类型（1顶部，2导航，3/4/5/6为底部区域）",
     *     required=true,
     *   )
     * )
     */
    public function actionNav()
    {
        global $_GPC;
        $type = $_GPC['type']; // NavTypeStatus::NAV;
        $menu = SysService::getNave($type);

        return ResultHelper::json(200, '获取成功', $menu);
    }

    /**
     * @SWG\Get(path="/diandi_website/sys/slide",
     *    tags={"官网全局"},
     *    summary="幻灯片",
     *     @SWG\Response(
     *         response = 200,
     *         description = "幻灯片",
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
     *     @SWG\Parameter(
     *     in="query",
     *     name="page_id",
     *     type="integer",
     *     description="页面配置id",
     *     required=true,
     *   ),
     * )
     */
    public function actionSlide()
    {
        global $_GPC;
        $page_id = $_GPC['page_id'];
        $list = SysService::getSlide($page_id);

        return ResultHelper::json(200, '请求成功', $list);
    }

    /**
     * @SWG\Get(path="/diandi_website/sys/page",
     *    tags={"页面"},
     *    summary="单页面",
     *     @SWG\Response(
     *         response = 200,
     *         description = "页面",
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
     *     in="formData",
     *     name="template",
     *     type="integer",
     *     description="页面模板",
     *     required=true,
     *   )
     * )
     */
    public function actionPage()
    {
        global $_GPC;
        $template = $_GPC['template'];
        $page = SysService::getPage($template);

        return ResultHelper::json(200, '请求成功', $page);
    }

    /**
     * @SWG\Get(path="/diandi_website/sys/link",
     *    tags={"友情链接"},
     *    summary="友情链接",
     *     @SWG\Response(
     *         response = 200,
     *         description = "友情链接",
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
     *   )
     * )
     */
    public function actionLink()
    {
        global $_GPC;
        $link = SysService::getLink();

        return ResultHelper::json(200, '请求成功', $link);
    }

    /**
     * @SWG\Get(path="/diandi_website/sys/ad",
     *    tags={"官网全局"},
     *    summary="广告",
     *     @SWG\Response(
     *         response = 200,
     *         description = "广告",
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
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10)",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="type",
     *     type="integer",
     *     description="广告类型（101：轮播图， 102：友情链接）",
     *     required=false,
     *   )
     * )
     */
    public function actionAd()
    {
        return ResultHelper::json(200, '请求成功', SysService::getAdList($_GPC["category_id"] ?? 0, $_GPC["type"] ?? 0));
    }

    /**
     * @SWG\Get(path="/diandi_website/sys/fun",
     *    tags={"系统功能 - 202206"},
     *    summary="系统功能",
     *     @SWG\Response(
     *         response = 200,
     *         description = "系统功能",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="path",
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10)",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="is_website",
     *     type="integer",
     *     description="是否是官网（-1：否，1：是）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="solution_id",
     *     type="integer",
     *     description="解决方案ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="fun_limit",
     *     type="integer",
     *     description="系统功能下分类数量限制(默认10)",
     *     required=false,
     *   ),
     * )
     */
    public function actionFun()
    {
        global $_GPC;
        if (isset($_GPC['fun_limit']) && $_GPC['fun_limit'] > 0) {
            \addons\diandi_website\models\searchs\SysFunCateSearch::$funLimit = (int)$_GPC['fun_limit'];
        }
        $where = $this->_fillWhere(['solution_id', 'is_website']);

        return $this->_json(SysService::getFun($this->getPageInfo(), $where));
    }

    /**
     * @SWG\Get(path="/diandi_website/sys/worth",
     *    tags={"系统功能 - 202206"},
     *    summary="系统价值",
     *     @SWG\Response(
     *         response = 200,
     *         description = "系统价值",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="path",
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10)",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="is_website",
     *     type="integer",
     *     description="是否是官网（-1：否，1：是）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="solution_id",
     *     type="integer",
     *     description="解决方案ID",
     *     required=true,
     *   ),
     * )
     */
    public function actionWorth()
    {
        $where = $this->_fillWhere(['solution_id', 'is_website']);
        return $this->_json(SysService::getWorth($this->getPageInfo(), $where));
    }
}
