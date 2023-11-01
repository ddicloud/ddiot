<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-14 17:21:58
 */

namespace common\services\common;

use common\helpers\ArrayHelper;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\services\BaseService;
use diandi\addons\models\BlocStore;
use diandi\addons\models\StoreCategory;
use diandi\addons\models\StoreLabel;
use Yii;
use yii\data\Pagination;

/**
 * Class AddressController.
 */
class StoreService extends BaseService
{
    public $modelClass = 'diandi\addons\models\BlocStore';

    public static function list($category_pid, $category_id = 0, $longitude = '', $latitude = '', $keywords = '', $label_id = 0, $page = 1, $pageSize = 10)
    {
        global $_GPC;
        $bloc_id =\Yii::$app->request->input('bloc_id',0);
        $logPath = Yii::getAlias('@api/runtime/StoreService/list/'.date('Y/md').'.log');

        FileHelper::writeLog($logPath, '经纬度计算距离参数'.json_encode([
            $longitude, $latitude,
        ]));

        $list = [];
        $BlocStore = new BlocStore();
        $where = [];
        $whereLike = [];
        $whereNot = [];
        if (!empty($category_pid)) {
            $where['category_pid'] = $category_pid;
        }

        if (!empty($category_id)) {
            $where['category_id'] = $category_id;
        }

        // $global_store_id = intval(Yii::$App->params['global_store_id']);
        // if (!empty($global_store_id)) {
        //     $whereNot = ['!=', 'store_id', $global_store_id];
        // }

        if (!empty($keywords)) {
            $whereLike = ['like', 'name', $keywords];
        }

        $BlocStore = new BlocStore();

        $selectF[] = '*';
        $distance = '';

        // (
        //     st_distance (
        //         point ({$longitude}, {$latitude}),
        //         point (longitude,latitude)
        //     ) * 111195
        // )

        if (!empty($longitude) && !empty($latitude)) {
            $distance = " (6378.138 * 2 * ASIN(
                SQRT(
                    POW(
                        SIN(
                            (
                                {$latitude} * PI() / 180 - latitude * PI() / 180
                            ) / 2
                        ),
                        2
                    ) + COS( {$latitude} * PI() / 180) * COS(latitude * PI() / 180) * POW(
                        SIN(
                            (
                                {$longitude} * PI() / 180 - longitude * PI() / 180
                            ) / 2
                        ),
                        2
                    )
                )
            ) * 1000)";
            $selectF[] = $distance.'  distance';
        }

        // 创建一个 DB 查询来获得所有
        $query = BlocStore::find()->where($where)
            ->andFilterWhere($whereLike)
            ->andWhere(['bloc_id' => $bloc_id])
            // ->andFilterWhere($whereNot)
            ->with(['bloc']);

        // $label_ids = StoreLabel::find()->where(['is_show' => 1])->select('id')->column();
        // if (!empty($label_ids)) {
        //     $query->joinWith('label as label');
        //     $query->andFilterWhere(['label.label_id' => $label_ids]);
        // }

        $query->select($selectF);

        if (!empty($distance)) {
            $query->orderBy([$distance => SORT_ASC]);
        }

        FileHelper::writeLog($logPath, '经纬度计算距离sql02:'.$query->createCommand()->getRawSql());

        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            // 'page'=>$page-1
            // 'pageParam'=>'page'
        ]);

        $stores = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        $cates = StoreCategory::find()->indexBy('category_id')->asArray()->all();

        $info = [];

        foreach ($stores as $key => &$store) {
            $store['distance'] = number_format($store['distance'] / 1000, 2, '.', '');

            $store['cateName'] = $cates[$store['category_id']]['name'];
            $store['catepName'] = $cates[$store['category_pid']]['name'];
            $store['logopath'] = Yii::getAlias('@attachment/'.$store['logo']);
            $store['logo'] = ImageHelper::tomedia($store['logo']);
            $extra = unserialize($store['extra']);
            $extra = $extra ? $extra : [];
            $info = array_merge($store, $extra);
        }

        return $stores;
    }

    public static function getCate($parent_id)
    {
        global $_GPC;
        $bloc_id =\Yii::$app->request->input('bloc_id',0);
        $where = [];
        $where['bloc_id'] = $bloc_id;
        if (!empty($parent_id) && is_numeric($parent_id)) {
            $where['parent_id'] = $parent_id;
        }
        $lists = StoreCategory::find()->where($where)->asArray()->all();

        foreach ($lists as $key => &$value) {
            $value['thumb'] = ImageHelper::tomedia($value['thumb']);
        }
        $list = ArrayHelper::itemsMerge($lists, 0, 'category_id', 'parent_id', 'child', 1);

        return $list;
    }
}
