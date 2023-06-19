<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 14:40:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-19 13:47:23
 */

namespace common\traits\ActiveQuery;

trait StoreTrait
{
    public $blocs = [];

    /**
     * find查询扩展.
     *
     * @return CommonQuery
     * @date 2023-06-19
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function find()
    {
        return new CommonQuery(get_called_class());
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['blocs'] = 'blocs';
        return $fields;
    }

    public function afterFind()
    {
        $store_id = $this->getAttribute('store_id');
        $bloc_id = $this->getAttribute('bloc_id');
        $this->blocs = [$bloc_id,$store_id];
        parent::afterFind();
    }
}
