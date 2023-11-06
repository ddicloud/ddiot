<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-29 09:18:36
 */

namespace addons\diandi_website\api;

use addons\diandi_website\services\SysService;
use api\controllers\AController;
use common\helpers\ResultHelper;

class SysController extends AController
{
    use \addons\diandi_website\components\ResultTrait;

    protected array $authOptional = ['*'];

    public $modelClass = '';


    public function actionBase(): array
    {
        $detail = SysService::getBase();

        return ResultHelper::json(200, '请求成功', $detail);
    }


    public function actionNav(): array
    {
        $type =\Yii::$app->request->input('type'); // NavTypeStatus::NAV;
        $menu = SysService::getNave($type);

        return ResultHelper::json(200, '获取成功', $menu);
    }


    public function actionSlide(): array
    {
        $page_id =\Yii::$app->request->input('page_id');
        $list = SysService::getSlide($page_id);

        return ResultHelper::json(200, '请求成功', $list);
    }


    public function actionPage(): array
    {
        $template =\Yii::$app->request->input('template');
        $page = SysService::getPage($template);

        return ResultHelper::json(200, '请求成功', $page);
    }


    public function actionLink()
   {
        $link = SysService::getLink();

        return ResultHelper::json(200, '请求成功', $link);
    }


    public function actionAd(): array
    {
        return ResultHelper::json(200, '请求成功', SysService::getAdList(Yii::$app->request->input('category_id') ?? 0,\Yii::$app->request->input('type') ?? 0));
    }


    public function actionFun(): array
    {
        if (Yii::$app->request->input('fun_limit') !== null &&\Yii::$app->request->input('fun_limit') > 0) {
            \addons\diandi_website\models\searchs\SysFunCateSearch::$funLimit = (int)Yii::$app->request->input('fun_limit');
        }
        $where = $this->_fillWhere(['solution_id', 'is_website']);

        return $this->_json(SysService::getFun($this->getPageInfo(), $where));
    }


    public function actionWorth(): array
    {
        $where = $this->_fillWhere(['solution_id', 'is_website']);
        return $this->_json(SysService::getWorth($this->getPageInfo(), $where));
    }
}
