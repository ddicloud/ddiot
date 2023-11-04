<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 04:22:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-14 18:30:32
 */

namespace addons\diandi_integral\services;

use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\DdUserAddress;
use common\services\BaseService;

/**
 * Class SmsService
 * @package common\services\backend
 * @author chunchun <2192138785@qq.com>
 */
class AddressService extends BaseService
{
    public static function add($data): array
    {
        $DdUseraddress = new DdUserAddress();
        $is_firest = $DdUseraddress::findOne(['user_id' => $data['user_id'], 'is_default' => 1]);

        if ($DdUseraddress->load($data, '') && $DdUseraddress->save()) {
            if (empty($is_firest) || $data['is_default'] == 1) {
                self::setDefault($data['user_id'], $DdUseraddress['address_id']);
            }
            return $DdUseraddress->toArray();
        } else {
            $msg = ErrorsHelper::getModelError($DdUseraddress);
            return ResultHelper::json(400, $msg);
        }
    }

    public static function edit($data, $user_id): array|string
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
     * @param int|null $user_id post
     * @return array
     */
    public static function getDefault(?int $user_id): array
    {
        $DdUserAddress = new DdUserAddress();
        $defaults = $DdUserAddress::find()->with('regions', 'province', 'region', 'city')->where(['user_id' => $user_id, 'is_default' => 1])->asArray()->one();
        return $defaults ?? [];
    }

    /**
     * 设置默认地址.
     *
     * @param int|null $user_id post
     * @param $address_id
     * @return array|string
     */
    public static function setDefault(?int $user_id, $address_id): array|string
    {
        $DdUserAddress = new DdUserAddress();

        $DdUserAddress->updateAll(['is_default' => 0], ['user_id' => $user_id]);
        $DdUserAddress->updateAll(['is_default' => 1], ['user_id' => $user_id, 'address_id' => $address_id]);

        $msg = ErrorsHelper::getModelError($DdUserAddress);

        if (!empty($msg)) {
            return ResultHelper::json(400, $msg);
        } else {
            return self::getList($user_id);
        }
    }

    public static function getList($user_id): array
    {
        return DdUserAddress::find()->where(['user_id' => $user_id])->with('regions')->asArray()->all();
    }

    public static function delete($user_id, $address_id): array|string
    {
        $DdUserAddress = new DdUserAddress();

        $res = $DdUserAddress::deleteAll(['user_id' => $user_id, 'address_id' => $address_id]);
        $msg = ErrorsHelper::getModelError($DdUserAddress);

        if (!empty($msg)) {
            return ResultHelper::json(400, $msg);
        } else {
            return self::getList($user_id);
        }
    }

    public static function detail($user_id, $address_id): array|\yii\db\ActiveRecord|null
    {
        $DdUserAddress = new DdUserAddress();
        return $DdUserAddress->find()->where(['user_id' => $user_id, 'address_id' => $address_id])->with(['regions', 'province', 'region', 'city'])->asArray()->one();
    }
}
