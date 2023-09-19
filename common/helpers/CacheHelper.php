<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-08-13 00:35:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-21 22:11:36
 */
 

namespace common\helpers;

use Yii;
use yii\redis\Cache as RedisCache;

class CacheHelper extends RedisCache
{
    public $duration;

    // public function init()
    // {
    //     parent::init();
    //     $this->duration = Yii::$App->params['cache']['duration'];
    // }

    
    // public  function set($key, $value, $duration = null, $dependency = null)
    // {
    //     if($duration == null){
    //         $duration = $this->duration;
    //     }
        
    //     return parent::set($key, $value, $duration, $dependency);
    // }


    public function buildKey($key)
    {
        global $_GPC;
        $user_id = 0;
        if(Yii::$app->user->identity){
            $user_id  = Yii::$app->user->identity->id;
        }
        $terminal = Yii::$app->id;
        $store_id = $_GPC['store_id'];
        // [终端，用户，商户]
        if(is_string($key)){
            return parent::buildKey([$key,$terminal,$store_id,$user_id]);
        }
        
        if(is_array($key)){
            $initKey =  array_merge($key,[$key,$terminal,$store_id,$user_id]);
            return parent::buildKey($initKey);
        }
    }
  
}
