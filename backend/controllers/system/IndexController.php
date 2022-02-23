<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-11 17:41:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-05-05 20:14:14
 */


namespace backend\controllers\system;

use Yii;
use  backend\controllers\BaseController;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\forms\LoginForm;
use yii\web\Response;

/**
 *
 */
class IndexController extends BaseController
{
    public $enableCsrfValidation = false;
    // public $layout = false;

    public function actionIndex()
    {
        $csrfToken = Yii::$app->request->csrfToken;
        return $this->render('index', ['csrfToken' => $csrfToken]);
    }




    /**
     * @return string
     */
    public function actionChildcate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $pid = Yii::$app->request->post('parent_id');
            $cates = DdRegion::findAll(['pid' => $pid]);
            return $cates;
        }
    }

    public function actionInfo()
    {
        global $_GPC;
        // 初始化菜单
        $is_addons = Yii::$app->params['is_addons'];

        $AllNav   = Yii::$app->service->backendNavService->getMenu('', $is_addons);
        
        $moduleAll =  Yii::$app->params['moduleAll'];
        
        $Website   = Yii::$app->settings->getAllBySection('Website');
        $Website['blogo']   = ImageHelper::tomedia($Website['blogo']);
        $Website['flogo']   = ImageHelper::tomedia($Website['flogo']);

        $Website['themcolor']   = !empty(Yii::$app->cache->get('themcolor'))?Yii::$app->cache->get('themcolor'):$Website['themcolor'];
        
        

        return ResultHelper::json(200,'获取成功',[
                'AllNav'=>$AllNav,
                'is_addons'=>$is_addons,
                'moduleAll'=>$moduleAll,
                'Website'=>$Website
            ]);
        
    }

}
