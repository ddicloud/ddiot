<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 04:06:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-10 22:41:57
 */

namespace api\controllers;

use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use diandi\admin\acmodels\AuthItem;
use diandi\admin\acmodels\AuthRoute;
use Yii;

class CeshiController extends AController
{
    public $modelClass = '';
    protected $authOptional = ['swgdoc'];

    /**
     * @SWG\Get(path="/ceshi/swgdoc",
     *     tags={"swg文档"},
     *     summary="swg文档",
     *     @SWG\Response(
     *         response = 200,
     *         description = "swg文档"
     *     ),
     *     @SWG\Schema(
     *         @SWG\Property(
     *              property="firstName",
     *              type="string"
     *         ),
     *         @SWG\Property(
     *              property="lastName",
     *              type="string"
     *         ),
     *         @SWG\Property(
     *              property="username",
     *              type="string"
     *         )
     *     ),
     *     @SWG\Parameter(
     *      in="formData",
     *      name="username",
     *      type="string",
     *      description="用户名",
     *      required=true,
     *    ),
     * @SWG\Parameter(
     *     name="pageSize",
     *     in="query",
     *     description="Number of persons returned",
     *     type="integer"
     * ),
     * @SWG\Parameter(
     *     name="pageNumber",
     *     in="query",
     *     description="Page number",
     *     type="integer"
     * )
     * )
     */
    public function actionSwgdoc()
    {
        $logPath = Yii::getAlias('@runtime/ceshi'.date('Y/md').'.log');
        FileHelper::writeLog($logPath, '接口测试');
    }

    /**
     * @SWG\Get(path="/ceshi/xiufu",
     *     tags={"swg文档"},
     *     summary="数据修复",
     *     @SWG\Response(
     *         response = 200,
     *         description = "swg文档"
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="type",
     *     type="string",
     *     description="页面标识",
     *     required=true,
     *   ),
     * )
     */
    public function actionXiufu()
    {
        global $_GPC;
        if ($_GPC['type'] == 1) {
            $AuthRoute = new AuthRoute();
            $list = AuthRoute::find()->alias('a')->leftJoin(AuthItem::tableName().' as c',
                'a.route_name=c.name'
            )->select(['a.id', 'c.id as item_id'])->asArray()->all();

            foreach ($list as $key => $value) {
                $_AuthRoute = clone $AuthRoute;
                $_AuthRoute->updateAll([
                    'item_id' => $value['item_id'],
                ], [
                    'id' => $value['id'],
                ]);
            }
        } else {
            $authItem = new AuthItem();

            $AuthRoute = AuthRoute::find()->asArray()->all();

            foreach ($AuthRoute as $key => $value) {
                $_authItem = clone $authItem;
                $_authItem->setAttributes([
                    'name' => $value['route_name'],
                    'is_sys' => $value['is_sys'],
                    'permission_type' => 0,
                    'description' => $value['description'],
                    'parent_id' => 0,
                    'permission_level' => $value['route_type'],
                    'data' => $value['data'],
                    'module_name' => $value['module_name'],
                ]);
                $_authItem->save();
                $msg = ErrorsHelper::getModelError($_authItem);
                if (!empty($msg)) {
                    echo '<pre>';
                    print_r($msg);
                    echo '</pre>';
                }
            }
        }
    }
}
