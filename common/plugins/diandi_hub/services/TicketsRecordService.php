<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-09-21 15:22:22
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-22 17:43:37
 */

namespace common\plugins\diandi_hub\services;

use common\services\BaseService;
use common\plugins\diandi_hub\models\enums\{
    TicketsType,
    TicketsStatus,
};

class TicketsRecordService extends BaseService
{
    use \addons\diandi_hub\components\ResultServicesTrait;

    public static function initData()
    {
        self::$modelNamespace = '\addons\diandi_hub\models\HubTicketsRecord';
        // self::$isSoftDelete = true;
        self::$modelTitle = '工单';
        // self::$isCheckBlocId = true;
        // self::$images = ['thumb'];
    }

    /**
     * 获取列表
     * @param array $pageInfo
     * @param array $where
     * @return void
     * @date 2022-08-01
     * @author Radish
     */
    public static function getLists($pageInfo = [], $where = [])
    {
        static::initData();
        $query = self::$modelNamespace::find()->andWhere($where)->orderBy('created_at DESC');

        return self::_baseList($query, $pageInfo);
    }

    /**
     * 创建
     * @param array $data
     * @return array
     * @date 2022-08-01
     * @author Radish
     */
    public static function create($data)
    {
        static::initData();
        $model = new self::$modelNamespace();
        if ($model->load($data, '') && $model->save()) {
            return [true, $model];
        } else {
            return [false, $model];
        }
    }
}
