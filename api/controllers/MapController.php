<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 04:06:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-13 09:17:54
 */


namespace api\controllers;

use Yii;
use common\helpers\ArrayHelper;
use common\helpers\MapHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;

class MapController extends AController
{
    public $modelClass = '';
    protected array $authOptional = ['distance', 'citylist'];


    public function actionDistance(): array
    {
        $lng = Yii::$app->request->get('lng');
        $lat = Yii::$app->request->get('lat');
        $data = MapHelper::distance($lng, $lat);
        return ResultHelper::json(200, '获取成功', $data);
    }


    public function actionCitylist(): array
    {

        $region = new DdRegion();
        $regionVal = Yii::$app->cache->get('region');
        if ($regionVal) {
            $citylist   = $regionVal;
        } else {
            $list   =  $region->find()->select(['name', 'id', 'pid'])->asArray()->all();
            foreach ($list as &$value) {
                $value['value'] = $value['id'];
            }

            $citylist = ArrayHelper::itemsMerge($list,0, "id", 'pid', 'children');

            Yii::$app->cache->set('region', $citylist);
        }

        return ResultHelper::json(200, '获取成功', $citylist);
    }
}
