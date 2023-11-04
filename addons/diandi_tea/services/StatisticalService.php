<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-22 11:34:09
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-11 10:05:33
 */

namespace addons\diandi_tea\services;

use addons\diandi_tea\models\order\TeaOrderList;
use addons\diandi_tea\models\order\TeaRechargeList;
use api\models\DdMember;
use common\services\BaseService;

class StatisticalService extends BaseService
{
    //统计
    public static function statisticalList()
   {
        $store_id =\Yii::$app->request->input('store_id',0);
        $bloc_id =\Yii::$app->request->input('bloc_id',0);
        $whereRecharge = ['store_id' => $store_id, 'bloc_id' => $bloc_id, 'status' => 2];
        $whereResults = ['store_id' => $store_id, 'bloc_id' => $bloc_id, 'status' => 3];
        $timestamp = strtotime(date(time()));
        $firstday = date('Y-m-01 00:00:00', strtotime(date('Y', $timestamp).'-'.(date('m', $timestamp) - 1).'-01'));
        $lastday = date('Y-m-d 24:00:00', strtotime("$firstday +1 month -1 day"));
        //订单现金销售额  
        $list['order_money_month'] = (float)TeaOrderList::find()->where($whereResults)->andWhere(['pay_type' => 1])->andWhere(['between', 'pay_time', $firstday, $lastday])->sum('real_pay');
        $list['order_money'] = (float)TeaOrderList::find()->where($whereResults)->andWhere(['pay_type' => 1])->sum('real_pay');

        //订单余额销售额
        $list['order_balance_month'] = (float)TeaOrderList::find()->where($whereResults)->andWhere(['pay_type' => 2])->andWhere(['between', 'pay_time', $firstday, $lastday])->sum('real_pay');
        $list['order_balance'] = (float)TeaOrderList::find()->where($whereResults)->andWhere(['pay_type' => 2])->sum('real_pay');

        $list['all_moeny'] = $list['order_money'] + $list['order_balance'];
        //充值
        $list['recharge_month'] = (float)TeaRechargeList::find()->where($whereRecharge)->andWhere(['between', 'pay_time', $firstday, $lastday])->sum('price');
        $list['recharge'] = (float)TeaRechargeList::find()->where($whereRecharge)->sum('price');

        //包间统计
        $hourseMonth = TeaOrderList::find()
                        ->alias('a')
                        ->join('LEFT JOIN', 'dd_diandi_tea_hourse b', 'a.hourse_id = b.id')
                        ->select(['SUM(a.real_pay) AS real_pay','b.name'])
                        ->where(['a.store_id' => $store_id, 'a.bloc_id' => $bloc_id, 'a.status' => 3])
                        ->andWhere(['between', 'a.pay_time', $firstday, $lastday])
                        ->groupBy('a.hourse_id')
                        ->asArray()
                        ->all();
        $hourse = TeaOrderList::find()
                        ->alias('a')
                        ->join('LEFT JOIN', 'dd_diandi_tea_hourse b', 'a.hourse_id = b.id')
                        ->select(['SUM(a.real_pay) AS real_pay','b.name'])
                        ->where(['a.store_id' => $store_id, 'a.bloc_id' => $bloc_id, 'a.status' => 3])
                        ->groupBy('a.hourse_id')
                        ->asArray()
                        ->all();
    
        foreach ($hourse as $key => $value) {
            $list['hourse'][$key] = $value['name'];
            $list['hourse_money'][$key] = (float)$value['real_pay'];
            if(is_array($hourseMonth)){
                foreach ($hourseMonth as $val) {
                    if($val['name'] == $value['name']){
                        $hourse_month = (float)$val['real_pay'];
                        break;
                    }
                }
            }else{
                $hourse_month = '';
            }
            
            $list['hourse_money_month'][$key] = $hourse_month;
        }
        //套餐统计
        $setMealMonth = TeaOrderList::find()
                        ->alias('a')
                        ->join('LEFT JOIN', 'dd_diandi_tea_set_meal b', 'a.set_meal_id = b.id')
                        ->select(['SUM(a.real_pay) AS real_pay','b.title'])
                        ->where(['a.store_id' => $store_id, 'a.bloc_id' => $bloc_id, 'a.status' => 3])
                        ->andWhere(['between', 'a.pay_time', $firstday, $lastday])
                        ->groupBy('a.set_meal_id')
                        ->asArray()
                        ->all();
        $setMeal = TeaOrderList::find()
                        ->alias('a')
                        ->join('LEFT JOIN', 'dd_diandi_tea_set_meal b', 'a.set_meal_id = b.id')
                        ->select(['SUM(a.real_pay) AS real_pay','b.title'])
                        ->where(['a.store_id' => $store_id, 'a.bloc_id' => $bloc_id, 'a.status' => 3])
                        ->groupBy('a.set_meal_id')
                        ->asArray()
                        ->all();
        foreach ($setMeal as $key => $value) {
            $list['meal'][$key] = $value['title'];
            $list['meal_money'][$key] = (float)$value['real_pay'];
            if(is_array($setMealMonth)){
                foreach ($setMealMonth as $val) {
                    if($val['title'] == $value['title']){
                        $meal_month = (float)$val['real_pay'];
                        break;
                    }
                }
            }else{
                $meal_month = '';
            }
            
            $list['meal_money_month'][$key] = $meal_month;
        }

        //总销量按月分组
        $sales = TeaOrderList::find()
        ->select(["COUNT(*) AS num","SUM(real_pay) AS price", "FROM_UNIXTIME(UNIX_TIMESTAMP(create_time),'%Y-%m') as month"])
        ->where($whereResults)
        ->orderBy('month')
        ->asArray()
        ->all();

        foreach ($sales as $key => $value) {
            $list['sales']['month'][$key] = $value['month'];
            $list['sales']['num'][$key] = $value['num'];
            $list['sales']['price'][$key] = $value['price'];
        }

        $list['vip'] = DdMember::find()->where(['level' => 2,'store_id' => $store_id, 'bloc_id' => $bloc_id])->count();
        //$list['sales'] = $sales;
        

        
        $list = json_encode($list);
        $list = str_ireplace('null', 0, $list);
        return json_decode($list,true);
    }
}
