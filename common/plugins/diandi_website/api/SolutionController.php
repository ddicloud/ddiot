<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-22 17:21:59
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-12 11:41:30
 */

namespace addons\diandi_website\api;

use api\controllers\AController;
use addons\diandi_website\services\SolutionService;

class SolutionController extends AController
{
    use \addons\diandi_website\components\ResultTrait;

    protected array $authOptional = ['*'];

    public $modelClass = '';

    /**
     * @SWG\Post(path="/diandi_website/solution/cate-list",
     *    tags={"解决方案相关 - 202206"},
     *    summary="解决方案分类",
     *     @SWG\Response(
     *         response = 200,
     *         description = "解决方案分类",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="limit_start",
     *     type="integer",
     *     description="是否开启分页（-1：不开启，1：开启）默认：-1",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="path",
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10) - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1） - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="solution_limit",
     *     type="integer",
     *     description="解决方案数量限制(默认10)",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="name",
     *     type="integer",
     *     description="解决方案名称||内容模糊查询",
     *     required=false,
     *   ),
     * )
     */
    public function actionCateList()
    {
        global $_GPC;
        // if (isset(Yii::$app->request->input('solution_limit')) && Yii::$app->request->input('solution_limit') > 0) {
        //     \addons\diandi_website\models\searchs\SolutionCateSearch::$solutionLimit = (int)Yii::$app->request->input('solution_limit');
        // }
        return $this->_json(SolutionService::getCate($this->getPageInfo(), Yii::$app->request->input('solution_limit') ?? 10, Yii::$app->request->input('name') ?? ''));
    }

    /**
     * @SWG\Post(path="/diandi_website/solution/list",
     *    tags={"解决方案相关 - 202206"},
     *    summary="解决方案",
     *     @SWG\Response(
     *         response = 200,
     *         description = "解决方案",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="limit_start",
     *     type="integer",
     *     description="是否开启分页（-1：不开启，1：开启）默认：-1",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="path",
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10) - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1） - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="cate_id",
     *     type="integer",
     *     description="解决方案分类ID",
     *     required=true,
     *   ),
     * )
     */
    public function actionList()
    {
        global $_GPC;
        $where = $this->_fillWhere(['cate_id']);
        return $this->_json(SolutionService::getList($this->getPageInfo(), $where, Yii::$app->request->input('name') ?? ''));
    }
    /**
     * @SWG\Get(path="/diandi_website/solution/bac-exhibit",
     *    tags={"解决方案相关 - 202206"},
     *    summary="后台展示",
     *     @SWG\Response(
     *         response = 200,
     *         description = "后台展示",
     *     ),
     *     @SWG\Parameter(
     *     in="header",
     *     name="bloc-id",
     *     type="integer",
     *     description="公司ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="header",
     *     name="store-id",
     *     type="integer",
     *     description="商户ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="limit_start",
     *     type="integer",
     *     description="是否开启分页（-1：不开启，1：开启）默认：-1",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="path",
     *     name="pageSize",
     *     type="integer",
     *     description="每页数据量(默认10) - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="page",
     *     type="integer",
     *     description="页码（默认1） - 开启分页时有效",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="path",
     *     name="solution_id",
     *     type="integer",
     *     description="解决方案ID",
     *     required=true,
     *   ),
     * )
     */
    public function actionBacExhibit()
    {
        $where = $this->_fillWhere(['solution_id']);
        return $this->_json(SolutionService::getBacExhibit($this->getPageInfo(), $where));
    }
}
