<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-04 00:11:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-04 00:12:17
 */

namespace ddswoole\servers;

use common\services\BaseService;

class DebugService extends BaseService
{
    public static function backtrace()
    {
        $array = debug_backtrace();
        foreach ($array as $row) {
            var_dump($row['file'].':'.$row['line'].'行,调用方法:'.$row['function']);
        }
    }
}
