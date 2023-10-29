<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-22 01:15:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:46
 */

namespace common\plugins\diandi_hub\admin\api;

use admin\controllers\AController;

/**
 * Class HelpController.
 */
class HelpController extends AController
{
    public $modelClass = '\common\models\DdGoods';
    protected array $authOptional = ['detail', 'lists'];

    public int $searchLevel = 0;

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

    /**
     * @SWG\Post(path="/diandi_hub/help/detail",
     *     tags={"帮助中心"},
     *     summary="Retrieves the collection of Goods resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Goods collection response",
     *     ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="reason && ninini",
     *     type="string",
     *     description="需要的字段",
     *     required=true,
     *   ),
     * )
     */
    public function actionDetail()
    {
        return 43;
    }

    /**
     * @SWG\Get(path="/diandi_hub/help/lists",
     *     tags={"帮助中心"},
     *     summary="Retrieves the collection of Goods resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Goods collection response",
     *     ),
     *     @SWG\Parameter(
     *     in="query",
     *     name="reason && ninini",
     *     type="string",
     *     description="需要的字段",
     *     required=true,
     *   ),
     * )
     */
    public function actionLists()
    {
        return [];
    }
}
