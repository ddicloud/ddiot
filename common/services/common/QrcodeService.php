<?php

use common\services\BaseService;

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-13 01:18:13
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-13 01:18:32
 */
namespace common\services\common;

use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\models\Qrcode;
use common\services\BaseService;
use Yii;

class QrcodeService extends BaseService
{
//     [ticket] => gQFD8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyTmFjVTRWU3ViUE8xR1N4ajFwMWsAAgS2uItZAwQA6QcA
// //     [expire_seconds] => 518400
// //     [url] => http://weixin.qq.com/q/02NacU4VSubPO1GSxj1p1k
    public static function createCode($type,$ticket,$scene_str,$url,$member_id,$expire_seconds=0)
    { 
        $logPath = Yii::getAlias('@runtime/officialaccount/Qrcode'.date('ymd').'.log');

        $Qrcode = new Qrcode();
        $data = [
            'member_id'=>$member_id,
            'type'=>$type,
            'ticket'=>$ticket,
            'url'=>$url,
            'status'=>0,
            'scene_str'=>$scene_str,
            'expire'=>$expire_seconds,
        ];

        if($Qrcode->load($data,'') && $Qrcode->save()){
            return true;
        }
        $errors = ErrorsHelper::getModelError($Qrcode);

        FileHelper::writeLog($logPath, json_encode($errors));
            
        return false;
    } 
}

