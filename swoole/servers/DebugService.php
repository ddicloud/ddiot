<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-04 00:11:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-09 14:49:34
 */

namespace ddswoole\servers;

use common\services\BaseService;

class DebugService extends BaseService
{
    public static function backtrace()
    {
        $array = debug_backtrace();
        foreach ($array as $row) {
            if (isset($row['file'])) {
                var_dump($row['file'].':'.$row['line'].'行,调用方法:'.$row['function']);
            }
        }
    }

    /**
     * 控制台调试内容显示.
     *
     * @param [type] $remark  备注
     * @param [type] $content 结果信息
     *
     * @return void
     * @date 2022-09-08
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function consoleWrite($remark, $content)
    {
        if (is_array($content)) {
            $content = json_encode($content);
        }
        echo "#[$remark]#$content".PHP_EOL;
    }

    /**
     * 控制台分割线
     *
     * @param [type] $remark
     *
     * @return void
     * @date 2022-09-08
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function consoleCrosswise($remark)
    {
        echo "#[$remark]#-----------------------------------------".PHP_EOL;
    }
}
