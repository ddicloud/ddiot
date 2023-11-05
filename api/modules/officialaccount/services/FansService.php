<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-27 15:31:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-28 14:15:28
 */

namespace api\modules\officialaccount\services;

use admin\modules\officialaccount\models\DdWechatFans;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\services\BaseService;
use Yii;

/**
 * Class FansService.
 *
 * @author jianyan74 <751393839@qq.com>
 */
class FansService extends BaseService
{
    /**
     * @param $openid
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function follow($openid): void
   {
        // 获取用户信息
        $user = Yii::$app->wechat->app->user->get($openid);
        $user = ArrayHelper::toArray($user);
        loggingHelper::writeLog('officialaccount', 'FansService', '粉丝数据', [
            'user' => $user,
        ]);
        $Res = Yii::$app->fans->signup($user);
        $user_id = $Res['fans']['user_id'];
        loggingHelper::writeLog('officialaccount', 'FansService', '粉丝数据注册后', [
            'Res' => $Res,
            'openid' => $openid,
        ]);
        $fans = $this->findModel($openid);

        loggingHelper::writeLog('officialaccount', 'FansService', '更新关注事件', [
            'fans' => $fans,
            'sql' => DdWechatFans::find()->where(['openid' => $openid])->findBloc()->findStore()->createCommand()->getRawSql(),
        ]);

        $fans->groupid = $user['groupid'];
        $fans->avatarUrl = $user['headimgurl'];
        $fans->unionid = $user['unionid'];
        $fans->followtime = date('Y-m-d H:i:s', $user['subscribe_time']);
        $fans->follow = DdWechatFans::FOLLOW_ON;
        $Res = $fans->save();
        if (!$Res) {
            $msg = ErrorsHelper::getModelError($fans);
            loggingHelper::writeLog('officialaccount', 'FansService', '保存粉丝数据', [
                'Res' => $Res,
                'msg' => $msg,
            ]);
        }
    }

    /**
     * 取消关注.
     *
     * @param $openid
     */
    public function unFollow($openid): void
    {
        if ($fans = DdWechatFans::find()->where(['openid' => $openid])->findStore()->findBloc()->one()) {
            $fans->follow = DdWechatFans::FOLLOW_OFF;
            $fans->unfollowtime = date('Y:m:d H:i:s', time());
            $fans->save();
        }
    }

    /**
     * 同步所有粉丝openid.
     *
     * @return array
     *
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \yii\db\Exception
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function syncAllOpenid(): array
   {
        // 获取全部列表
        $fans_list = Yii::$app->wechat->app->user->list();
        // Yii::$App->debris->getWechatError($fans_list);
        $fans_count = $fans_list['total'];

        $total_page = ceil($fans_count / 500);
        for ($i = 0; $i < $total_page; ++$i) {
            $fans = array_slice($fans_list['data']['openid'], $i * 500, 500);
            // 系统内的粉丝
            $system_fans = $this->getListByOpenids($fans);
            $new_system_fans = ArrayHelper::arrayKey($system_fans, 'openid');

            $add_fans = [];
            foreach ($fans as $openid) {
                if (empty($new_system_fans) || empty($new_system_fans[$openid])) {
                    $add_fans[] = [
                        0,
                        $openid,
                        DdWechatFans::FOLLOW_ON,
                        date('Y-m-d H:i:s', time()),
                        '',
                       \Yii::$app->request->input('store_id',0),
                       \Yii::$app->request->input('bloc_id',0),
                        time(),
                        time(),
                    ];
                }
            }

            if (!empty($add_fans)) {
                // 批量插入数据
                $field = [
                    'member_id',
                    'openid',
                    'follow',
                    'followtime',
                    'tag',
                    'store_id',
                    'bloc_id',
                ];
                Yii::$app->db->createCommand()->batchInsert(DdWechatFans::tableName(), $field, $add_fans)->execute();
            }

            // 更新当前粉丝为关注
            DdWechatFans::updateAll(['follow' => 1], ['in', 'openid', $fans]);
        }

        return [$fans_list['total'], !empty($fans_list['data']['openid']) ? $fans_count : 0, $fans_list['next_openid']];
    }

    /**
     * @param $fan_id
     *
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findByIdWithTag($fan_id): array|\yii\db\ActiveRecord|null
    {
        return DdWechatFans::find()
            ->where(['id' => $fan_id])
            ->findBloc()->findStore()
            // ->with('tags')
            ->asArray()
            ->one();
    }

    /**
     * @param $openid
     *
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findByOpenId($openid): array|\yii\db\ActiveRecord|null
    {
        return DdWechatFans::find()
            ->where(['openid' => $openid])
            ->findBloc()->findStore()
            ->one();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getListByOpenids(array $openids): array
    {
        return DdWechatFans::find()
            ->where(['in', 'openid', $openids])
            ->findBloc()->findStore()
            ->select('openid')
            ->asArray()
            ->all();
    }

    /**
     * @param int $page
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getFollowListByPage(int $page = 0): array
    {
        return DdWechatFans::find()
            ->where(['follow' => DdWechatFans::FOLLOW_ON])
            ->findBloc()->findStore()
            ->offset(10 * $page)
            ->orderBy('id desc')
            ->limit(10)
            ->asArray()
            ->all();
    }

    /**
     * 获取关注的人数.
     *
     * @return int|string
     */
    public function getCountFollow(): int|string
    {
        return DdWechatFans::find()
            ->where(['follow' => DdWechatFans::FOLLOW_ON])
            ->findBloc()->findStore()
            ->select(['follow'])
            ->count();
    }

    /**
     * 获取用户信息.
     *
     * @param $openid
     *
     * @return array|DdWechatFans|\yii\db\ActiveRecord|null
     */
    protected function findModel($openid): DdWechatFans|array|\yii\db\ActiveRecord|null
    {
        if (empty($openid) || empty(($model = DdWechatFans::find()->where(['openid' => $openid])->findBloc()->findStore()->one()))) {
            return new DdWechatFans();
        }

        return $model;
    }
}
