<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-27 15:31:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-28 14:03:56
 */

namespace api\modules\officialaccount\services;

use common\models\Qrcode;
use common\services\BaseService;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class QrcodeService.
 *
 * @author jianyan74 <751393839@qq.com>
 */
class QrcodeService extends BaseService
{
    /**
     * @param array $where
     * @return array|ActiveRecord|null
     */
    public function findByWhere(array $where = []): array|\yii\db\ActiveRecord|null
    {
        return Qrcode::find()
            ->filterWhere($where)
            ->findStore()
            ->orderBy('created_at desc')
            ->one();
    }

    /**
     * 返回场景ID.
     *
     * @return int|mixed
     */
    public function getSceneId(): mixed
    {
        $qrCode = Qrcode::find()
            ->where(['model' => Qrcode::MODEL_TEM])
            ->findStore()
            ->orderBy('created_at desc')
            ->one();

        return $qrCode ? $qrCode->scene_id + 1 : 10001;
    }

    public function syncCreate(Qrcode $model): Qrcode
    {
        $qrcode = Yii::$app->wechat->app->qrcode;
        if ($model->model == Qrcode::MODEL_TEM) {
            $scene_id = $this->getSceneId();
            $result = $qrcode->temporary($scene_id, $model->expire_seconds);
            $model->scene_id = $scene_id;
            $model->expire_seconds = $result['expire_seconds']; // 有效秒数
        } else {
            $result = $qrcode->forever($model->scene_str);
        }

        $model->ticket = $result['ticket'];
        $model->type = 'scene';
        $model->url = $result['url']; // 二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片

        return $model;
    }
}
