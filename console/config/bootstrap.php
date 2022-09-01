<?php
/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-10-27 14:38:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-01 09:59:02
 */
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@admin', dirname(dirname(__DIR__)) . '/admin');
Yii::setAlias('@addons', dirname(dirname(__DIR__)) . '/addons');
Yii::setAlias('@attachment', dirname(dirname(__DIR__)) . '/frontend/attachment');
Yii::setAlias('@swooleService', dirname(dirname(__DIR__)) . '/swoole');
Yii::setAlias('@vue', dirname(dirname(__DIR__)) . '/common/widgets/firevue');
