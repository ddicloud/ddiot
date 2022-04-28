<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-27 15:31:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-28 14:04:34
 */

namespace api\modules\officialaccount\services;

use common\helpers\ArrayHelper;
use common\models\Qrcode;
use common\models\QrcodeStat;
use common\services\BaseService;
use Yii;

/**
 * Class QrcodeStatService.
 *
 * @author jianyan74 <751393839@qq.com>
 */
class QrcodeStatService extends BaseService
{
    /**
     * 判断二维码扫描事件.
     *
     * @param array $message 微信消息
     *
     * @return bool|mixed
     */
    public function scan($message)
    {
        // 关注事件
        if ($message['Event'] == 'subscribe' && !empty($message['Ticket'])) {
            if ($qrCode = Yii::$app->wechatService->qrcode->findByWhere(['ticket' => trim($message['Ticket'])])) {
                $this->create($qrCode, $message['FromUserName'], QrcodeStat::TYPE_ATTENTION);

                return $qrCode['keyword'];
            }
        }

        if (!isset($message['EventKey'])) {
            return false;
        }

        // 扫描事件
        $where = ['scene_str' => $message['EventKey']];
        if (is_numeric($message['EventKey'])) {
            $where = ['scene_id' => $message['EventKey']];
        }

        if ($qrCode = Yii::$app->wechatService->qrcode->findByWhere($where)) {
            Qrcode::updateAllCounters(['subnum' => 1], ['id' => $qrCode['id']]);
            $this->create($qrCode, $message['FromUserName'], QrcodeStat::TYPE_SCAN);

            return $qrCode['keyword'];
        }

        return false;
    }

    /**
     * 插入扫描记录.
     *
     * @param Qrcode $qrCode
     * @param $openid
     * @param $type
     */
    public function create($qrCode, $openid, $type)
    {
        $model = new QrcodeStat();
        $model->attributes = ArrayHelper::toArray($qrCode);
        $model->qrcord_id = $qrCode->id;
        $model->openid = $openid;
        $model->type = $type;
        $model->save();
    }
}
