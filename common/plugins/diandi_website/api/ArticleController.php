<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 16:08:37
 */

namespace addons\diandi_website\api;

use addons\diandi_website\models\enums\NavTypeStatus;
use addons\diandi_website\models\WebsitePageConfig;
use addons\diandi_website\services\ArticleService;
use api\controllers\AController;
use common\helpers\ResultHelper;

class ArticleController extends AController
{
    protected array $authOptional = ['*'];

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_website/article/cate",
     *    tags={"文章资讯"},
     *    summary="文章分类",
     *     @SWG\Response(
     *         response = 200,
     *         description = "文章分类",
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
     *     name="pcate",
     *     type="integer",
     *     description="父级分类ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="string",
     *     description="英文标识",
     *     required=true,
     *   )
     * )
     */
    public function actionCate()
    {
        global $_GPC;
        $pcate =\Yii::$app->request->input('pcate');
        $type =\Yii::$app->request->input('type');
        $detail = ArticleService::getCate($pcate, $type);

        return ResultHelper::json(200, '请求成功', $detail);
    }

    /**
     * @SWG\Get(path="/diandi_website/article/list",
     *    tags={"文章资讯"},
     *    summary="文章列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "文章列表",
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
     *     name="keywords",
     *     type="string",
     *     description="关键词",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="string",
     *     description="英文标识",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="ishot",
     *     type="integer",
     *     description="是否热门",
     *     required=true,
     *   )
     * )
     */
    public function actionList()
    {
        global $_GPC;
        $type =\Yii::$app->request->input('type'); // NavTypeStatus::NAV;
        $pcate =\Yii::$app->request->input('pcate');
        $ccate =\Yii::$app->request->input('ccate');
        $keywords =\Yii::$app->request->input('keywords');
        $ishot =\Yii::$app->request->input('ishot');
        $menu = ArticleService::getList($type, $keywords, $pcate, $ccate, $ishot);

        return ResultHelper::json(200, '获取成功', $menu);
    }

    /**
     * @SWG\Get(path="/diandi_website/article/detail",
     *    tags={"文章资讯"},
     *    summary="资讯详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "资讯详情",
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
     *     name="id",
     *     type="integer",
     *     description="文章id",
     *     required=true,
     *   )
     * )
     */
    public function actionDetail()
    {
        global $_GPC;
        $id =\Yii::$app->request->input('id');
        $detail = ArticleService::getDetail($id);

        return ResultHelper::json(200, '请求成功', $detail);
    }

    /**
     * @SWG\Get(path="/diandi_website/article/pagelist",
     *    tags={"页面"},
     *    summary="页面配置列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "资讯详情",
     *     ),
     * )
     */
    public function actionPageList()
    {
        global $_GPC;

        $detail = WebsitePageConfig::find()->select(['title', 'id'])->asArray()->all();

        return ResultHelper::json(200, '请求成功', $detail);
    }
}
