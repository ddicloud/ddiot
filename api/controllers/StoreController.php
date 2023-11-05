<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-19 18:05:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 13:16:16
 */


namespace api\controllers;

use Yii;
use common\helpers\FileHelper;
use common\helpers\ResultHelper;



class StoreController extends AController
{
    public $modelClass = '';
    protected array $authOptional = ['*'];
    
    public function actionInfo(): array
    {
        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        
        if(!$store){
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
            
        }
        
        return ResultHelper::json(200, '获取成功', $store);

    }

      
    public function actionDetailinfo(): array
   {
        $store_id =\Yii::$app->request->input('store_id',0);
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        
        if(!$store){
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
            
        }
        
        return ResultHelper::json(200, '获取成功', $store);

    }

    public function actionCate(): array
   {
        $parent_id =\Yii::$app->request->input('parent_id');
       
        $list = Yii::$app->service->commonStoreService->getCate($parent_id);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionList(): array
   {
        $logPath = Yii::getAlias('@runtime/StoreService/list/'.date('Y/md').'.log');

        $category_pid =\Yii::$app->request->input('category_pid');
        $category_id =\Yii::$app->request->input('category_id');
        $keywords =\Yii::$app->request->input('keywords');
        $longitude =\Yii::$app->request->input('longitude');
        $latitude  =\Yii::$app->request->input('latitude');
        $label_id  = intval(Yii::$app->request->input('label_id'));
        
        $page  =\Yii::$app->request->input('page');
        $pageSize  =\Yii::$app->request->input('pageSize');

        FileHelper::writeLog($logPath, '经纬度计算距离参数' .json_encode([
            'longitude'=>$longitude,
            'latitude'=>$latitude,
            'member_id' => Yii::$app->user->identity->member_id??0
        ]));
        
        $list = Yii::$app->service->commonStoreService->list($category_pid,$category_id,$longitude,$latitude,$keywords,$label_id,$page,$pageSize);

        return ResultHelper::json(200, '获取成功', $list);
        
    }
    
}