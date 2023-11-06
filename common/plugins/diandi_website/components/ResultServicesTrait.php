<?php

/**
 * @Author: Radish
 * @Date:   2022-06-23 09:14:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-07 18:36:23
 */

namespace common\plugins\diandi_website\components;

use yii\data\Pagination;
use common\helpers\ResultHelper;

trait ResultServicesTrait
{
    /**
     * 无效的商户信息
     * @var int
     * @date 2022-06-23
     */
    public static $storeInvalid = 40001;

    /**
     * 需要格式化的图片地址
     * @var array
     * @date 2022-06-23
     */
    public static $images = ['image', 'b_image', 'logo'];

    /**
     * @param array $pageInfo = [
     *   'limit_start' => -1 | 1
     *   'pageSize'    => "每页数量"
     *   'page'        => "页码"
     * ]
     * @date 2022-06-23
     */
    private static function baseList($query, $pageInfo = [], $fun = null)
    {
        $query = self::getStoreQuery($query);
        if ($query === self::$storeInvalid) {
            return $query;
        }
        if (!$fun) {
            $fun = function (&$array) use (&$fun) {
                foreach ($array as &$item) {
                    if (is_array($item)) {
                        self::formatData($item);
                        if (count($item) != count($item, 1)) {
                            $fun($item);
                        }
                    }
                }
            };
        }
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

    private static function getStoreQuery($query)
    {
        $where = [
            'store_id' => \yii::$app->params['store_id'] ?? -1,
            'bloc_id' => \yii::$app->params['bloc_id'] ?? -1,
        ];
        foreach ($where as &$val) {
            if ($val <= 0) {
                return self::$storeInvalid;
            }
        }
        $query = $query->andWhere($where);

        return $query;
    }

    public static function formatData(array &$item)
    {
        foreach (self::$images as $val) {
            if (isset($item[$val]) && $item[$val]) {
                $item[$val] = \common\helpers\ImageHelper::tomedia($item[$val]);
            }
        }
    }

    public static function selectOne($query, $where = [])
    {
        $query = self::getStoreQuery($query);
        if ($query === self::$storeInvalid) {
            return $query;
        } else {
            $model = $query->andWhere($where)->asArray()->one();
            $model && self::formatData($model);
            return $model;
        }
    }
}
