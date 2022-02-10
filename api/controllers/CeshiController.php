<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 04:06:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-17 21:45:21
 */


namespace api\controllers;

use Yii;
use api\controllers\AController;
use common\helpers\FileHelper;

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
}
