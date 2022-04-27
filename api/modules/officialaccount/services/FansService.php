<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-27 15:31:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-27 15:56:31
 */


namespace api\modules\officialaccount\services;

use Yii;
use common\helpers\ArrayHelper;
use common\services\BaseService;
use addons\Wechat\common\models\Fans;
use api\modules\officialaccount\models\DdWechatFans;

/**
 * Class FansService
 * @package addons\Wechat\services
 * @author jianyan74 <751393839@qq.com>
 */
class FansService   extends BaseService
{
    /**
     * @param $openid
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function follow($openid)
    {
        // 获取用户信息
        $user = Yii::$app->wechat->app->user->get($openid);
        $user = ArrayHelper::toArray($user);
        $fans = $this->findModel($openid);
        $fans->attributes = $user;
        $fans->group_id = $user['groupid'];
        $fans->head_portrait = $user['avatarUrl'];
        $fans->followtime = $user['subscribe_time'];
        $fans->follow = DdWechatFans::FOLLOW_ON;
        $fans->save();

        Yii::$app->wechatService->fansStat->upFollowNum();
    }

    /**
     * 取消关注
     *
     * @param $openid
     */
    public function unFollow($openid)
    {
        if ($fans = DdWechatFans::findOne(['openid' => $openid])) {
            $fans->follow = DdWechatFans::FOLLOW_OFF;
            $fans->unfollowtime = time();
            $fans->save();

            Yii::$app->wechatService->fansStat->upUnFollowNum();
        }
    }

    /**
     * 同步关注的用户信息
     *
     * @param $openid
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function syncByOpenid($openid)
    {
        $app = Yii::$app->wechat->app;
        $user = $app->user->get($openid);
        if ($user['subscribe'] == DdWechatFans::FOLLOW_ON) {
            $fans = $this->findModel($openid);
            $fans->attributes = $user;
            $fans->group_id = $user['groupid'];
            $fans->head_portrait = $user['avatarUrl'];
            $fans->followtime = $user['subscribe_time'];
            $fans->follow = DdWechatFans::FOLLOW_ON;
            $fans->save();

            // 同步标签
            $labelData = [];
            foreach ($user['tagid_list'] as $tag) {
                $labelData[] = [$fans->id, $tag, Yii::$app->services->merchant->getId()];
            }

            Yii::$app->wechatService->fansTagMap->add($fans->id, $labelData);
        }
    }

    /**
     * 同步所有粉丝openid
     *
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \yii\db\Exception
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function syncAllOpenid()
    {
        global $_GPC;
        // 获取全部列表
        $fans_list = Yii::$app->wechat->app->user->list();
        // Yii::$app->debris->getWechatError($fans_list);
        $fans_count = $fans_list['total'];

        $total_page = ceil($fans_count / 500);
        for ($i = 0; $i < $total_page; $i++) {
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
                        date('Y-m-d H:i:s',time()),
                        '',
                        $_GPC['store_id'],
                        $_GPC['bloc_id'],
                        time(),
                        time()
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
                    'bloc_id'
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
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findByIdWithTag($fan_id)
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
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findByOpenId($openid)
    {
        return DdWechatFans::find()
            ->where(['openid' => $openid])
            ->findBloc()->findStore()
            ->one();
    }

    /**
     * @param array $openids
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getListByOpenids(array $openids)
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
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getFollowListByPage($page = 0)
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
     * 获取关注的人数
     *
     * @return int|string
     */
    public function getCountFollow()
    {
        return DdWechatFans::find()
            ->where(['follow' => DdWechatFans::FOLLOW_ON])
            ->findBloc()->findStore()
            ->select(['follow'])
            ->count();
    }

    /**
     * 获取用户信息
     *
     * @param $openid
     * @return array|DdWechatFans|null|\yii\db\ActiveRecord
     */
    protected function findModel($openid)
    {
        if (empty($openid) || empty(($model = DdWechatFans::find()->where(['openid' => $openid])->findBloc()->findStore()->one()))) {
            return new DdWechatFans();
        }

        return $model;
    }
}