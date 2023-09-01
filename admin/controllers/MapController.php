<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 04:06:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 16:47:24
 */

namespace admin\controllers;

use common\helpers\ArrayHelper;
use common\helpers\MapHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use Yii;

class MapController extends AController
{
    public $modelClass = '';
    protected array $authOptional = ['distance'];
    
    public int $searchLevel = 0;


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
        $regionVal = Yii::$app->cache->get('admin.region');
        if ($regionVal) {
            $citylist = $regionVal;
        } else {
            $list = $region->find()->select(['name', 'id', 'pid', 'name as label', 'id as value'])->asArray()->all();
            foreach ($list as $key => &$value) {
                $value['value'] = $value['id'];
            }

            $citylist = ArrayHelper::itemsMerge($list, $pid = 0, 'id', 'pid', 'children');

            Yii::$app->cache->set('admin.region', $citylist);
        }

        return ResultHelper::json(200, '获取成功', $citylist);
    }
}
