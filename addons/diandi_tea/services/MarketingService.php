<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-24 11:27:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-30 10:34:32
 */

namespace addons\diandi_tea\services;

use addons\diandi_tea\models\marketing\TeaCoupon;
use common\helpers\ImageHelper;
use common\models\DdMemberAccount;
use common\services\BaseService;
use Yii;

class MarketingService extends BaseService
{
    public static function couponDetail($coupon_id): array|\yii\db\ActiveRecord
    {
        $info = TeaCoupon::find()->where(['id' => $coupon_id])->asArray()->one();
        $info['background'] = ImageHelper::tomedia($info['background']);
        $info['coupon_img'] = ImageHelper::tomedia($info['coupon_img']);
        $member_id = Yii::$app->user->identity->member_id??0;
        $info['balance'] = DdMemberAccount::find()->where(['member_id' => $member_id])->select('user_money')->asArray()->one()['user_money'];

        return $info;
    }
}
