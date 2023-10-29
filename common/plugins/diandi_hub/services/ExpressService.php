<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 17:53:23
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\enums\ExpressStatus;
use common\plugins\diandi_hub\models\express\HubExpressTemplate;
use common\plugins\diandi_hub\models\express\HubExpressTemplateArea;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\helpers\loggingHelper;
use common\services\BaseService;

/**
 * Class AddressController.
 */
class ExpressService extends BaseService
{
    /**
     * 运费计算.
     */
    public static function getExpressPrice($user_id, $express_type, $region_id, $goods_ids, $goods_nums, $express_id)
    {
        // region_id 为空使用用户默认地址
        loggingHelper::writeLog('diandi_hub', 'ExpressService', '开始计算运费', [
            $express_type, $region_id, $goods_ids, $goods_nums,
        ]);

        if (empty(intval($region_id))) {
            loggingHelper::writeLog('diandi_hub', 'ExpressService', '使用默认地址', []);

            $Region = AddressService::getDefault($user_id);
            loggingHelper::writeLog('diandi_hub', 'ExpressService', '默认地址', $Region);
            if (empty($Region)) {
                loggingHelper::writeLog('diandi_hub', 'ExpressService', '没有默认地址不计算', []);

                return 0;
            }
            $region_id = $Region['city']['id'];

            loggingHelper::writeLog('diandi_hub', 'ExpressService', '默认地址编号', $region_id);
        }

        loggingHelper::writeLog('diandi_hub', 'ExpressService', '快递类型', $express_type);

        if ($express_type == ExpressStatus::getValueByName('自提')) {
            return 0;
        } else {
            $goodsAll = HubGoodsBaseGoods::find()
            ->where(['goods_id' => $goods_ids])
            ->select(['goods_id', 'goods_weight', 'express_template_id', 'express_type', 'volume', 'exemption', 'exemption_type'])
            ->indexBy('goods_id')
            ->asArray()
            ->all();

            loggingHelper::writeLog('diandi_hub', 'ExpressService', '所有商品快递配送参数', $goodsAll);

            $express_template_ids = array_column($goodsAll, 'express_template_id');
            loggingHelper::writeLog('diandi_hub', 'ExpressService', '所有商品快递模板id', $express_template_ids);

            $expresAll = HubExpressTemplateArea::find()
                    ->where(['region_id' => $region_id, 'template_id' => $express_template_ids])
                    ->indexBy('template_id')
                    ->asArray()
                    ->all();
            loggingHelper::writeLog('diandi_hub', 'ExpressService', '所有商品快递模板参数', $expresAll);

            $expresDefault_id = HubExpressTemplate::find()
                    ->where(['is_default' => 1])
                    ->select('id')
                    ->column();
            loggingHelper::writeLog('diandi_hub', 'ExpressService', '默认模板id', $expresDefault_id);

            $expresDefault = HubExpressTemplateArea::find()
                    ->where(['region_id' => $region_id, 'template_id' => $expresDefault_id])
                    ->asArray()
                    ->one();

            loggingHelper::writeLog('diandi_hub', 'ExpressService', '默认模板', $expresDefault);

            $moneyTotal = 0;
            foreach ($goodsAll as $key => $value) {
                // 当前运费模板
                $goods_id = $value['goods_id'];

                if (!empty($value['express_template_id'])) {
                    $expressOne = $expresAll[$value['express_template_id']];
                } else {
                    $expressOne = $expresDefault;
                }

                loggingHelper::writeLog('diandi_hub', 'ExpressService', '快递参数', [
                    'expressOne' => $expressOne,
                    'goods_id' => $goods_id,
                    'exemption' => floatval($value['exemption']), //商品是否有包邮设置
                    'express_type' => $value['express_type'],
                    'goods_nums' => $goods_nums[$goods_id],
                ]);

                //1元2件 'exemption','exemption_type'
                if (floatval($value['exemption']) > 0) {
                    //  商品自身有包邮规则
                    if ($value['exemption_type'] == 1 && $value['goods_price'] * $goods_nums[$goods_id] >= $value['exemption']) {
                        // 按多少元包邮
                        $baseprice = 0;

                        return $baseprice;
                        break;
                    } elseif ($value['exemption_type'] == 2 && $goods_nums[$goods_id] >= $value['exemption']) {
                        // 按多少件包邮
                        $baseprice = 0;

                        return $baseprice;
                        break;
                    }
                }

                //  用户的包邮政策都不符合重新计算
                $express_type = !empty($value['express_type']) ? $value['express_type'] : 1;
                // 1重量2体积3计件
                switch ($value['express_type']) {
                    case 1:
                        $baseprice = self::getBasePrice(($value['goods_weight'] / 1000) * $goods_nums[$goods_id], $expressOne['weight_snum'], $expressOne['weight_xnum'], $expressOne['weight_sprice'], $expressOne['weight_xprice']);
                        break;
                    case 2:
                        $baseprice = self::getBasePrice($value['volume'] * $goods_nums[$goods_id], $expressOne['volume_snum'], $expressOne['volume_xnum'], $expressOne['volume_sprice'], $expressOne['volume_xprice']);
                        break;

                    case 3:
                        $baseprice = self::getBasePrice($goods_nums[$goods_id], $expressOne['bynum_snum'], $expressOne['bynum_xnum'], $expressOne['bynum_sprice'], $expressOne['bynum_xprice']);
                        loggingHelper::writeLog('diandi_hub', 'ExpressService', '运费结果', $baseprice);

                        break;

                    default:
                        $baseprice = self::getBasePrice(($value['goods_weight'] / 1000) * $goods_nums[$goods_id], $expressOne['weight_snum'], $expressOne['weight_xnum'], $expressOne['weight_sprice'], $expressOne['weight_xprice']);
                        break;
                }

                $moneyTotal += $baseprice;
            }

            loggingHelper::writeLog('diandi_hub', 'ExpressService', '运费结果组成', [
               $moneyTotal,
            ]);

            return floatval($moneyTotal);
        }
    }

    // 计算费用
    public static function getBasePrice($goods_option, $snum, $xnum, $sprice, $xprice)
    {
        loggingHelper::writeLog('diandi_hub', 'ExpressService', '计算费用', [$goods_option, $snum, $xnum, $sprice, $xprice]);

        $goods_option = floatval($goods_option);
        $snum = floatval($snum);
        $sprice = floatval($sprice);
        $xprice = floatval($xprice);

        if (empty($snum)) {
            return 0;
        }

        if ($goods_option > $snum) {
            return $sprice + (($goods_option - $snum) / $xnum) * $xprice;
        } else {
            return $sprice;
        }
    }

    public static function getTemplateAreasByRegion($region_id, $express_template_ids)
    {
        // 看地区匹配的运费模板
    }
}
