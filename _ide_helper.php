<?php


use common\components\ExtendedRequest;
use yii\web\Application;

class Yii
{
    /**
     * @var MyApplication
     */
    public static MyApplication $app;
}

/**
 * 组件代码自动提示助手
 * @property ExtendedRequest $request
 * @property common\services\BaseService $service
 * @property yii2mod\settings\components\Settings $settings
 */
class MyApplication extends Application
{
    /**
     * @var mixed|object|null
     */
    public mixed $template_message;

    /**
     * @var mixed|object|null
     */
    public mixed $wechat;

    /**
     * @var yii\queue\Queue
     *
     */
    public mixed $queue;
}

