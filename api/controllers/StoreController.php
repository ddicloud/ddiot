<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-19 18:05:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 13:16:16
 */


namespace api\controllers;

use Yii;
use api\controllers\AController;
use yii\filters\VerbFilter;
use common\components\Upload;
use common\helpers\ArrayHelper;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use diandi\admin\models\BlocStore;
use diandi\admin\models\searchs\StoreCategory;
use yii\helpers\Json;
use yii\rest\ActiveController;


class StoreController extends AController
{
    public $modelClass = '';
    protected $authOptional = ['*'];
    
    public function actionInfo()
    {
        global $_GPC;
        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        
        if(!$store){
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
            
        }
        
        return ResultHelper::json(200, '获取成功', $store);

    }

      
    public function actionDetailinfo()
    {
        global $_GPC;
        $store_id = $_GPC['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        
        if(!$store){
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
            
        }
        
        return ResultHelper::json(200, '获取成功', $store);

    }

    public function actionCate()
    {
        global $_GPC;
        $parent_id = $_GPC['parent_id'];
       
        $list = Yii::$app->service->commonStoreService->getCate($parent_id);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionList()
    {
        global $_GPC;
        $logPath = Yii::getAlias('@runtime/StoreService/list/'.date('Y/md').'.log');

        $category_pid = $_GPC['category_pid'];
        $category_id = $_GPC['category_id'];
        $keywords = $_GPC['keywords'];
        $longitude = $_GPC['longitude'];
        $latitude  = $_GPC['latitude'];
        $label_id  = intval($_GPC['label_id']);
        
        $page  = $_GPC['page'];
        $pageSize  = $_GPC['pageSize'];

        FileHelper::writeLog($logPath, '经纬度计算距离参数' .json_encode([
            'longitude'=>$longitude,
            'latitude'=>$latitude,
            '_GPC'=>$_GPC,
            'member_id' => Yii::$app->user->identity->member_id
        ]));
        
        $list = Yii::$app->service->commonStoreService->list($category_pid,$category_id,$longitude,$latitude,$keywords,$label_id,$page,$pageSize);

        return ResultHelper::json(200, '获取成功', $list);
        
    }
    
}