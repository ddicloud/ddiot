<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-29 01:20:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-01 20:31:45
 */

namespace common\plugins\diandi_hub\services\account;

class GiftAccount extends OrderAccount
{
    //根据商品id获取礼包信息
    public static function getLevelByGoodsId($goods_id)
    {
    }

    /**
     * 分销订单日志写入.
     */
    public static function GiftdisLog()
    {
    }

    // 团队日志
    public static function GiftTeamLog()
    {
    }

    // 资金变动日志
    public static function GiftMoneyLog()
    {
    }

    // 分销佣金总和
    public static function disLevelCount($gift_id)
    {
    }
}
