<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-22 17:21:59
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-12 11:41:30
 */

namespace common\plugins\diandi_website\api;

use api\controllers\AController;
use common\plugins\diandi_website\services\SolutionService;

class SolutionController extends AController
{
    use \addons\diandi_website\components\ResultTrait;

    protected array $authOptional = ['*'];

    public $modelClass = '';


    public function actionCateList(): array
    {
        // if (isset(Yii::$app->request->input('solution_limit')) &&\Yii::$app->request->input('solution_limit') > 0) {
        //     \addons\diandi_website\models\searchs\SolutionCateSearch::$solutionLimit = (int)Yii::$app->request->input('solution_limit');
        // }
        return $this->_json(SolutionService::getCate($this->getPageInfo(),\Yii::$app->request->input('solution_limit') ?? 10,\Yii::$app->request->input('name') ?? ''));
    }


    public function actionList(): array
    {
        $where = $this->_fillWhere(['cate_id']);
        return $this->_json(SolutionService::getList($this->getPageInfo(), $where,\Yii::$app->request->input('name') ?? ''));
    }


    public function actionBacExhibit(): array
    {
        $where = $this->_fillWhere(['solution_id']);
        return $this->_json(SolutionService::getBacExhibit($this->getPageInfo(), $where));
    }
}
