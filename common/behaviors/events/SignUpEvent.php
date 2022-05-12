<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-12 14:38:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-12 14:40:25
 */

namespace common\behaviors\events;

use yii\base\Event;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class SignUpEvent extends Event
{
    /**
     * 请求的业务插件.
     *
     * @var [type]
     * @date 2022-05-12
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public $addons;

    /**
     * 请求的终端，分为api和admin.
     *
     * @var string
     * @date 2022-05-12
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public $terminal = 'api';

    /**
     * 业务插件中的服务类名称.
     *
     * @var [type]
     * @date 2022-05-12
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public $serviceClassName;

    /**
     * 服务类名称中的方法.
     *
     * @var [type]
     * @date 2022-05-12
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public $action;

    /**
     * 需要传递的参数.
     *
     * @var [type]
     * @date 2022-05-12
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public $params;
}
