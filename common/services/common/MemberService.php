<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-09 14:52:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-06 10:48:26
 */

namespace common\services\common;

use admin\models\DdApiAccessToken as ModelsDdApiAccessToken;
use api\models\DdApiAccessToken;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\models\AccountLog;
use common\models\DdMember;
use common\models\DdMemberAccount;
use Yii;
use yii\base\InvalidConfigException;
use common\queues\MailerJob;
use common\services\BaseService;
use yii\data\Pagination;

use function PHPSTORM_META\map;

class MemberService extends BaseService
{
    private $member_id = 1;

    public function setAccessToken($token)
    {
        global $_GPC;
        $tokens = [];

        if (Yii::$app->id == 'app-admin') {
            $tokens = ModelsDdApiAccessToken::find()->where(['access_token' => $token])->asArray()->one();
            $this->member_id = $tokens['user_id'];
        } else if (Yii::$app->id == 'app-api') {
            $tokens = DdApiAccessToken::find()->where(['access_token' => $token])->asArray()->one();
            $this->member_id = $tokens['member_id'];
        }
    }

    // 全局设置商家id
    public function setmember_id($id)
    {
        $this->member_id = $id;
    }

    // 全局设置商家id
    public function getmember_id()
    {
        return $this->member_id;
    }

    /**
     * 获取用户基础信息，默认为当前商户，is_global为true时获取集团用户
     */
    public  function baseInfo($is_global = false)
    {
        $member_id =  $this->member_id;

        if (!$is_global) {
            $bloc_id    = Yii::$app->params['bloc_id'];
            $store_id   = Yii::$app->params['store_id'];
        } else {
            $bloc_id    = Yii::$app->params['global_bloc_id'];
            $store_id   = Yii::$app->params['global_store_id'];
        }

        $logPath = Yii::getAlias('@api/runtime/MemberService/baseInfo/' . date('Y/md') . '.log');

        FileHelper::writeLog($logPath, '模块内回调' . json_encode([
            'global_bloc_id' => Yii::$app->params['global_bloc_id'],
            'is_global' => $is_global,
            'global_store_id' => Yii::$app->params['global_store_id'],
            'bloc_id'   => $bloc_id,
            'store_id'  => $store_id,
            'member_id' => $member_id
        ]));

        $andWhere = [];

        if (!empty(intval($bloc_id))) {
            $andWhere['bloc_id'] = $bloc_id;
        }

        if (!empty(intval($store_id))) {
            $andWhere['store_id'] = $store_id;
        }

        $list =  DdMember::find()->with(['account', 'group', 'fans'])->where([
            'member_id' => $member_id
        ])->andFilterWhere($andWhere)->asArray()->one();

        if (!empty($list)) {
            $list['avatarUrl'] = ImageHelper::tomedia($list['avatarUrl'], 'avatar.jpg');
            $list['avatar'] =     ImageHelper::tomedia($list['avatar'], 'avatar.jpg');
        }


        FileHelper::writeLog($logPath, '获取用户基础信息sql:' . DdMember::find()->with(['account', 'group', 'fans'])->where([
            'member_id' => $member_id
        ])->andFilterWhere($andWhere)->createCommand()->getRawSql());
        FileHelper::writeLog($logPath, '获取用户基础信息' . json_encode($list));

        if (empty($list['account']) && !empty($store_id) && !empty($list)) {
            $account = [
                "member_id" => $member_id,
                "level" => 0,
                "user_money" => 0,
                "accumulate_money" => 0,
                "give_money" => 0,
                "consume_money" => 0,
                "frozen_money" => 0,
                "user_integral" => 0,
                "accumulate_integral" => 0,
                "give_integral" => 0,
                "consume_integral" => 0,
                "frozen_integral" => 0,
                "credit1" => 0,
                "credit2" => 0,
                "credit3" => 0,
                "credit4" => 0,
                "credit5" => 0,
            ];

            $DdMemberAccount = new DdMemberAccount();
            $DdMemberAccount->load($account, '');
            if ($DdMemberAccount->save()) {
                $list['account'] = $account;
            }
        }
        return $list;
    }

    // 修改用户基础信息
    public static function editInfo($member_id, $fields = [])
    {
        $DdMember = new DdMember();
        $res = $DdMember->updateAll($fields, ['member_id' => $member_id]);
        return $res;
    }

    // 获取所有的会员信息
    public static function memberLists($where, $memberAlias, $joinModel, $joinfiled, $fields = [], $page, $pageSize = 20)
    {
        $selectFs = [];
        foreach ($fields as $key => $value) {
            $selectFs[] = '`u`.' . $value;
        }
        $memberTablename = DdMember::tableName();
        $joinTablename   = $joinModel::tableName();
        $query = DdMember::find()->where($where)
            ->alias($memberAlias)
            ->with(['account', 'group', 'fans'])
            ->leftJoin($joinTablename . ' AS u', 'u.' . $joinfiled . ' = ' . $memberAlias . '.member_id')
            ->select([$memberAlias . '.*', implode(',', $selectFs)]);

        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        foreach ($list as $key => $value) {
            $list[$key]['status_str'] = $value['status'] == 0 ? '正常' : '拉黑';
            $list[$key]['create_time'] = date('Y-m-d H:i', $value['create_time']);
        }
        return ['count' => $count, 'list' => $list];
    }

    public function updateAccount($member_id, $fields, $num, $is_global = false)
    {
        $logPath = Yii::getAlias('@api/runtime/MemberService/updateAccount/' . date('Y/md') . '.log');

        if (!$is_global) {
            $bloc_id    = Yii::$app->params['bloc_id'];
            $store_id   = Yii::$app->params['store_id'];
        } else {
            $bloc_id    = Yii::$app->params['global_bloc_id'];
            $store_id   = Yii::$app->params['global_store_id'];
        }


        FileHelper::writeLog($logPath, '更新用户资产' . json_encode([
            'global_bloc_id' => Yii::$app->params['global_bloc_id'],
            'global_store_id' => Yii::$app->params['global_store_id'],
            'bloc_id' => $bloc_id,
            'store_id' => $store_id,
            'member_id' => $member_id
        ]));

        $old_money = DdMemberAccount::find()->where(['member_id' => $member_id])->select($fields)->scalar();

        $Res = DdMemberAccount::updateAllCounters([
            $fields => $num
        ], ['member_id' => $member_id]);

        if ($Res) {

            $this->addAccountLog($member_id, $fields, $num, $old_money);

            $list =  DdMember::find()->with(['account', 'group', 'fans'])->where([
                'member_id' => $member_id,
                'bloc_id' => $bloc_id,
                'store_id' => $store_id,
            ])->asArray()->one();
            return $list;
        } else {
            return false;
        }
    }

    public  function addAccountLog($member_id, $fields, $money, $old_money, $money_id = 0, $remark = '')
    {
        $accountLog = [
            'member_id'     => $member_id,
            'account_type' => $fields,
            'money' => $money,
            'money_id' => $money_id,
            'old_money' => $old_money,
            'is_add' => $money > 0 ? 1 : 0,
            'remark' => '',

        ];

        $AccountLog = new AccountLog();
        $AccountLog->load($accountLog, '');
        $Res = $AccountLog->save();
        return $Res;
    }
}
