<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:17:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-10 13:37:16
 */

namespace admin\controllers;

use admin\services\StoreService;
use common\helpers\CacheHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\LevelTplHelper;
use common\helpers\ResultHelper;
use common\models\UserBloc;
use diandi\addons\models\Bloc;
use diandi\addons\models\BlocStore;
use diandi\addons\models\searchs\BlocStoreSearch;
use diandi\addons\models\StoreCategory;
use diandi\addons\models\StoreLabel;
use diandi\addons\models\StoreLabelLink;
use diandi\admin\models\AuthAssignmentGroup;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class EnumsController extends AController
{
    public $modelClass = '';
    protected $authOptional = ['*'];

    public $bloc_id;

    public $extras = [];

    public $searchLevel = 0;

    /**
     * 获取用户授权的商户和公司数据-级联数据
     * @return void
     * @date 2023-03-04
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function actionStoresbloc()
    {
        $list = StoreService::getStoresAndBloc();
        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionBlocs()
    {
        $list = StoreService::getAuthBlos();
        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionStores()
    {
        $list = StoreService::getAuthStores();
        return ResultHelper::json(200, '获取成功', $list);
    }
}
