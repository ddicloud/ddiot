<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-22 22:11:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-11-11 10:17:08
 */


namespace addons\diandi_ai\services;

use addons\diandi_ai\components\baidu\AipFace;
use addons\diandi_ai\models\BaiduConfig;
use addons\diandi_ai\models\DdAiFaces;
use addons\diandi_ai\models\DdAiMember;
use common\helpers\ErrorsHelper;
use common\services\BaseService;
use Yii;

class BaiduFace extends BaseService
{
    static  $client;

    public static function __init()
    {
        $where = [];

        $where['store_id'] = Yii::$app->params['store_id'];

        $where['bloc_id']  = Yii::$app->params['bloc_id'];

        $baidu = BaiduConfig::find()->where($where)->one();

        if (!empty($baidu)) {
            $APP_ID = $baidu['APP_ID'];
            $API_KEY = $baidu['API_KEY'];
            $SECRET_KEY = $baidu['SECRET_KEY'];
            self::$client = new AipFace($APP_ID, $API_KEY, $SECRET_KEY);
        } else {
            ErrorsHelper::throwError(false, '请配置百度ai参数');
        }
    }

    public static function Detect($images_url)
    {
        $image = base64_encode(file_get_contents($images_url));
        $imageType = 'BASE64';
        // 如果有可选参数
        $options = [];
        // 包括age,
        // beauty 美丽程度,
        // expression 表情,
        // face_shape 身材 ,
        // gender 性别,
        // glasses 眼镜,
        // landmark,
        // landmark72，
        // landmark150，
        // race 人种,
        // quality 图片质量,
        // eye_status,
        // emotion 情绪,
        // face_type 信息
        // 逗号分隔. 默认只返回face_token、人脸框、概率和旋转角度
        $options['face_field'] = 'age,beauty,expression,face_shape,gender,glasses,race,quality,eye_status,emotion';
        $options['max_face_num'] = 2;
        $options['face_type'] = 'LIVE';
        $options['liveness_control'] = 'LOW';
        $DdAiMember = new  DdAiMember();

        // 人脸检索存在就返回
        $groupIdList = 1;
        $face_exit = self::$client->search($image, $imageType, $groupIdList, $options);
        // return $face_exit['result']['user_list'];
        if ($face_exit['result']['user_list'][0]['score'] > 95) {
            $user_id = $face_exit['result']['user_list'][0]['user_id'];

            return $DdAiMember::find()->where(['user_id' => $user_id])->one();
        }
        // 带参数调用人脸检测
        $aidatas = self::$client->detect($image, $imageType, $options);
        $face_group_id = 1;
        if ($aidatas['error_msg'] == 'SUCCESS') {
            /* 脸部校验成功 */
            $face_list = $aidatas['result']['face_list'];

            $DdAiFaces = new DdAiFaces();
            foreach ($face_list as $key => $value) {
                $_DdAiMember = clone $DdAiMember;
                $_DdAiFaces = clone $DdAiFaces;
                $face_id = $_DdAiMember->addMember($value, $images_url, $face_group_id);
                if (is_numeric($face_id) && $face_id > 0) {
                    $res[$face_id] = self::$client->addUser($image, $imageType, $face_group_id, $face_id);
                    if ($res[$face_id]['error_code'] == 0) {
                        $faceadd = [
                            'ai_user_id' => $face_id,
                            'ai_group_id' => $face_group_id,
                            'ai_face_status' => 'ok',
                            'face_image' => $images_url,
                            'face_token' => $value['face_token'],
                        ];
                        $_DdAiFaces->setAttributes($faceadd);
                        $_DdAiFaces->save();
                    }
                } else {
                    return $face_id;
                }
            }
        }

        return $res;
    }

    public static function Searchs($images_url)
    {
        $image = base64_encode(file_get_contents($images_url));
        $imageType = 'BASE64';

        // 如果有可选参数
        $options = [];
        $options['face_field'] = 'age';
        $options['max_face_num'] = 2;
        $options['face_type'] = 'LIVE';
        $options['liveness_control'] = 'LOW';
        $groupIdList = 1;
        // 带参数调用人脸检测
        $res = self::$client->search($image, $imageType, $groupIdList, $options);
        return $res;
    }
}

BaiduFace::__init();
