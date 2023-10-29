<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-04 17:15:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-28 19:47:08
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\advertising\DiandiHubIndexMenu;
use common\plugins\diandi_hub\models\advertising\HubLocation;
use common\plugins\diandi_hub\models\advertising\HubLocationAd;
use common\plugins\diandi_hub\models\advertising\HubLocationGoods;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\locationType;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseLabel;
use common\helpers\ImageHelper;
use common\services\BaseService;
use Yii;
use yii\data\Pagination;

class LocationService extends BaseService
{
    public $modelClass = '';

    public static function getLocation($type)
    {
        global $_GPC;
        $where = [];
        $where['type'] = $type;

        $locations = HubLocation::find()
                        ->andFilterWhere($where)
                        ->indexBy('mark')
                        ->orderBy('displayorder')
                        ->asArray()
                        ->all();
        foreach ($locations as $key => &$value) {
            $value['thumb'] = ImageHelper::tomedia($value['thumb']);
        }

        return $locations;
    }

    //根据页面获取广告位内容
    public static function getAd($pageType = 0, $locationType = 1)
    {
        global $_GPC;

        $where = [];
        $where['bloc_id'] = Yii::$app->params['bloc_id'];
        $where['store_id'] = Yii::$app->params['store_id'];
        $where['is_show'] = 1;

        $where['page'] = $pageType;
        $where['type'] = $locationType;

        $locations = HubLocation::find()->where($where)->indexBy('mark')->orderBy('displayorder')->asArray()->all();

        $locationsIds = array_column($locations, 'id');

        $lists_v = [];

        if ($locationType == locationType::getValueByName('商品')) {
            $location_where = [];
            $location_where['bloc_id'] = Yii::$app->params['bloc_id'];
            $location_where['store_id'] = Yii::$app->params['store_id'];
            $whereIn = ['in', 'location_id', $locationsIds];

            $query = HubLocationGoods::find()
                ->where($location_where)
                ->andWhere($whereIn)
                ->with(['disgoods'])
                ->joinWith('goods as g')
                ->where([
                    'g.goods_status' => 1,
                    // 'g.bloc_id'=>Yii::$App->params['bloc_id'],
                    // 'g.store_id'=>Yii::$App->params['store_id']
                    ])
                ->orderBy([
                    'displayorder' => SORT_DESC,
                ]);

            $list = $query->asArray()->all();

            // self::style1 => '一行一个',
            // self::style2 => '一行两个大气版',
            // self::style3 => '一行两个迷你版',
            // self::style4 => '一行单图显示',
            // self::style5 => '一行两图显示',

            $labels = HubGoodsBaseLabel::find()->where($location_where)->indexBy('label')->all();

            $lists = [];

            foreach ($list as $key => $value) {
                if (empty($value['disgoods'])) {
                    $value['disgoods'] = [];
                }

                if ($value['goods']) {
                    $value['goods']['thumb'] = ImageHelper::tomedia($value['goods']['thumb']);
                    $value['goods']['store_name'] = Yii::$app->service->commonGlobalsService->getStoreDetail($value['goods']['store_id'])['name'];
                    $images = unserialize($value['goods']['thumb']);
                    $value['goods']['images'] = ImageHelper::tomedia($images);
                    $value['goods']['label_img'] = ImageHelper::tomedia($labels[$value['goods']['label']]['thumb']);
                    // 推荐位的商品如果是礼包商品区别处理
                    if ($value['goods']['goods_type'] == GoodsTypeStatus::GIFT) {
                        if ($value['goods']['store_id'] == Yii::$app->params['global_store_id']) {
                            // 官方商品
                            $value['goods']['goods_type'] = GoodsTypeStatus::DIRECT;
                            $value['goods_type'] = GoodsTypeStatus::DIRECT;
                        } else {
                            $value['goods']['goods_type'] = GoodsTypeStatus::STORE;
                            $value['goods_type'] = GoodsTypeStatus::DIRECT;
                        }
                    }
                }
                $lists[$value['mark']][] = $value;
            }

            // 数据分组
            foreach ($locations as $mark => &$valu) {
                $valu['thumb'] = ImageHelper::tomedia($valu['thumb']);

                if (!empty($lists[$mark])) {
                    if ($valu['style'] == 2 || $valu['style'] == 3 || $valu['style'] == 5) {
                        $lists_v[$mark] = array_chunk($lists[$mark], 2);
                    } elseif ($valu['style'] == 6) {
                        $lists_v[$mark] = array_chunk($lists[$mark], 3);
                    } else {
                        $lists_v[$mark] = $lists[$mark];
                    }
                } else {
                    $lists_v[$mark] = [];
                    unset($locations[$mark]);
                }
            }
        } elseif ($locationType == locationType::getValueByName('图片')) {
            $whereIn = ['in', 'location_id', $locationsIds];

            $lists_vs = HubLocationAd::find()->where($whereIn)->asArray()->all();

            $maxnums = HubLocation::find()->indexBy('id')->select(['id', 'maxnum'])->asArray()->all();

            foreach ($lists_vs as $key => &$value) {
                $value['thumb'] = ImageHelper::tomedia($value['thumb']);
                $value['goods'] = HubGoodsBaseGoods::find()->where(['goods_id' => $value['goods_id']])->asArray()->one();
                if ($value['goods']) {
                    $value['goods']['ratio'] = floor($value['goods']['sales_actual'] / ($value['goods']['sales_actual'] + $value['goods']['stock']) * 100);
                }
                $value['goods']['thumb'] = ImageHelper::tomedia($value['goods']['thumb']);
                if (intval($maxnums[$value['location_id']]['maxnum']) > 1) {
                    $lists_v[$value['mark']][] = $value;
                } else {
                    $lists_v[$value['mark']] = $value;
                }
            }
        }

        return [
            'location' => $locations,
            'list' => $lists_v,
        ];
    }

    // 获取推荐位的商品
    public static function getGoodsAdv($mark, $page = 1, $pageSize = 10)
    {
        global $_GPC;

        $location_where = [];
        $location_where['bloc_id'] = Yii::$app->params['bloc_id'];
        $location_where['store_id'] = Yii::$app->params['store_id'];
        $whereIn = ['in', 'mark', explode(',', $mark)];

        $query = HubLocationGoods::find()
            ->where($location_where)
            ->andWhere($whereIn)
            ->with(['goods', 'disgoods'])
            ->orderBy([
                'displayorder' => SORT_DESC,
            ]);

        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            // 'page'=>$page-1
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        foreach ($list as $key => $value) {
            if ($value['goods']) {
                $value['goods']['thumb'] = ImageHelper::tomedia($value['goods']['thumb']);
                $images = unserialize($value['goods']['thumb']);
                $value['goods']['images'] = ImageHelper::tomedia($images);
                // 推荐位的商品如果是礼包商品区别处理
                if ($value['goods']['goods_type'] == GoodsTypeStatus::GIFT) {
                    if ($value['goods']['store_id'] == Yii::$app->params['global_store_id']) {
                        // 官方商品
                        $value['goods']['goods_type'] = GoodsTypeStatus::DIRECT;
                        $value['goods_type'] = GoodsTypeStatus::DIRECT;
                    } else {
                        $value['goods']['goods_type'] = GoodsTypeStatus::STORE;
                        $value['goods_type'] = GoodsTypeStatus::DIRECT;
                    }
                }
            }
            $lists[$value['mark']][] = $value;
        }

        return $lists;
    }

    public static function getMenu()
    {
        $DiandiHubIndexMenu = new DiandiHubIndexMenu();
        $where['status'] = 0;
        $list = $DiandiHubIndexMenu->find()->where($where)->orderBy('displayorder')->asArray()->all();
        foreach ($list as $key => &$value) {
            $value['thumb'] = ImageHelper::tomedia($value['thumb']);
            $query = str_replace(PHP_EOL, '&', $value['query']);
            parse_str($query, $arr);
            $value['query'] = $arr;
        }

        return $list;
    }
}
