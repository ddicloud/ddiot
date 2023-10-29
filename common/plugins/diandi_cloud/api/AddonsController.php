<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-16 01:39:33
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-15 14:23:32
 */

namespace common\plugins\diandi_cloud\api;

use common\plugins\diandi_cloud\services\AddonsService;
use api\controllers\AController;
use common\helpers\ResultHelper;

class AddonsController extends AController
{
    use \addons\diandi_cloud\components\ResultTrait;

    public $modelClass = '';

    protected array $authOptional = ['lists', 'detail'];

    /**
     * @SWG\Get(
     *    path="/diandi_cloud/addons/detail/{id}",
     *    tags={"应用"},
     *    summary="应用详情",
     *    @SWG\Response(response = 200, description = "应用详情"),
     * )
     */
    public function actionDetail($id)
    {
        return $this->_json(AddonsService::getDetail($id));
    }

    /**
     * @SWG\Get(
     *    path="/diandi_cloud/addons/lists",
     *    tags={"应用"},
     *    summary="应用列表",
     *    @SWG\Response(response = 200, description = "应用列表"),
     *    @SWG\Parameter(in="path", name="cate_id",type="integer", description="分类ID", required=false),
     *    @SWG\Parameter(in="path", name="limit_state", type="integer", description="是否开启分页（-1：不开启，1：开启）默认：-1", required=false),
     *    @SWG\Parameter(in="path", name="pageSize", type="integer", description="每页数据量(默认10) - 开启分页时有效", required=false),
     *    @SWG\Parameter(in="path", name="page", type="integer", description="页码（默认1） - 开启分页时有效", required=false),
     * )
     */
    public function actionLists()
    {
        return $this->_json(AddonsService::getLists($this->_getPageInfo(), $this->_fillWhere(['cate_id'])));
    }

    public function actionAuthList()
    {
        global $_GPC;
        // 当前系统已经安装的应用
        $addons = $_GPC['addons'];
        // 当前系统域名
        $url = $_GPC['url'];
        // 查找该域名下的授权信息
        $addons = [
            [
                'identifie' => 'diandi_im',
                'title' => '店滴客服',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_ai',
                'title' => '店滴AI',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_integral',
                'title' => '积分商城',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_distribution',
                'title' => '店滴分销',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_task',
                'title' => '任务调度',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_example',
                'title' => '开发文档',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_tuan',
                'title' => '店滴拼团',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_shop',
                'title' => '店滴点单',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_outbound',
                'title' => '外呼系统',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_slyder',
                'title' => '大转盘',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_website',
                'title' => '内容cms',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_pro',
                'title' => '产品库维护',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'weihai_bigscreen',
                'title' => '疫情城市防控',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_honorary',
                'title' => '晓多荣誉墙',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_party',
                'title' => '企业党建',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_tea',
                'title' => '智能茶室',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_project',
                'title' => '工程管理',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_farm',
                'title' => '农业牧养',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_flower',
                'title' => '花卉市场',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_doorlock',
                'title' => '智能门锁',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_switch',
                'title' => '智能开关',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_cloud',
                'title' => '店滴云',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_room',
                'title' => '房间',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_wristband',
                'title' => '智能手环',
                'version' => '1.0.0',
            ],
            [
                'identifie' => 'diandi_hub',
                'title' => '应用中心',
                'version' => '1.0.0',
            ],
        ];

        return ResultHelper::json(200, '请求成功', $addons);
    }
}
