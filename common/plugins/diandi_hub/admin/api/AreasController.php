<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-11 18:26:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:22
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\models\searchs\DdShopAreas;
use admin\controllers\AController;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\data\Pagination;

/**
 * Default controller for the `DiandiShop` module.
 */
class AreasController extends AController
{
    public $modelClass = '\common\models\DdGoods';
    protected array $authOptional = ['list'];

    public int $searchLevel = 0;

    /**
     * @SWG\Post(path="/diandi_hub/areas/list",
     *     tags={"商家"},
     *     summary="配送点.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "配送点获取",
     *     ),
     *    @SWG\Parameter(
     *          in="formData",
     *          name="page",
     *          type="integer",
     *          description="分页",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="pageSize",
     *          type="integer",
     *          description="显示条数",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="area_name",
     *          type="string",
     *          description="配送点名称",
     *          required=false,
     *   ),
     * )
     */
    public function actionList(): array
    {
        $data = Yii::$app->request->post();
        // 创建一个 DB 查询来获得所有
        $where = [];
        if ($data['area_name']) {
            $where = ['like', 'area_name', $data['area_name']];
        }

        $where['bloc_id'] = Yii::$app->params['bloc_id'];
        $where['store_id'] = Yii::$app->params['store_id'];

        $query = DdShopAreas::find()->where($where);

        $count = $query->count();
        $pageSize = $data['pageSize'];
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
        ]);
        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        foreach ($list as &$item) {
            $item['logo'] = ImageHelper::tomedia($item['logo']);
        }

        return ResultHelper::json(200, '获取成功', $list);
    }
}
