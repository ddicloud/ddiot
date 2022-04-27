<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-27 15:31:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-27 15:33:36
 */


namespace api\modules\officialaccount\services;

use Yii;
use yii\web\NotFoundHttpException;
use addons\Wechat\common\models\FansTags;
use common\services\BaseService;
use diandi\swoole\server\BaseServer;

/**
 * Class FansTagsService
 * @package addons\Wechat\services
 * @author jianyan74 <751393839@qq.com>
 */
class FansTagsService extends BaseServer
{
    /**
     * @param array $createData
     * @param array $updateData
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function syncSave($createData = [], $updateData = [])
    {
        // 更新标签
        foreach ($updateData as $key => $value) {
            if (empty($value)) {
                throw new NotFoundHttpException('标签内容不能为空');
            }

            Yii::$app->wechat->app->user_tag->update($key, $value);
        }

        // 插入标签
        foreach ($createData as $datum) {
            Yii::$app->wechat->app->user_tag->create($datum);
        }

        return $this->getList(true);
    }

    /**
     * @param $id
     * @return bool
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function findById($id)
    {
        $tags = $this->getList();
        foreach ($tags as $vo) {
            if ($vo['id'] == $id) {
                return $vo;
            }
        }

        return false;
    }

    /**
     * 获取标签
     *
     * @param bool $reacquire 远程获取
     * @return mixed
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function getList($reacquire = false)
    {
        if (empty(($model = FansTags::find()->filterWhere(['merchant_id' => $this->getMerchantId()])->one()))) {
            $model = new FansTags();
        }

        if ($model->isNewRecord || true === $reacquire) {
            $list = Yii::$app->wechat->app->user_tag->list();
            Yii::$app->debris->getWechatError($list);
            $tags = isset($list['tags']) ? $list['tags'] : [];
            $model->tags = serialize($tags);
            $model->save();
        }

        return unserialize($model->tags);
    }
}