<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-22 14:40:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-22 15:03:10
 */

namespace common\traits\ActiveQuery;

trait StoreTrait
{
    /** * {@inheritdoc} * @return CommentQuery */
    public static function find()
    {
        return new CommonQuery(get_called_class());
    }
}
