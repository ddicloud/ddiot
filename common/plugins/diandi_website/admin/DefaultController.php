<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-23 15:05:26
 */


namespace common\plugins\diandi_website\admin;


use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\services\common\AddonsService;

/**
 * Default controller for the `diandi_website` module
 */
class DefaultController extends AController
{
    public string $modelSearchName = "WebsiteContentDetailSearch";

    public $modelClass = '';

    /**
     * Renders the index view for the module
     * @return array
     */
    public function actionIndex(): array
    {

        $info = AddonsService::getAddonsInfo("diandi_website");

        return ResultHelper::json(200, '获取成功', [
            'info' => $info
        ]);
    }
}
