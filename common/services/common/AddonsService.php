<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-25 02:36:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-21 22:22:34
 */
 

namespace common\services\common;

use Yii;
use yii\base\InvalidConfigException;
use common\queues\MailerJob;
use common\services\BaseService;
use diandi\addons\models\searchs\DdAddons;

class AddonsService extends BaseService
{

    public static function getAddonsInfo($identifie)
    {
        $keys = ['AddonsService',$identifie.'info'];
        if(Yii::$app->cache->get($keys)){
            return Yii::$app->cache->get($keys);
        }else{
            $addons = DdAddons::findOne(['identifie'=>$identifie]);
            Yii::$app->cache->set($keys,$addons);  
            return $addons;
        }
    }
}