<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-17 20:05:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-17 20:06:42
 */

namespace console\models;

use diandi\admin\acmodels\AuthUserGroup as AcmodelsAuthUserGroup;

class AuthUserGroup extends AcmodelsAuthUserGroup
{
    public static function tableName()
    {
        return '{{%auth_user_group}}';
    }
}
