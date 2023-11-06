<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-23 10:46:40
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-12 11:41:42
 */

namespace common\plugins\diandi_website\services;

use common\services\BaseService;
use addons\diandi_website\models\SolutionCate;
use addons\diandi_website\models\Solution;
use addons\diandi_website\models\searchs\BackendExhibitSearch;

class SolutionService extends BaseService
{
    use \addons\diandi_website\components\ResultServicesTrait;

    public static function getCate($pageInfo = [], $solutionLimit = 10, $solutionNameWhere = '')
    {
        self::$images = ['icon'];
        $fun = function (&$array) use (&$fun, $solutionLimit, $solutionNameWhere) {
            foreach ($array as &$item) {
                if (is_array($item)) {
                    self::formatData($item);
                    if (count($item) != count($item, 1)) {
                        $fun($item);
                    }
                    if ($solutionNameWhere) {
                        $item['solution'] = Solution::find()
                            ->andWhere(['cate_id' => $item['id']])
                            ->andWhere('name like "%' . $solutionNameWhere . '%" OR des like "%' . $solutionNameWhere . '%"')
                            ->limit($solutionLimit)
                            ->asArray()
                            ->all();
                    } else {
                        $item['solution'] = Solution::find()->andWhere(['cate_id' => $item['id']])->limit($solutionLimit)->asArray()->all();
                    }
                }
            }
        };

        return self::baseList(SolutionCate::find(), $pageInfo, $fun);
    }

    public static function getList($pageInfo = [], $where = [], $solutionNameWhere = '')
    {
        self::$images = ['icon'];
        $query = Solution::find()->andWhere($where);
        if ($solutionNameWhere) {
            $query = $query->andWhere('name like "%' . $solutionNameWhere . '%" OR des like "%' . $solutionNameWhere . '%"');
        }
        return self::baseList($query, $pageInfo);
    }
    public static function getBacExhibit($pageInfo = [], $where = [])
    {
        self::$images = ['icon', 'image'];
        return self::baseList(BackendExhibitSearch::find()->andWhere($where), $pageInfo);
    }
}
