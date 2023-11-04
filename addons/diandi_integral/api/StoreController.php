<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-09 23:19:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-06-26 23:01:11
 */

namespace addons\diandi_integral\api;

use Yii;
use api\controllers\AController;
use common\helpers\ImageHelper;
use common\helpers\MapHelper;
use common\helpers\ResultHelper;

class StoreController extends AController
{
    public $modelClass = '\common\models\IntegralGoods';

    protected array $authOptional = ['info'];


    public function actionInfo(): array
    {
        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        
        if(!$store){
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
            
        }

        if ($store['surroundings']) {
             $store['surroundings'] = ImageHelper::tomedia($store['surroundings']);
            $store['surroundings'] = array_chunk($store['surroundings'], 2);
        }
        if ($store['certificate']) {
            $store['certificate'] = ImageHelper::tomedia($store['certificate']);
            $store['certificate'] = array_chunk($store['certificate'], 2);
        }
        $store['banner'] = ImageHelper::tomedia($store['banner']);
        $store['shareimg'] = ImageHelper::tomedia($store['shareimg']);
        $store['hotSearch'] = explode(',', $store['hotSearch']);
        $info['wxappName'] = Yii::$app->settings->get('Wxapp', 'name');
        
        return ResultHelper::json(200, '获取成功', $store);
        
     }


    public function actionDistance(): array
    {
        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        
        if(!$store){
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
            
        }
        
        $lng1 = Yii::$app->request->get('lng');
        $lat1 = Yii::$app->request->get('lat');
        $lng_lat = json_decode($store['lng_lat'],true);
        $distance = $store['distance'];
        
        $lng2 = $lng_lat['lng'];
        $lat2 = $lng_lat['lat'];

        $data = MapHelper::getdistance($lng1, $lat1, $lng2, $lat2);

        $is_distance = $data / 1000 > $distance && $distance>0 ? 1 : 0;

        return ResultHelper::json(200, '获取成功', [
            'distance' => $data/1000,
            'is_distance' => $is_distance,
            'juli' => $distance
        ]);
    }
}
