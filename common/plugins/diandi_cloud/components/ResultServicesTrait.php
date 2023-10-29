<?php

/**
 * @Author: Radish (minradish@163.com)
 * @Date:   2022-09-15 Thursday
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-15 18:45:18
 */

namespace common\plugins\diandi_cloud\components;

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
    public static $images = ['image'];

    /**
     * 是否验证BlocId
     * @var bool
     * @date 2022-08-01
     * @author Radish
     */
    public static $isCheckBlocId = false;

    /**
     * 模型命名空间
     * @var string
     * @date 2022-08-01
     * @author Radish
     */
    public static $modelNamespace = '';

    /**
     * 是否软删除
     * @var bool
     * @date 2022-08-01
     * @author Radish
     */
    public static $isSoftDelete = false;

    /**
     * 模型说明
     * @var string
     * @date 2022-08-01
     * @author Radish
     */
    public static $modelTitle = '模型说明';

    /**
     * 初始化数据
     * @return void
     * @date 2022-08-01
     * @author Radish
     */
    abstract public static function initData();

    /**
     * @param array $pageInfo = [
     *   'limit_state' => -1 | 1
     *   'pageSize'    => "每页数量"
     *   'page'        => "页码"
     * ]
     * @date 2022-06-23
     */
    private static function _baseList($query, $pageInfo = [], $fun = null)
    {
        $query = self::_getStoreQuery($query);
        if ($query === self::$storeInvalid) {
            return $query;
        }
        if (!$fun) {
            $fun = function (&$array) {
                foreach ($array as &$item) {
                    self::formatData($item);
                }
            };
        }
        $limitStart = $pageInfo['limit_state'] ?? -1;
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
                'page' => (int) ($page + 1),
            ];
        } else {
            $data = $query->asArray()->all();
            $fun($data);
        }
        return $data;
    }

    /**
     * 添加公司验证条件
     * @param Query $query
     * @return void
     * @date 2022-08-01
     * @author Radish
     */
    private static function _getStoreQuery($query)
    {
        if (self::$isCheckBlocId === true) {
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
        }

        return $query;
    }

    /**
     * 格式化数据
     * @param array $item
     * @return void
     * @date 2022-08-01
     * @author Radish
     */
    public static function formatData(array &$item)
    {
        foreach (self::$images as $val) {
            if (isset($item[$val]) && $item[$val]) {
                $item[$val] = \common\helpers\ImageHelper::tomedia($item[$val]);
            }
        }
        foreach ($item as &$val) {
            if (is_array($val)) {
                self::formatData($val);
            }
        }
    }

    /**
     * 查询单条数据
     * @param [type] $query
     * @param array $where
     * @return void
     * @date 2022-08-01
     * @author Wang Chunsheng
     */
    public static function selectOne($query, $where = [])
    {
        $query = self::_getStoreQuery($query);
        if ($query === self::$storeInvalid) {
            return $query;
        } else {
            $model = $query->andWhere($where)->asArray()->one();
            $model && self::formatData($model);
            return $model;
        }
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
        $query = self::$modelNamespace::find()->andWhere($where);
        if (static::$isSoftDelete === true) {
            $query->andWhere('deleted_at is null');
        }
        return self::_baseList($query, $pageInfo);
    }

    /**
     * 获取详情
     * @param int $id
     * @return void
     * @date 2022-08-01
     * @author Radish
     */
    public static function getDetail($where)
    {
        static::initData();
        $query = self::$modelNamespace::find();
        if (static::$isSoftDelete === true) {
            $query->andWhere('deleted_at is null');
        }
        return self::selectOne($query, $where);
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

    /**
     * 更新数据
     * @param array $data
     * @param array $where
     * @return array
     * @date 2022-08-01
     * @author Radish
     */
    public static function update($data, $where)
    {
        static::initData();
        $query = self::$modelNamespace::find()->andWhere($where);
        if (static::$isSoftDelete === true) {
            $query->andWhere('deleted_at is null');
        }
        $model = $query->one();
        if ($model) {
            if ($model->load($data, '') && $model->save()) {
                return [true, $model];
            } else {
                return [false, $model];
            }
        } else {
            $model = new self::$modelNamespace;
            $model->addError('id', '无效的' . self::$modelTitle . '记录！');
            return [false, $model];
        }
    }

    /**
     * 删除数据
     * @param array $where
     * @return array
     * @date 2022-08-01
     * @author Radish
     */
    public static function delete($where)
    {
        static::initData();
        $query = self::$modelNamespace::find()->andWhere($where);
        $action = 'delete';
        if (static::$isSoftDelete === true) {
            $query->andWhere('deleted_at is null');
            $action = 'update';
        }
        $model = $query->one();
        if ($model) {
            if ($action == 'update') {
                $model->deleted_at = date('Y-m-d H:i:s');
            }
            if ($model->$action(false)) {
                return [true, $model];
            } else {
                return [false, $model];
            }
        } else {
            $model = new self::$modelNamespace;
            $model->addError('id', '无效的' . self::$modelTitle . '记录！');
            return [false, $model];
        }
    }
}
