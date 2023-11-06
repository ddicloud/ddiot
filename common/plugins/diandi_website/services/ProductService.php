<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-23 10:46:40
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-28 12:03:40
 */

namespace common\plugins\diandi_website\services;

use yii\data\Pagination;
use common\services\BaseService;
use common\plugins\diandi_website\models\WebsiteProSlide;
use common\plugins\diandi_website\models\WebsiteProVersion;
use common\plugins\diandi_website\models\WebsiteProPlug;
use common\plugins\diandi_website\models\WebsiteProCustomer;
use common\plugins\diandi_website\models\WebsiteProSelling;
use common\plugins\diandi_website\models\WebsiteProCore;
use common\plugins\diandi_website\models\WebsiteProApp;
use common\plugins\diandi_website\models\WebsiteProConfig;
use common\plugins\diandi_website\models\ProductPrice;

class ProductService extends BaseService
{
    use \addons\diandi_website\components\ResultServicesTrait;

    public static function getSlide($pageInfo = [])
    {
        return self::baseList(WebsiteProSlide::find(), $pageInfo);
    }

    public static function getVersion($pageInfo = [])
    {
        return self::baseList(WebsiteProVersion::find(), $pageInfo);
    }

    public static function getPlug($pageInfo = [])
    {
        return self::baseList(WebsiteProPlug::find(), $pageInfo);
    }

    public static function getCustomer($pageInfo = [], $where = [])
    {
        return self::baseList(WebsiteProCustomer::find()->andWhere($where), $pageInfo);
    }

    public static function getCustomerView($id)
    {
        return self::selectOne(WebsiteProCustomer::find(), ['id' => $id]);
    }

    public static function getSelling($pageInfo = [])
    {
        return self::baseList(WebsiteProSelling::find(), $pageInfo);
    }

    public static function getSellingView($id)
    {
        return self::selectOne(WebsiteProSelling::find(), ['id' => $id]);
    }

    public static function getCore($pageInfo = [], $where = [])
    {
        return self::baseList(WebsiteProCore::find()->andWhere($where), $pageInfo);
    }

    public static function getCoreView($id)
    {
        return self::selectOne(WebsiteProCore::find(), ['id' => $id]);
    }

    public static function getApp($pageInfo = [])
    {
        return self::baseList(WebsiteProApp::find(), $pageInfo);
    }

    public static function getAppView($id)
    {
        return self::selectOne(WebsiteProApp::find(), ['id' => $id]);
    }

    public static function getConfig()
    {
        $model = WebsiteProConfig::find()->where(['store_id' => \yii::$app->params['store_id']])->asArray()->one();
        self::$images = ['image_a', 'image_b', 'image_c', 'image_d'];
        self::formatData($model);
        return $model;
    }

    public static function getPrice($pageInfo = [], $where = [])
    {
        $query = self::getStoreQuery(ProductPrice::find()->andWhere($where));
        if ($query === self::$storeInvalid) {
            return $query;
        }
        $fun = function (&$array) {
            foreach ($array as &$item) {
                self::formatData($item);
                $item['fun'] = json_decode($item['fun'], true);
            }
        };
        $limitStart = $pageInfo['limit_start'] ?? -1;
        if ($limitStart == 1) {
            $pageSize = $pageInfo['pageSize'] ?? 10;
            $page = $pageInfo['page'];
            $count = $query->count();
            // 使用总数来创建一个分页对象
            $pagination = new Pagination([
                'totalCount' => $count,
                'pageSize' => $pageSize,
                'page' => $page,
                'pageParam' => 'page',
            ]);
            $list = $query->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
            $fun($list);
            $data = [
                'list' => $list,
                'total' => (int) $count,
                'pageSize' => (int) $pageSize,
                'page' => (int) ($page > 1 ? ($page - 1) : 1),
            ];
        } else {
            $data = $query->asArray()->all();
            $fun($data);
        }
        return $data;
    }
}
