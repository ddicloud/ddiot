<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 04:06:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-25 11:18:24
 */


namespace ddswoole\controllers;

use Yii;
use common\helpers\ArrayHelper;
use common\helpers\MapHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;

class MapController extends AController
{
    public $modelClass = '';
    protected $authOptional = ['distance', 'citylist'];

   
    public function actionDistance()
    {
        $lng = Yii::$app->request->get('lng');
        $lat = Yii::$app->request->get('lat');
        $data = MapHelper::distance($lng, $lat);
        return ResultHelper::json(200, '获取成功', $data);
    }

  
    public function actionCitylist()
    {

        $region = new DdRegion();
        $regionVal = Yii::$app->cache->get('region');
        if ($regionVal) {
            $citylist   = $regionVal;
        } else {
            $list   =  $region->find()->select(['name', 'id', 'pid'])->asArray()->all();
            foreach ($list as $key => &$value) {
                $value['value'] = $value['id'];
            }
            $citylist = [];
            $citylist = ArrayHelper::itemsMerge($list, $pid = 0, "id", 'pid', 'children');

            Yii::$app->cache->set('region', $citylist);
        }

        return ResultHelper::json(200, '获取成功', $citylist);
    }
}
