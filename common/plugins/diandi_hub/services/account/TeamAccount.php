<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-29 01:20:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-03 09:51:11
 */

namespace common\plugins\diandi_hub\services\account;

use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\order\HubOrderGoods;
use common\helpers\loggingHelper;

class TeamAccount extends OrderAccount
{
    // 团队等级快照
    public static function addteamLevel()
    {
        // dd_diandi_hub_account_agent
    }

    // 计算团队等级的人与我的分销关系
    public static function getMyteamLevel()
    {
    }

    // 查询订单对应的团队
    public static function getTeamToLevel()
    {
    }

    // 计算订单对应的团队奖励
    public static function getTeamMoney($goods_id, $goods_spec_id, $team_level1, $team_level2, $team_level3)
    {
    }

    // 计算团队等级对应的奖励比例
    public static function getTeamLevelRadio()
    {
    }

    // 团队分销佣金总和

    public static function disLevelCount()
    {
    }

    // 团队销售额总和

    public static function getMoneyCount($childMids)
    {
        loggingHelper::writeLog('diandi_hub', 'LevelAccount', '我的团队消用后ids',$childMids);

        
        // 我的团队购买的所有礼包对应的业绩和
        $order_type = OrderTypeStatus::getValueByName('尊享订单');
        $goods_type = GoodsTypeStatus::getValueByName('礼包商品');

        $total = HubOrderGoods::find()->where(['IN','user_id',$childMids])->sum('performance');
        
        loggingHelper::writeLog('diandi_hub', 'LevelAccount', '我的团队消费总额计算'.$member_id,$total);
        
        return floatval($total);
    }

    public static function getAgentCount()
    {
        // code...
    }
}
