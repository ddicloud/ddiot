<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-22 15:21:47
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-24 14:45:50
 */
namespace common\components\events;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * 派遣器
 * @date 2022-05-22
 * @example
 * @author Wang Chunsheng
 * @since
 */
class DdDispatcher extends EventDispatcher
{
    // 批量派遣
    public function dispatchs(array $events,$event): void
    {
        foreach ($events as $key => $value) {
            $this->dispatch($value,$event);
        }
    }
}


?>