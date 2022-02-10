<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-05 12:09:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-19 11:30:19
 */

return [
    // 人脸识别api
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_ai/face'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST   detect' => 'detect',
            'POST   faceverify' => 'faceverify',
            'POST   searchs' => 'searchs',
            'POST   multiSearch' => 'multiSearch',
            'POST   match' => 'match',
            'POST   addUser' => 'addUser',
            'POST   faceDelete' => 'faceDelete',
            'POST   getUser' => 'getUser',
            'POST   userCopy' => 'userCopy',
            'POST   groupAdd' => 'groupAdd',
            'POST   groupDelete' => 'groupDelete',
            'POST   getGroupList' => 'getGroupList',
            'POST   personVerify' => 'personVerify',
            'POST   updateUser' => 'updateUser',
            'POST   faceGetlist' => 'faceGetlist',
            'POST   getGroupUsers' => 'getGroupUsers',
            'POST   deleteUser' => 'deleteUser',
            'POST   getVersion' => 'getVersion',
            'POST   setConnectionTimeoutInMillis' => 'setConnectionTimeoutInMillis',
            'POST   setSocketTimeoutInMillis' => 'setSocketTimeoutInMillis',
            'POST   setProxies' => 'setProxies',
            'POST   report' => 'report',
            'POST   Npost' => 'Npost',
            'POST   videoSessioncode' => 'videoSessioncode',
        ],
    ],
];
