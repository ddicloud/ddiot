<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-27 15:31:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-27 15:35:45
 */


namespace api\modules\officialaccount\services;

use addons\Wechat\common\models\ReplyDefault;
use common\services\BaseService;

/**
 * Class ReplyDefaultService
 * @package addons\Wechat\services
 * @author jianyan74 <751393839@qq.com>
 */
class ReplyDefaultService  extends BaseService
{
    /**
     * @return array|ReplyDefault|null|\yii\db\ActiveRecord
     */
    public function findOne()
    {
        if (empty(($model = ReplyDefault::find()->andFilterWhere(['merchant_id' => $this->getMerchantId()])->one()))) {
            return new ReplyDefault();
        }

        return $model;
    }
}