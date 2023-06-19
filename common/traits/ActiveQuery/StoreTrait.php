<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 14:40:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-19 10:55:16
 */

namespace common\traits\ActiveQuery;

trait StoreTrait
{
    public $blocs = [];

    /** * {@inheritdoc} * @return CommentQuery */
    public static function find()
    {
        return new CommonQuery(get_called_class());
    }

    public function afterFind()
    {
        // 全局处理多商户数据返回
        $this->blocs = [
            $this->bloc_id,
            $this->store_id
        ];

        // 其他处理代码

        parent::afterFind();
    }
}
