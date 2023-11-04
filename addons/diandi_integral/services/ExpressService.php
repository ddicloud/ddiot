<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-15 22:13:50
 */

namespace addons\diandi_integral\services;

use addons\diandi_distribution\models\enums\ExpressStatus;
use addons\diandi_distribution\models\express\DistributionExpressTemplate;
use addons\diandi_distribution\models\express\DistributionExpressTemplateArea;
use addons\diandi_integral\models\IntegralGoods;
use common\helpers\loggingHelper;
use common\helpers\MapHelper;
use common\models\DdRegion;
use common\services\BaseService;
use Yii;

/**
 * Class AddressController.
 */
class ExpressService extends BaseService
{
    /**
     * 运费计算
     */
    public static function getExpressPrice($express_type,$store_id,$region_id,$goods_ids,$goods_nums)
    {
        // region_id 为空使用用户默认地址
        loggingHelper::writeLog('diandi_integral','ExpressService', '开始计算运费',[
            $express_type,$store_id,$region_id,$goods_ids,$goods_nums
        ]);
     
        if(empty(intval($region_id))){
            loggingHelper::writeLog('diandi_integral','ExpressService', '使用默认地址',[]);
         
            $user_id = Yii::$app->user->identity->member_id??0;
            $Region = AddressService::getDefault($user_id);
            loggingHelper::writeLog('diandi_integral','ExpressService', '默认地址',$Region);
            if(empty($Region)){
                loggingHelper::writeLog('diandi_integral','ExpressService', '没有默认地址不计算',[]);

                return 0;
            }
            $region_id = $Region['city']['id'];

            loggingHelper::writeLog('diandi_integral','ExpressService', '默认地址编号',$region_id);

        }
        
        loggingHelper::writeLog('diandi_integral','ExpressService', '快递类型',$express_type);

        
        if($express_type==ExpressStatus::getValueByName('自提')){
           return 0; 
        }else{
            
            $storeInfo = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
            
            // 配送距离    
            $distance       =   $storeInfo['distance'];

            // 获取地址对应的经纬度
            $region = DdRegion::findOne($region_id);

            $lng1 = $region['lng'];
            $lat1 = $region['lat'];
            
            $lng_lat = json_decode($storeInfo['lng_lat'],true);
          
            
            $lng2 = $lng_lat['lng'];
            $lat2 = $lng_lat['lat'];
    
            $data = MapHelper::getdistance($lng1, $lat1, $lng2, $lat2);
            
            // 配送时间
            $sendtime       =   $storeInfo['sendtime'];
            // 起送价格
            $startingPrice  =   $storeInfo['startingPrice'];
            // 基础运费
            $shippingDees   =   $storeInfo['shippingDees'];

           
            $goodsAll = IntegralGoods::find()
            ->where(['goods_id'=>$goods_ids])
            ->select(['goods_id','goods_weight','express_template_id','express_type','volume'])
            ->indexBy('goods_id')
            ->asArray()
            ->all();
            
            loggingHelper::writeLog('diandi_integral','ExpressService', '所有商品快递配送参数',$goodsAll);
            
            
            $express_template_ids = array_column($goodsAll,'express_template_id'); 
            loggingHelper::writeLog('diandi_integral','ExpressService', '所有商品快递模板id',$express_template_ids);
        
            $expresAll = DistributionExpressTemplateArea::find()
                    ->where(['region_id'=>$region_id,'template_id'=>$express_template_ids])
                    ->indexBy('template_id')
                    ->asArray()
                    ->all();
            loggingHelper::writeLog('diandi_integral','ExpressService', '所有商品快递模板参数',$expresAll);

            $expresDefault_id =  DistributionExpressTemplate::find()
                    ->where(['is_default'=>1])
                    ->select('id')
                    ->column();
            loggingHelper::writeLog('diandi_integral','ExpressService', '默认模板id',$expresDefault_id);
            
            $expresDefault = DistributionExpressTemplateArea::find()
                    ->where(['region_id'=>$region_id,'template_id'=>$expresDefault_id])
                    ->asArray()
                    ->one();
            
            loggingHelper::writeLog('diandi_integral','ExpressService', '默认模板',$expresDefault);
                    
            $moneyTotal = 0;
            foreach ($goodsAll as $key => $value) {
                // 当前运费模板
                $goods_id  = $value['goods_id'];

                if(!empty($value['express_template_id'])){
                    $expressOne = $expresAll[$value['express_template_id']];                    
                }else{
                    $expressOne = $expresDefault; 
                }

                loggingHelper::writeLog('diandi_integral','ExpressService', '快递参数',[
                    'expressOne' =>$expressOne,
                    'goods_id' =>$goods_id,
                    'express_type'=>$value['express_type'],
                    'goods_nums'=>$goods_nums[$goods_id]
                ]);

               
                $express_type = !empty($value['express_type'])?$value['express_type']:1; 
                // 1重量2体积3计件
                switch ($value['express_type']) {
                    case 1:
                        $baseprice = self::getBasePrice(($value['goods_weight']/1000)*$goods_nums[$goods_id],$expressOne['weight_snum'],$expressOne['weight_xnum'],$expressOne['weight_sprice'],$expressOne['weight_xprice']);
                        break;
                    case 2:
                        $baseprice = self::getBasePrice($value['volume']*$goods_nums[$goods_id],$expressOne['volume_snum'],$expressOne['volume_xnum'],$expressOne['volume_sprice'],$expressOne['volume_xprice']);
                        break;
                
                    case 3:
                        $baseprice = self::getBasePrice($goods_nums[$goods_id],$expressOne['bynum_snum'],$expressOne['bynum_xnum'],$expressOne['bynum_sprice'],$expressOne['bynum_xprice']);
                        loggingHelper::writeLog('diandi_integral','ExpressService', '运费结果',$baseprice);
                        
                        break;
                    
                    default:
                        $baseprice = self::getBasePrice(($value['goods_weight']/1000)*$goods_nums[$goods_id],$expressOne['weight_snum'],$expressOne['weight_xnum'],$expressOne['weight_sprice'],$expressOne['weight_xprice']);
                        break;
                }
                 
                 $moneyTotal +=$baseprice;
            }
            
            loggingHelper::writeLog('diandi_integral','ExpressService', '运费结果组成',[
                $shippingDees,$moneyTotal
            ]);

           return floatval($shippingDees) + floatval($moneyTotal);
            
        }
    }

    // 计算费用
    public static function getBasePrice($goods_option,$snum,$xnum,$sprice,$xprice)
    {                                        
        loggingHelper::writeLog('diandi_integral','ExpressService', '计算费用',[$goods_option,$snum,$xnum,$sprice,$xprice]);
        
        $goods_option   =   floatval($goods_option);
        $snum           =   floatval($snum);
        $sprice         =   floatval($sprice);
        $xprice         =   floatval($xprice);
        
        if(empty($snum)){
            return 0;
        }
        
        if($goods_option>$snum){
            return $sprice+(($goods_option-$snum)/$xnum)*$xprice;
        }else{
            return $sprice;
        }
    }

 
}