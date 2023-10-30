<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-09-21 15:22:22
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-22 15:23:16
 */

namespace common\plugins\diandi_hub\services;

use common\services\BaseService;
use common\plugins\diandi_hub\models\enums\{
    TicketsType,
    TicketsStatus,
};

class TicketsService extends BaseService
{
    use \addons\diandi_hub\components\ResultServicesTrait;

    public static function initData()
    {
        self::$modelNamespace = '\addons\diandi_hub\models\HubTickets';
        // self::$isSoftDelete = true;
        self::$modelTitle = '工单';
        // self::$isCheckBlocId = true;
        self::$images = ['thumb'];
    }

    public static function getDetail($where)
    {
        static::initData();
        $query = self::$modelNamespace::find()->orderBy('created_at DESC')->with(['order', 'goods']);

        return self::selectOne($query, $where);
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

    public static function updateStatus($where, $status)
    {
        static::initData();
        $model = self::$modelNamespace::find()->andWhere($where)->one();
        if ($model) {
            if (!isset(TicketsStatus::$list[$status])) {
                $model->addError('id', '无效的状态！');
                return [false, $model];
            }
            $model->status = $status;
            if ($model->save(false)) {
                return [true, $model];
            } else {
                return [false, $model];
            }
        } else {
            $model = new self::$modelNamespace;
            $model->addError('id', '无效的' . self::$modelTitle . '信息！');
            return [false, $model];
        }
    }
}