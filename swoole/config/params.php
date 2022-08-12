<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-19 20:27:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-22 02:30:26
 */
 

return [
    'uploadFile' => [
        'extensions' => ['jpg', 'png', 'jpeg', 'jpe', 'pdf', 'mp4','xls','txt'],
        'mime_types' => ['image/*', 'application/pdf', 'video/mp4','application/vnd.ms-excel','text/plain'],
        'max_size' => 10 * 1024 * 1024,
        'min_size' => 1,
        'message' => '上传失败',
        'pluginOptions' => [
            'uploadUrl' => '/upload/upload/uploadfile',

            'showUpload' => true,
            'uploadExtraData' => [
                'field' => 'DdGoods[video]',
                'path' => 'goods',
            ],
            'maxFileCount' => 1,
        ],
        'theme' => 'fa',
    ],
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'conf' => [],
    'diandiai' => [
        'APP_ID' => '',
        'API_KEY' => '',
        'SECRET_KEY' => '',
    ],
    // 微信配置
    // 微信配置 具体可参考EasyWechat
    'wechatConfig' => [
        'app_id' => '',
        'secret' => '',
        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',
    ],

    // 微信支付配置 具体可参考EasyWechat
    'wechatPaymentConfig' => [],

    // 微信小程序配置 具体可参考EasyWechat
    'wechatMiniProgramConfig' => [],

    // 微信开放平台第三方平台配置 具体可参考EasyWechat
    'wechatOpenPlatformConfig' => [],

    // 微信企业微信配置 具体可参考EasyWechat
    'wechatWorkConfig' => [],

    // 微信企业微信开放平台 具体可参考EasyWechat
    'wechatOpenWorkConfig' => [],
    'cache'=>[
        'duration'=>20*10,//全局缓存时间
    ],
    'adminEmail' => 'admin@example.com',
    /* ------ token相关 ------ **/
    // token有效期是否验证 默认不验证
    'user.accessTokenValidity' => true,
    // token有效期 默认 2 小时
    'user.accessTokenExpire' => 2 * 60 * 60,
    // refresh token有效期是否验证 默认开启验证
    'user.refreshTokenValidity' => true,
    // refresh token有效期 默认30天
    'user.refreshTokenExpire' => 30 * 24 * 60 * 60,
    // 签名验证默认关闭验证，如果开启需了解签名生成及验证
    'user.httpSignValidity' => false,
    // 签名授权公钥秘钥
    'user.httpSignAccount' => [
        'doormen' => 'e3de3825cfbf',
    ],
    'cache' => [
        'duration' => 20 * 10, //全局缓存时间
    ],
    'api' => [
        'rateLimit' =>300, //速率限制,
        'timeLimit' =>60
    ],
];