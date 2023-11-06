<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 16:08:37
 */

namespace common\plugins\diandi_website\api;

use addons\diandi_website\models\enums\NavTypeStatus;
use addons\diandi_website\models\WebsitePageConfig;
use addons\diandi_website\services\ArticleService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class ArticleController extends AController
{
    protected array $authOptional = ['*'];

    public $modelClass = '';


    public function actionCate(): array
    {
        $pcate = Yii::$app->request->input('pcate');
        $type = Yii::$app->request->input('type');
        $detail = ArticleService::getCate($pcate, $type);

        return ResultHelper::json(200, '请求成功', $detail);
    }


    public function actionList(): array
    {
        $type = Yii::$app->request->input('type'); // NavTypeStatus::NAV;
        $pcate = Yii::$app->request->input('pcate');
        $ccate = Yii::$app->request->input('ccate');
        $keywords = Yii::$app->request->input('keywords');
        $ishot = Yii::$app->request->input('ishot');
        $menu = ArticleService::getList($type, $keywords, $pcate, $ccate, $ishot);

        return ResultHelper::json(200, '获取成功', $menu);
    }


    public function actionDetail(): array
    {
        $id = Yii::$app->request->input('id');
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

        $detail = WebsitePageConfig::find()->select(['title', 'id'])->asArray()->all();

        return ResultHelper::json(200, '请求成功', $detail);
    }
}
