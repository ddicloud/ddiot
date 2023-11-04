<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 21:08:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-07-08 21:35:01
 */

namespace addons\diandi_integral\api;

use api\controllers\AController;
use common\helpers\ResultHelper;

class IndexController extends AController
{
    public $modelClass = '\common\models\IntegralGoods';



    public function actionBase(): array
   {

        // 热搜词
        // 幻灯片
        // 分类
        // 新人专享
        // 新品推荐
        // 热门推荐

        return ResultHelper::json(200, '获取成功');
    }


    public function actionPage(): array
    {
        return ResultHelper::json(200, '获取成功');
    }
}
