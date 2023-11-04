<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-22 10:41:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-05-09 09:27:56
 */

namespace addons\diandi_tea\admin\marketing;

use addons\diandi_tea\models\marketing\TeaRecharge;
use addons\diandi_tea\services\StatisticalService;
use admin\controllers\AController;
use common\helpers\ResultHelper;

/**
 * RechargeController implements the CRUD actions for TeaRecharge model.
 */
class StatisticalController extends AController
{
    public string $modelSearchName = 'TeaSetMeal';

    protected array $authOptional = ['index'];

    public $modelClass = '';

    public int $searchLevel = 0;

    /**
     * @SWG\Get(path="/diandi_tea/marketing/statistical/index",
     *    tags={"统计"},
     *    summary="统计列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "列表数据",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionIndex(): array
    {
        $info = StatisticalService::statisticalList();

        return ResultHelper::json(200, '获取成功', $info);
    }
}
