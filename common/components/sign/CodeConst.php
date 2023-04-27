<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-16 09:18:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-27 21:06:41
 */

namespace common\components\sign;

/*
 * 模块错误码常量
 */

class CodeConst
{
    // 代码块注释，方便在使用时有提示!!!
    /**
     * 参数不能为空.
     */
    const CODE_90000 = '90000';

    /**
     * 参数不能为空.
     */
    const CODE_90001 = '90001';
    /**
     * 参数错误.
     */
    const CODE_90002 = '90002';
    /**
     * 实体不存在.
     */
    const CODE_90003 = '90003';
    /**
     * 系统故障.
     */
    const CODE_90004 = '90004';
    /**
     * 操作失败.
     */
    const CODE_90005 = '90005';

    const CODE_90006 = '90006';

    const CODE_90007 = '90007';

    /**
     * 业务错误映射表.
     *
     * @return array
     */
    public static function codeMap()
    {
        return [
            // 签名模块错误
            self::CODE_90000 => '该用户签名配置不存在',
            self::CODE_90001 => '签名不能为空,请重新检查签名',
            self::CODE_90002 => '签名数据参数timestamp不合法或为空',
            self::CODE_90003 => '签名错误，请重新检查签名!',
            self::CODE_90004 => '签名验证失效,请重新发送请求',
            self::CODE_90005 => '签名验证失败',
            self::CODE_90006 => 'AppID不能为空',
            self::CODE_90007 => 'AppSecret不能为空',

        ];
    }
}
