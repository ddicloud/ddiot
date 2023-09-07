<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-31 13:07:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-31 13:24:01
 */

namespace common\components\oss\events;
use yii\base\Event;

/**
 * UploadEvent 上传事件
 *
 */
class UploadEvent extends Event
{
    /**
     * @var mixed 文件系统
     */
    public mixed $filesystem;

    /**
     * @var string 路径
     */
    public string $path;

    /**
     * @var array
     */
    public array $file;
}
