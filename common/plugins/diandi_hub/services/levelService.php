<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-02 17:10:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-07 15:02:57
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\config\HubConfig;
use common\plugins\diandi_hub\models\level\butionLevelEarningsConf as LevelButionLevelEarningsConf;
use common\plugins\diandi_hub\models\level\HubLevel as MemberHubLevel;
use common\plugins\diandi_hub\models\member\HubMemberLevel;
use common\plugins\diandi_hub\services\account\LevelAccount;
use common\plugins\diandi_hub\services\account\OrderAccount;
use common\plugins\diandi_hub\services\account\TeamAccount;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\services\BaseService;
use Yii;
use yii\data\Pagination;

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-05 08:24:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-06-05 08:25:05
 */
class levelService extends BaseService
{
    public static $RadioSaletotal = 1; //销售额系数
    public static $RadioGifttotal = 1; //礼包购买系数

     // 获取用户等级
    public static function getLevelByUid($member_id)
    {
        $HubMemberLevel = new HubMemberLevel();
        $user = $HubMemberLevel::find()->where(['member_id' => $member_id])->asArray()->one();

        return $user;
    }

    // 获取系统所有的等级信息
    public static function getLevels()
    {
        $cacheKey = 'levelsinfo';
        if (Yii::$app->cache->get($cacheKey)) {
            return Yii::$app->cache->get($cacheKey);
        }

        $HubLevel = new MemberHubLevel();
        $list = $HubLevel->find()->with([
             'condition',
             'baseconf',
             'earningsconf',
             'gift' => function ($query) {
                 $query->select(['goods_id',
                'gift_price',
                'performance',
                'level_num',
                'cate', ]);
             },
         ])->orderBy('levelnum')->indexBy('levelnum')->asArray()->all();

        Yii::$app->cache->set($cacheKey, $list);

        return $list;
    }

    /**
     * 获取所有等级的配置信息 升级条件 分销收益阶梯 团队收益阶梯 function.
     *
     * @return [条件，收益]
     */
    public static function getLevelInfo($levelnum = 1, $type = 'condition')
    {
        $levels = self::getLevels();
        $level = $levels[$levelnum];
        switch ($type) {
            case 'condition':
                // 升级条件
                if (!empty($level['condition'])) {
                    foreach ($level['condition'] as $key => $value) {
                        $list[$value['levelnum']][$value['levelcnum']] = $value;
                    }
                }
            break;
            case 'baseconf':
                // 分销等级权益阶梯
                if (!empty($level['baseconf'])) {
                    foreach ($level['baseconf'] as $key => $value) {
                        $list[$value['levelcnum']][$value['levelnum']] = $value;
                    }
                }
            break;
            case 'earningsconf':
                // 等级权益阶梯
                if (!empty($level['earningsconf'])) {
                    foreach ($level['condition'] as $key => $value) {
                        $list[$value['levelcnum']][$value['levelnum']] = $value;
                    }
                }
            break;
            case 'gift':
                // 礼包
                if (!empty($level['gift'])) {
                    foreach ($level['gift'] as $key => $value) {
                        $list[$value['level_num']] = $value;
                    }
                }
            break;
            case 'all':
                // 礼包
                $list = $level;

            break;

            default:
                $list = $level;
                break;
        }

        return $list;
    }

    // 更新用户等级
    public static function upgradeLevelByUid($member_id, $levelnum, $timeRights = 0)
    {
        $HubMemberLevel = new HubMemberLevel();
        //是否已经有等级
        $ishave = $HubMemberLevel->find()->where(['member_id' => $member_id])->asArray()->one();

        loggingHelper::writeLog('diandi_hub', 'levelService', '是否是团队等级', $ishave);

        if (!empty($ishave)) {
            if ($ishave['level_num'] <= $levelnum) {
                loggingHelper::writeLog('diandi_hub', 'levelService', '更新权益等级', [
                    'level_num' => $levelnum,
                    'member_id' => $member_id,
                    'end_time' => $timeRights, //时间权益
                ]);

                // 更新自己
                $HubMemberLevel::updateAll([
                    'level_num' => $levelnum,
                    'end_time' => $timeRights, //时间权益
                ], ['member_id' => $member_id]);

                // 更新自己是父级的
                $HubMemberLevel::updateAll(['level_pid_num' => $levelnum], ['member_pid' => $member_id]);
            }
        } else {
            $data = [
                 'is_store' => 0,
                 'member_store_id' => '',
                 'member_id' => $member_id,
                 'member_pid' => 0,
                 'end_time' => $timeRights, //时间权益
                 'level_pid_num' => 0,
                 'level_num' => $levelnum,
                 'family' => '',
            ];

            loggingHelper::writeLog('diandi_hub', 'levelService', '首次写入', $data);

            if ($HubMemberLevel->load($data, '') && $HubMemberLevel->save()) {
                loggingHelper::writeLog('diandi_hub', 'levelService', '成为代理：', $member_id);
            } else {
                $msg = ErrorsHelper::getModelError($HubMemberLevel);
                loggingHelper::writeLog('diandi_hub', 'levelService', '成为代理错误：', $msg);
            }
        }
    }

    /**
     * 成为下级 function.
     *
     * @param [type] $member_id 推荐人id
     *
     * @return void
     */
    public static function siupChild($member_id)
    {
        loggingHelper::writeLog('diandi_hub', 'levelService', '开始记录发展下级', $member_id);

        if (empty($member_id)) {
            loggingHelper::writeLog('diandi_hub', 'levelService', '上级用户id为空');

            return ResultHelper::json(400, '扫码无效', []);
        }

        // 上级分销商信息
        $member_p = MemberService::getByUid($member_id);

        loggingHelper::writeLog('diandi_hub', 'levelService', '上级的分销商信息', $member_p);

        // 上级的上级
        // $member_p = MemberService::getByUid($member_id);

        // 我的信息
        $self_id = Yii::$app->user->identity->user_id;
        if ($member_id == $self_id) {
            return ResultHelper::json(401, '扫自己的二维码无效', []);
        }

        // 获取首码，扫码无效
        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        loggingHelper::writeLog('diandi_hub', 'levelService', '获取商户信息', $store);

        $conf = HubConfig::findOne(1);

        if ($conf['onecode'] == $self_id) {
            loggingHelper::writeLog('diandi_hub', 'levelService', '获取商户信息', '首码扫码无效');

            return ResultHelper::json(401, '首码扫码无效', []);
        }

        $member_s = MemberService::getByUid($self_id);
        loggingHelper::writeLog('diandi_hub', 'levelService', '扫码是否有效', $member_s);

        if ($member_s['is_level'] && !empty($member_s['member_id'])) {
            return ResultHelper::json(200, '重复扫码无效', []);
        }

        //如果是我的团队成员，扫码无效
        $myTeam = self::getLevelMid($self_id, 'child');
        loggingHelper::writeLog('diandi_hub', 'levelService', '我的团队', $myTeam);

        if (!empty($myTeam)) {
            loggingHelper::writeLog('diandi_hub', 'levelService', '我的团队用户id集合', $myTeam);

            if (in_array($member_id, $myTeam)) {
                loggingHelper::writeLog('diandi_hub', 'levelService', '我的团队用户', '不能扫我的团队成员');

                return ResultHelper::json(200, '不能扫我的团队成员', []);
            }
        }

        $DistributormemberLevel = new HubMemberLevel();
        if (intval($self_id) > 0) {
            $level_pid_num = empty($member_p['level_num']) ? 1 : intval($member_p['level_num']);

            $data = [
                'member_store_id' => '',
                'is_store' => 0,
                'member_id' => intval($self_id),
                'member_pid' => intval($member_id),
                'level_pid' => intval($member_p['level_id']),
                'level_id' => intval($member_s['level_id']),
                'level_pid_num' => $level_pid_num,
                'level_num' => 1,
                'family' => $member_p['family'] ? $member_id.','.$member_p['family'] : $member_id, //我的上级与上级的家族就是我的上级家族
            ];

            if ($DistributormemberLevel->load($data, '') && $DistributormemberLevel->save()) {
                // 处理我的家族的家族
                if (!empty($myTeam)) {
                    $member_id = ','.intval($member_id);
                    $DistributormemberLevel->tableName();
                    $tablename = Yii::$app->db->getTableSchema($DistributormemberLevel::tableName())->name;

                    $command = Yii::$app->db->createCommand("update {$tablename} set family=CONCAT(family,'{$member_id}') where member_id IN (".implode(',', $myTeam).')')->queryAll();
                }

                return ResultHelper::json(200, '添加等级关系成功', $data);
            } else {
                $msg = ErrorsHelper::getModelError($DistributormemberLevel);
                loggingHelper::writeLog('diandi_hub', 'levelService', '建立关系错误信息', $msg);

                return ResultHelper::json(400, $msg, []);
            }
        }
    }

    /**
     * 获取所有下级,按照分销等级返回 function.
     *
     * @param [type] $member_id 我的id
     * @param [type] $keywords  关键词检索，名字
     * @param int    $page
     * @param int    $pageSize
     *
     * @return array
     */
    public static function getAllChild($member_id, $keywords, $page = 1, $pageSize = 20)
    {
        $member_id = intval($member_id);
        $select = '*';
        $DistributormemberLevel = new HubMemberLevel();

        $bloc_id = Yii::$app->params['global_bloc_id'];
        $store_id = Yii::$app->params['global_store_id'];
        $where = [];
        if (!empty($bloc_id)) {
            $where['a.bloc_id'] = $bloc_id;
        }

        if (!empty($store_id)) {
            $where['a.store_id'] = $store_id;
        }

        loggingHelper::writeLog('diandi_hub', 'levelService', '获取我的下级查询条件', $where);

        $query = $DistributormemberLevel->find()
                ->alias('a')
                ->with(['member'])
                ->joinWith('wxappfans')
                ->where("FIND_IN_SET($member_id,family)")
                ->andFilterWhere(['like', ' `dd_wxapp_fans`.nickname', $keywords])
                ->andFilterWhere($where)
                ->orderBy('id');
        loggingHelper::writeLog('diandi_hub', 'levelService', '获取我的下级查询', $query->createCommand()->getRawSql());

        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        if ($page) {
            $lists = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        } else {
            $lists = $query->asArray()->all();
        }

        $level = self::getLevels();
        $levels = ArrayHelper::arrayKey($level, 'levelnum');

        // $tablename = $DistributormemberLevel::tableName();

        // $sql = "SELECT $select FROM $tablename where FIND_IN_SET($member_id,family) ORDER BY id desc";
        // $lists = Yii::$App->db->createCommand($sql)->queryAll();
        $logPath = Yii::getAlias('@runtime/diandi_hub/level/'.date('Y/md').'.log');

        foreach ($lists as $key => $value) {
            $value['create_time'] = date('Y-m-d H:i', $value['create_time']);
            if ($value['level_num']) {
                $value['level_name'] = $levels[$value['level_num']]['levelname'];
            } else {
                $value['level_name'] = '普通会员';
            }
            $familys = explode(',', $value['family']);
            $ks = array_search($member_id, $familys);
            FileHelper::writeLog($logPath, '等级划分家族'.json_encode($familys));
            FileHelper::writeLog($logPath, '等级划分'.json_encode($ks));

            $levelOne[$ks + 1][] = $value;
        }

        return  $levelOne;
    }

    /**
     * 根据分销等级获取下级,按照分页输出 function.
     *
     * @param [type] $member_id 我的id
     * @param [type] $keywords  关键词检索，名字
     * @param int    $page
     * @param int    $pageSize
     *
     * @return void
     */
    public static function getAllChildDis($member_id, $disLevel, $keywords, $page = 1, $pageSize = 20)
    {
        $member_id = intval($member_id);
        $select = '*';
        $DistributormemberLevel = new HubMemberLevel();

        $bloc_id = Yii::$app->params['global_bloc_id'];
        $store_id = Yii::$app->params['global_store_id'];
        $where = [];
        if (!empty($bloc_id)) {
            $where['a.bloc_id'] = $bloc_id;
        }

        if (!empty($store_id)) {
            $where['a.store_id'] = $store_id;
        }

        loggingHelper::writeLog('diandi_hub', 'levelService', '获取我的下级查询条件', $where);
        $disLevel = empty($disLevel) ? 1 : $disLevel;
        $query = $DistributormemberLevel->find()
                ->alias('a')
                ->with(['member'])
                ->joinWith('wechatfans as wxapp')
                ->where("FIND_IN_SET($member_id,family) = {$disLevel}")
                ->andFilterWhere(['like', 'wxapp.nickname', $keywords])
                ->andFilterWhere($where)
                ->orderBy('id');

        loggingHelper::writeLog('diandi_hub', 'levelService', '获取我的下级查询', $query->createCommand()->getRawSql());

        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $lists = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        $level = self::getLevels();
        $levels = ArrayHelper::arrayKey($level, 'levelnum');

        // $tablename = $DistributormemberLevel::tableName();

        // $sql = "SELECT $select FROM $tablename where FIND_IN_SET($member_id,family) ORDER BY id desc";
        // $lists = Yii::$App->db->createCommand($sql)->queryAll();
        $logPath = Yii::getAlias('@runtime/diandi_hub/level/'.date('Y/md').'.log');

        foreach ($lists as $key => &$value) {
            $value['create_time'] = date('Y-m-d H:i', $value['create_time']);
            if ($value['level_num']) {
                $value['level_name'] = $levels[$value['level_num']]['levelname'];
            } else {
                $value['level_name'] = '普通会员';
            }
        }

        return  $lists;
    }

    /**
     * 获取所有下级,按照分销等级返回 function.
     *
     * @param [type] $member_id 我的id
     * @param [type] $keywords  名字检索
     * @param int    $page
     * @param int    $pageSize
     *
     * @return void
     */
    public static function getAllChildBylevel($member_id, $keywords, $page = 1, $pageSize = 20)
    {
        $member_id = intval($member_id);
        $select = '*';
        $DistributormemberLevel = new HubMemberLevel();

        $bloc_id = Yii::$app->params['global_bloc_id'];
        $store_id = Yii::$app->params['global_store_id'];
        $where = [];
        if (!empty($bloc_id)) {
            $where['a.bloc_id'] = $bloc_id;
        }

        if (!empty($store_id)) {
            $where['a.store_id'] = $store_id;
        }

        loggingHelper::writeLog('diandi_hub', 'levelService', '获取我的下级查询条件', $where);

        $query = $DistributormemberLevel->find()
                 ->alias('a')
                 ->with(['member'])
                 ->joinWith('wxappfans')
                 ->where("FIND_IN_SET($member_id,family)")
                 ->andFilterWhere(['like', ' `dd_wxapp_fans`.nickname', $keywords])
                 ->andFilterWhere($where)
                 ->orderBy('id');

        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
             'totalCount' => $count,
             'pageSize' => $pageSize,
             'page' => $page - 1,
             // 'pageParam'=>'page'
         ]);

        if ($page) {
            $lists = $query->offset($pagination->offset)
             ->limit($pagination->limit)
             ->asArray()
             ->all();
        } else {
            $lists = $query->asArray()->all();
        }

        $level = self::getLevels();
        $levels = ArrayHelper::arrayKey($level, 'levelnum');

        // $tablename = $DistributormemberLevel::tableName();

        // $sql = "SELECT $select FROM $tablename where FIND_IN_SET($member_id,family) ORDER BY id desc";
        // $lists = Yii::$App->db->createCommand($sql)->queryAll();
        $logPath = Yii::getAlias('@runtime/diandi_hub/level/'.date('Y/md').'.log');

        foreach ($lists as $key => $value) {
            $value['create_time'] = date('Y-m-d H:i', $value['create_time']);
            if ($value['level_num']) {
                $value['level_name'] = $levels[$value['level_num']]['levelname'];
            } else {
                $value['level_name'] = '普通会员';
            }
            $familys = explode(',', $value['family']);
            $ks = array_search($member_id, $familys);
            FileHelper::writeLog($logPath, '等级划分家族'.json_encode($familys));
            FileHelper::writeLog($logPath, '等级划分'.json_encode($ks));

            $levelOne[$value['level_num']][] = $value;
        }

        return  $levelOne;
    }

    /**
     * 获取所有的上级 function.
     *
     * @param [type] $member_id
     *
     * @return array
     */
    public static function getAllParent($member_id)
    {
        $member_s = MemberService::getByUid($member_id);
        $familys = $member_s['family'];
        // 按照排序返回我的上级
        $orderby = [];
        if (!empty(trim($familys))) {
            $orderby = ['FIELD(member_id, '.$familys.')' => true];
        }

        // $where = ['IN', 'member_id', $familys];
        $where['member_id'] = explode(',', $familys);
        $DistributormemberLevel = new HubMemberLevel();
        $list = [];
        $lists = $DistributormemberLevel::find()->where($where)->orderBy($orderby)->asArray()->all();
        if (!empty($lists)) {
            $list = $lists;
        }

        return $list;
    }

    // 获取我上级的任意一个等级

    public static function getLevelParent($member_id, $levelnum)
    {
        $list = [];
        $list = self::getAllParent($member_id);
        $parent = [];
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                foreach ($value as $key => $item) {
                    if ($item['level_num'] == $levelnum) {
                        $parent[] = $value;
                    }
                }
            }
        }

        return $parent;
    }

    // 获取我下级的任意一个等级
    public static function getLevelChild($member_id, $levelnum)
    {
        $list = [];
        $list = self::getAllChild($member_id, '');

        $child = [];
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                foreach ($value as $key => $item) {
                    if ($item['level_num'] == $levelnum) {
                        $child[] = $value;
                    }
                }
            }
        }

        return $child;
    }

    /**
     * 获取我上级或下级的所有用户id.
     */
    public static function getLevelMid($member_id, $type)
    {
        loggingHelper::writeLog('diandi_hub', 'levelService', '团队数据', $member_id);

        loggingHelper::writeLog('diandi_hub', 'levelService', '团队数据类型', $type);

        if ($type == 'child') {
            $list = self::getAllChild($member_id, '');
        } elseif ($type == 'parent') {
            $list = self::getAllParent($member_id, '');
        }
        $levels = self::getLevels();

        loggingHelper::writeLog('diandi_hub', 'levelService', '团队数据', $list);
        loggingHelper::writeLog('diandi_hub', 'levelService', '等级数据', $levels);
        $mids = [];
        foreach ($levels as $level => $val) {
            if (!empty($list[$level])) {
                foreach ($list[$level] as $key => $value) {
                    $mids[] = $value['member_id'];
                }
            }
        }

        return $mids;
    }

    // 获取我上级的任意一个直推等级的人数

    public static function getLevelParentCountOrList($member_id, $levelnum)
    {
        $list = self::getAllParent($member_id);
        $level = [];
        $num = 0;
        foreach ($list as $key => $value) {
            if ($key == $levelnum && $value['member_pid'] == $member_id) {
                ++$num;
                $parent[] = $value;
            }
        }

        return [
                'num' => $num,
                'parent' => $parent,
            ];
    }

    // 获取我下级的任意一个直推等级的人数
    public static function getLevelChildCountOrList($member_id, $levelnum)
    {
        $list = self::getAllChild($member_id, '');
        $level = [];
        $num = 0;
        $child = [];
        loggingHelper::writeLog('diandi_hub', 'LevelService', '直推等级人数计算', [$member_id, $levelnum]);
        loggingHelper::writeLog('diandi_hub', 'LevelService', '直推等级人数计算', $list);
        if (!empty($list[1])) {
            foreach ($list[1] as $key => $value) {
                if ($value['level_num'] == $levelnum && $value['member_pid'] == $member_id) {
                    ++$num;
                    $child[] = $value;
                }
            }
        }

        return [
              'num' => $num,
              'child' => $child,
          ];
    }

    // 获取我下级的任意一个直推等级的总人数
    public static function getLevelChildCount($member_id, $levelnum)
    {
        $list = [];
        $list = self::getAllChild($member_id, '', 0);
        $level = [];
        $num = 0;
        $child = [];
        loggingHelper::writeLog('diandi_hub', 'LevelService', '直推等级人数计算', [$member_id, $levelnum]);
        loggingHelper::writeLog('diandi_hub', 'LevelService', '直推等级人数计算', $list);

        if (!empty($list)) {
            foreach ($list as $level => $value) {
                foreach ($value as $key => $val) {
                    if ($val['level_num'] == $levelnum) {
                        ++$num;
                    }
                }
            }
        }

        return $num;
    }

    // 获取我所有下级的总人数
    public static function getChildCount($member_id)
    {
        $child = self::getAllChild($member_id, '', 0);
        if (!empty($child)) {
            foreach ($child as $key => $value) {
                $num[] = count($value);
            }

            return array_sum($num);
        } else {
            return false;
        }
    }

    // 获取我的分销三级的一级人数，二级人数和总人数
    public static function getChildCountByDis($member_id)
    {
        $child = self::getAllChild($member_id, '', 0);
        if (!empty($child)) {
            $level1 = !empty($child[1]) ? count($child[1]) : 0;
            $level2 = !empty($child[2]) ? count($child[2]) : 0;

            return [
                'level1' => $level1,
                'level2' => $level2,
                'total' => $level1 + $level2,
            ];
        } else {
            return [
                'level1' => 0,
                'level2' => 0,
                'total' => 0,
            ];
        }
    }

    // 校验 用户升级权限
    public static function checkLevelUpdate($member_id)
    {
        $is_con = true;

        if (intval($member_id) == 0) {
            return false;
        }
        //我的等级信息
        $mylevel = self::getLevelByUid($member_id);
        // 基础条件校验
        $level_num_c = $mylevel['level_num'] + 1;

        // 达到最高级不能升级了
        $MaxLevelnum = MemberHubLevel::find()->max('levelnum');

        if ($level_num_c >= $MaxLevelnum) {
            return false;
        }

        $baseCondition = self::getLevelInfo($level_num_c, 'all');

        $mybasechild = self::getAllChild($member_id, '');
        $myLevelchild = self::getAllChildBylevel($member_id, '');

        loggingHelper::writeLog('diandi_hub', 'LevelService', '我的下级', $mybasechild);
        $total_num = self::getChildCount($member_id); //团队等级总人数
        loggingHelper::writeLog('diandi_hub', 'LevelService', '我的下级总人数', $total_num);

        $childMids = self::getLevelMid($member_id, 'child');
        $total_sale = TeamAccount::getMoneyCount($childMids); //团队等级总销售额
        loggingHelper::writeLog('diandi_hub', 'LevelService', '我的下级总销售额', $total_sale);

        $mychild2 = !empty($mybasechild[2]) ? $mybasechild[2] : [];
        $mychild1 = !empty($mybasechild[1]) ? $mybasechild[1] : [];
        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '分销一级和二级', [
            $mychild1, $mychild2,
        ]);

        $level2_num = count($mychild2); //分销二级人数
        $level1_num = count($mychild1); //分销一级人数
        $level1_sale = TeamAccount::getMoneyCount($mychild1); //	分销一级销售额
        $level2_sale = TeamAccount::getMoneyCount($mychild2); //	分销二级销售额
        $self_sale = LevelAccount::getSelfMoney($member_id); //自己消费

        loggingHelper::writeLog('diandi_hub', 'LevelService', '基础升级条件', $baseCondition);

        loggingHelper::writeLog('diandi_hub', 'LevelService', '升级基础条件校验', [
            'total_num' => $total_num,
            'total_sale' => $total_sale,
            'level2_num' => $level2_num,
            'level1_num' => $level1_num,
            'level1_sale' => $level1_sale,
            'level2_sale' => $level2_sale,
            'self_sale' => $self_sale,
        ]);

        if (
           ($total_num >= floatval($baseCondition['total_num']) &&
            $level2_num >= floatval($baseCondition['level2_num']) &&
            $level1_num >= floatval($baseCondition['level1_num']) &&
            $level1_sale >= floatval($baseCondition['level1_sale']) &&
            $level2_sale >= floatval($baseCondition['level2_sale']) &&
            $self_sale >= floatval($baseCondition['self_sale']))
            ||
            $total_sale >= floatval($baseCondition['total_sale'])
        ) {
            loggingHelper::writeLog('diandi_hub', 'LevelService', '基础升级条件校验通过');

            $levelnum = $mylevel['level_num'] + 1;
            // 获取我的等级的上一级对应的升级条件
            $conditions = self::getLevelInfo($levelnum, 'condition');
            loggingHelper::writeLog('diandi_hub', 'LevelService', '基础条件通过后的升级条件', $conditions);

            if (!empty($conditions[$levelnum])) {
                $is_con = true;
                foreach ($conditions[$levelnum] as $levelcnum => $condition) {
                    // 获取要发展等级的人数
                    loggingHelper::writeLog('diandi_hub', 'LevelService', '获取要发展等级的人数', $condition['levelc_num']);

                    if (!empty($condition['levelc_num'])) {
                        $levelc_num = $condition['levelcnum'];
                        // $levelc_num_Parent = self::getLevelParentCountOrList($member_id,$levelc_num);
                        $levelc_num_Child = self::getLevelChildCountOrList($member_id, $levelc_num);
                        $levelc_num_total = $levelc_num_Child['num'];
                        loggingHelper::writeLog('diandi_hub', 'LevelService', '人数升级条件',
                        [
                         'levelc_num' => $levelc_num,
                         'levelc_num_Child' => $levelc_num_Child,
                         'levelc_num_total' => $levelc_num_total,
                        ]);
                    }

                    // 获取要发展等级的消费额

                    if (!empty($condition['levelc_saletotal'])) {
                        // 目前都是空，所以统一为0
                        $levelc_saletotal = $condition['levelc_saletotal'] * self::$RadioSaletotal;
                        $saleCount = OrderAccount::getSaleCountBymid($member_id);
                        $levelc_saletotal_num = $saleCount['self_teamsale'];

                        loggingHelper::writeLog('diandi_hub', 'LevelService', '消费额升级条件', $levelc_saletotal_num);
                    }

                    loggingHelper::writeLog('diandi_hub', 'LevelService', '升级消费额', $condition['levelc_saletotal']);

                    loggingHelper::writeLog('diandi_hub', 'LevelService', '升级条件', $condition['condition']);

                    loggingHelper::writeLog('diandi_hub', 'LevelService', '消费金额系数', $levelc_saletotal);
                    $levelc_saletotal_num = floatval($levelc_saletotal_num);
                    // 看两者关系 只有有一个不满足就跳出校验
                    if ($condition['condition'] == 0) {
                        // 并且
                        if ($levelc_num_total >= floatval($levelc_num) && $levelc_saletotal_num >= floatval($levelc_saletotal)) {
                            $is_con = true;

                            return $is_con;
                            break;
                        } else {
                            loggingHelper::writeLog('diandi_hub', 'LevelService', '不能升级，校验完成0',
                            [$levelc_num_total, $levelc_num, $levelc_saletotal_num, $levelc_saletotal]);

                            $is_con = false;

                            return $is_con;
                        }
                    } else {
                        // 或者
                        if ($levelc_num_total >= floatval($levelc_num) || $levelc_saletotal_num >= floatval($levelc_saletotal)) {
                            $is_con = true;

                            return $is_con;

                            break;
                        } else {
                            loggingHelper::writeLog('diandi_hub', 'LevelService', '不能升级，校验完成1',
                            [$levelc_num_total, $levelc_num, $levelc_saletotal_num, $levelc_saletotal]);
                            $is_con = false;

                            return $is_con;
                        }
                    }
                }
            }
        }

        return $is_con;
    }

    // 校验基础条件
    // 发展那个等级多少人与消费额或者的关系

    // 校验 分销权限 +团队奖励权限
    public static function checkLevelDis($member_id, $levelNum)
    {
        //我的等级信息
        $mylevel = self::getLevelByUid($member_id);

        loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '分销奖励比例核算开始，我的等级信息', $mylevel);

        // 第一步 找我的所有上级
        $Parent = levelService::getAllParent($member_id, '');

        loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '我的父级所有人', $Parent);

        // 第二步 过滤掉普通等级 输出三级分销
        $num = 0;
        $earnings = [];

        foreach ($Parent as $key => $value) {
            if ($value['level_num'] <= 1) {
                unset($Parent[$key]);
            } else {
                ++$num;

                if ($num <= 3) {
                    $ParentFamly[$value['level_num']][$num] = $value;

                    loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '当前分销等级：'.$num, $value);

                    $baseCondition = self::getLevelInfo($value['level_num'], 'baseconf');

                    loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '当前分销等级奖励配置：', [
                         'baseCondition' => $baseCondition,
                         'levelNum' => $levelNum,
                        ]);

                    if (!empty($baseCondition[$levelNum])) {
                        foreach ($baseCondition[$levelNum] as $levelcnum => $condition) {
                            //第三步 根据团队等级与分销等级确定消费奖金
                            loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '结果关联', $levelNum);
                            loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '结果关联', $condition);

                            switch ($num) {
                                   case 1:
                                        $earnings[$value['member_id']] = floatval($condition['level1_radio']);
                                       break;
                                    case 2:
                                        $earnings[$value['member_id']] = floatval($condition['level2_radio']);

                                    break;
                                    case 3:
                                        $earnings[$value['member_id']] = floatval($condition['level3_radio']);
                                        break;
                                   default:
                                        // 默认不奖励
                                        $earnings[$value['member_id']] = 0;
                                       break;
                               }
                        }
                    }
                }
            }
        }

        loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '分销奖励比例核算结果', $earnings);

        return  $earnings;
    }

    /**
     * 校验团队收益权益 function
     * 购买人购买看团队中的人员，看他们的团队等级，如果有团队等级，看发展人数，确定奖励比例.
     *
     * @param [type] $member_id
     *                          levelNum 发展的等级
     *
     * @return array
     */
    public static function checkTeamDis($member_id, $levelNum)
    {
        $earnings = [];
        $earningsLevel = [];
        //我的等级信息
        $mylevel = self::getLevelByUid($member_id);

        loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '分销奖励比例核算开始，我的等级信息', [
           'mylevel' => $mylevel,
           'levelNum' => $levelNum,
        ]);

        // 获取我发展的等级人数
        $totalLevel = self::getLevelChildCount($member_id, $levelNum);
        loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '我发展的该等级下级人数', $totalLevel);

        // 第一步 找我的所有上级
        $ParentLists = levelService::getAllParent($member_id, '');

        loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '我的父级所有人', $ParentLists);

        // 第二步 过滤掉普通等级 和比我低的等级
        $earnings = [];
        $ParentList = [];
        //   获取所有的团队收益配置
        if (!empty($ParentLists)) {
            foreach ($ParentLists as $key => $value) {
                if ($value['level_num'] <= 1 || $value['level_num'] < $levelNum) {
                    unset($Parent[$key]);
                } else {
                    $ParentList[] = $value;
                }
            }
            loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '团队父级过滤后', $ParentList);
        }

        $confAll = LevelButionLevelEarningsConf::find()->asArray()->all();

        loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '团队所有配置', $confAll);

        loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '我发展了该等级的人数', $totalLevel);

        if (!empty($confAll)) {
            foreach ($confAll as $key => $value) {
                loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '配置过滤条件', [
                    $value['levelcnum'],
                     $levelNum,
                      $value['levelc_num'],
                       $totalLevel,
                ]);

                if ($value['levelcnum'] == $levelNum && $totalLevel >= $value['levelc_num']) {
                    $earningsConf[$levelNum][$value['levelnum']] = $value['earnings'];
                }
            }
            loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '配置过滤后', $earningsConf);
        }

        // 过滤没有奖励的用户
        foreach ($ParentList as $key => $value) {
            if (!empty($earningsConf[$levelNum][$value['level_num']])) {
                $earnings[$value['member_id']] = $earningsConf[$levelNum][$value['level_num']];
            }
        }

        loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '团队奖励没有奖励的用户过滤掉', $earnings);

        // 极差计算
        if (!empty($earnings)) {
            $mid = array_keys($earnings);
            loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '团队用户id', [
                $mid,
            ]);
            $num = 0;
            foreach ($earnings as $key => $value) {
                $num = $num + 1;
                $pMid = $mid[$num - 2]; //我上一个人
                loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '团队奖励极差计算', [
                   '所有人' => $mid,
                   '第几个人' => $num,
                   '上一个人' => $pMid,
                   '上一个人的参数' => $earnings[$pMid],
                   '我是谁' => $key,
                   '我的比例' => $value,
                ]);

                $earningsLevel[$key] = ($value * 100 - $earnings[$pMid] * 100) / 100;
            }
        }

        loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '团队奖励比例结果', $earningsLevel);

        return  $earningsLevel;
    }

    public static function getParentFirst($member_id, $num = 0)
    {
        $ParentLists = self::getAllParent($member_id);

        if (!empty($ParentLists)) {
            foreach ($ParentLists as $key => $value) {
                if ($value['level_num'] == 1) {
                    $ordinary[] = $value;
                } elseif ($value['level_num'] > 1) {
                    $ParentList[] = $value;
                }
            }
            loggingHelper::writeLog('diandi_hub', 'checkLevelDis', '团队父级过滤后', $ParentList);
        }

        return [
            'ordinary' => $ordinary[$num], //普通上级
            'ParentList' => $ParentList[$num], //非普通上级
        ];
    }

    // 校验店铺流水收益

    public static function checkStoreDis($store_member_id, $member_id, $goodsMoney, $is_self = true)
    {
        loggingHelper::writeLog('diandi_hub', 'checkStoreDis', '校验店铺流水收益', [
            'store_member_id' => $store_member_id,
            'member_id' => $member_id,
            'money' => $goodsMoney,
            'is_self' => $is_self,
        ]);

        $totalMoney = $goodsMoney * 0.02;

        $earningsLevel = [];

        $levels = self::getLevels();

        //我的等级信息
        $mylevel = self::getLevelByUid($member_id);

        if ($is_self) {
            //    自营，找下单人的上级
            // 第一步 找我的所有上级
            $ParentLists = levelService::getAllParent($member_id, '');
        } else {
            // 非自营，找店主的上级
            $ParentLists = levelService::getAllParent($store_member_id, '');
        }

        loggingHelper::writeLog('diandi_hub', 'checkStoreDis', '我的父级所有人', $ParentLists);

        //   获取所有的团队收益配置
        if (!empty($ParentLists)) {
            foreach ($ParentLists as $key => $value) {
                // 遇到开店的推荐人的人跳出,非自营，开店推荐人截至，自营把钱分完
                if ($value['member_id'] == $store_member_id && !$is_self) {
                    break;
                }

                if ($value['level_num'] <= 1) {
                    unset($Parent[$key]);
                } else {
                    // 讲流水比例写入数据中
                    $value['water_ratio'] = floatval($levels[$value['level_num']]['water_ratio']);
                    $ParentList[$value['member_id']] = $value;
                }
            }
            loggingHelper::writeLog('diandi_hub', 'checkStoreDis', '团队父级过滤后', $ParentList);
        }

        loggingHelper::writeLog('diandi_hub', 'checkStoreDis', '过滤后', $ParentList);

        // 极差计算
        if (!empty($ParentList)) {
            $num = 0;
            $money = 0;
            $mids = array_keys($ParentList);
            foreach ($ParentList as $mid => $value) {
                $num = $num + 1;
                $pMid = $mids[$num - 2]; //我上一个人

                loggingHelper::writeLog('diandi_hub', 'checkStoreDis', '店铺流水极差计算', [
                    '我的id' => $mid,
                    '我的比例' => $value['water_ratio'],
                    '上级的id' => $pMid,
                    '上级的比例' => $ParentList[$pMid]['water_ratio'],
                ]);

                $parentRadio = !empty($ParentList[$pMid]) ? $ParentList[$pMid]['water_ratio'] : 0;
                $member_money = ($value['water_ratio'] - $parentRadio) * $goodsMoney;
                $money += $member_money;
                if ($money > $totalMoney) {
                    break;
                }
                $earningsLevel[$mid] = floor(strval(($member_money) * 100)) / 100;
            }
        }

        loggingHelper::writeLog('diandi_hub', 'checkStoreDis', '店铺流水比例结果', $earningsLevel);

        return  $earningsLevel;
    }
}
