<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 04:22:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-02 00:04:13
 */

namespace common\plugins\diandi_hub\services;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;
use yii\helpers\Json;
use common\services\BaseService;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\models\DdMenuCate;
use common\models\DdUser;
use common\models\DdUserAddress;

/**
 * Class SmsService
 * @package common\services\backend
 * @author chunchun <2192138785@qq.com>
 */
class AddressService extends BaseService
{
    public static function add($data)
    {
        $DdUseraddress = new DdUserAddress();
        if(!empty($data['user_id'])){
            $is_firest = $DdUseraddress::findOne(['user_id' => $data['user_id'],'is_default'=>1]);
        
            if ($DdUseraddress->load($data, '') &&  $DdUseraddress->save()) {
                if (empty($is_firest) || $data['is_default']==1) {
                    self::setDefault($data['user_id'], $DdUseraddress['address_id']);
                }
                return $DdUseraddress;
            } else {
                return ErrorsHelper::getModelError($DdUseraddress);
            }
        }
    }

    public static function edit($data, $user_id)
    {
        $DdUseraddress = new DdUserAddress();
        $address_id = $data['address_id'];
        unset($data['address_id'], $data['access-token']);
        $DdUseraddress->updateAll($data, ['address_id' => $address_id, 'user_id' => $user_id]);
        $errors = ErrorsHelper::getModelError($DdUseraddress);

        if (!empty($errors)) {
            return $errors;
        } else {
            return self::getDefault($user_id);
        }
    }
    /**
     * 获取默认地址.
     *
     * @param int|null post
     * @return string
     * @throws NotFoundHttpException
     */
    public static function getDefault($user_id)
    {
        $DdUserAddress = new DdUserAddress();
        return  $DdUserAddress::find()->with('regions','province','region','city')->where(['user_id' => $user_id, 'is_default' => 1])->asArray()->one();
    }

    /**
     * 设置默认地址.
     *
     * @param int|null post
     * @return string
     * @throws NotFoundHttpException
     */
    public static function setDefault($user_id, $address_id)
    {
        $DdUserAddress = new DdUserAddress();
        
        $DdUserAddress->updateAll(['is_default' => 0], ['user_id' => $user_id]);
        $DdUserAddress->updateAll(['is_default' => 1], ['user_id' => $user_id, 'address_id' => $address_id]);

        $errors = ErrorsHelper::getModelError($DdUserAddress);

        if (!empty($errors)) {
            return $errors;
        } else {
            return self::getList($user_id);
        }
    }

    public static function getList($user_id)
    {
        $list = DdUserAddress::find()->where(['user_id' => $user_id])->with('regions')->asArray()->all();
        return $list;
    }

    public static function delete($user_id, $address_id)
    {
        $DdUserAddress = new DdUserAddress();

        $res = $DdUserAddress::deleteAll(['user_id' => $user_id, 'address_id' => $address_id]);
        $errors = ErrorsHelper::getModelError($DdUserAddress);

        if (!empty($errors)) {
            return $errors;
        } else {
            return self::getList($user_id);
        }
    }

    public static function detail($user_id, $address_id)
    {
        $DdUserAddress = new DdUserAddress();
        $res = $DdUserAddress->find()->where(['user_id' => $user_id, 'address_id' => $address_id])->with(['regions','province','region','city'])->asArray()->one();
        return $res;
    }
}
