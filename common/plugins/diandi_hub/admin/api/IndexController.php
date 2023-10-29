<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-04 17:15:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:52
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\models\advertising\HubSlide;
use common\plugins\diandi_hub\services\LocationService;
use admin\controllers\AController;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;

// 首页
class IndexController extends AController
{
    public $modelClass = '';

    public int $searchLevel = 0;
    protected array $authOptional = ['*'];

    /**
     * @SWG\Get(path="/diandi_hub/index/slides",
     *    tags={"收货地址"},
     *    summary="收货地址添加",
     *     @SWG\Response(
     *         response = 200,
     *         description = "收货地址添加",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     )
     * )
     */
    public function actionSlides()
    {
        global $_GPC;

        $terminal_type = intval($_GPC['terminal_type']);

        $LotterySlide = new HubSlide();

        $where = [];

        $where['terminal_type'] = $terminal_type;

        $list = $LotterySlide->find()->andFilterWhere($where)->orderBy('displayorder')->asArray()->all();
        foreach ($list as $key => &$value) {
            $value['thumb'] = ImageHelper::tomedia($value['thumb']);
        }

        return ResultHelper::json(200, '请求成功', $list);
    }

    // 推荐位商品
    public function actionGoodsadv()
    {
        global $_GPC;
        $mark = $_GPC['mark'];
        $page = Yii::$app->request->get('page', 1);
        $pageSize = $_GPC['pageSize'];
        $list = LocationService::getGoodsAdv($mark, $page, $pageSize);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionPageadv()
    {
        global $_GPC;
        $pageType = $_GPC['pageType'];
        $locationType = $_GPC['locationType'];
        $list = LocationService::getAd($pageType, $locationType);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionMenu()
    {
        global $_GPC;
        $list = LocationService::getMenu();

        return ResultHelper::json(200, '获取成功', $list);
    }
}
