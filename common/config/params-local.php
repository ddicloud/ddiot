<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-02-29 16:57:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 09:14:12
 */

return [
    'encryptKey'=>'CUS9dZf8YLwveKIm',//系统数据加密key，强烈建议自行更换
    'imageUploadRelativePath' => "../attachment/" . date('Ym/d', time()) . '/', // 图片默认上传的目录
    'imageUploadSuccessPath' => date('Ym/d', time()) . '/', // 图片上传成功后，路径前缀
    // 图片服务器的域名设置，拼接保存在数据库中的相对地址，可通过web进行展示
    'domain' => '/attachment/',
    'webuploader' => [
        // 后端处理图片的地址，value 是相对的地址
        'uploadUrl' => '/upload/upload/uploadimg',
        // 多文件分隔符
        'delimiter' => ',',
        // 基本配置
        'baseConfig' => [
            'defaultImage' => '/resource/images/public/emptyimg.png',
            'disableGlobalDnd' => true,
            'accept' => [
                'title' => 'Images',
                'extensions' => 'gif,jpg,jpeg,bmp,png,doc,pdf,txt,zip,xlsx',
                'mimeTypes' => 'image/*',
            ],
            'pick' => [
                'multiple' => false,
            ],
        ],
    ],
];
