<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-24 11:27:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-28 19:58:39
 */

namespace addons\diandi_tea\services;

use addons\diandi_tea\models\config\TeaGlobalConfig;
use addons\diandi_tea\models\config\TeaHourse;
use addons\diandi_tea\models\config\TeaSlide;
use addons\diandi_tea\models\enums\HoursesStatus;
use addons\diandi_tea\models\marketing\TeaCoupon;
use addons\diandi_tea\models\marketing\TeaMemberCoupon;
use addons\diandi_tea\models\marketing\TeaRecharge;
use addons\diandi_tea\models\order\TeaOrderList;
use common\helpers\ArrayHelper;
use common\helpers\ImageHelper;
use common\helpers\StringHelper;
use common\services\BaseService;
use Exception;
use Yii;
use yii\data\Pagination;

class IndexService extends BaseService
{
    /**
     * @param int $pageSize
     * @param int $page
     * @param int $store_id
     * @return array
     * @throws Exception
     */
    public static function top(int $pageSize = 20, int $page = 1,int $store_id = 0): array
   {

        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        //获取体验券
        $experience_coupon = TeaCoupon::find()
            ->where(['store_id' =>\Yii::$app->request->input('store_id',0), 'type' => 5])->asArray()->one();


        if ($experience_coupon) {
            $experience_coupon['use_start'] = date('H:i', strtotime($experience_coupon['use_start']));
            $experience_coupon['use_end'] = date('H:i', strtotime($experience_coupon['use_end']));
            $experience_coupon['enable_start'] = date('Y-m-d H:i', strtotime($experience_coupon['enable_start']));
            $experience_coupon['enable_end'] = date('Y-m-d', strtotime($experience_coupon['enable_end']));
            $experience_coupon['price'] = number_format($experience_coupon['price'],2,'.','');
            $experience_coupon['background'] = ImageHelper::tomedia($experience_coupon['background']);
            //体验时间
            //$experience_coupon['experience_time'] = round((strtotime($experience_coupon['use_end']) - strtotime($experience_coupon['use_start'])) / 3600, 1);
            $experience_coupon['day'] = StringHelper::currency_format((strtotime($experience_coupon['enable_end']) - strtotime($experience_coupon['enable_start'])) / 86400);
            $member_id = Yii::$app->user->identity->member_id??0;
            if ($member_id) {
                $member_coupon = TeaMemberCoupon::find()
                ->where(['member_id' => $member_id, 'coupon_id' => $experience_coupon['id']])
                ->select('use_num')
                ->asArray()->one();
                if ($member_coupon) {
                    if ($member_coupon['use_num'] == 1) {
                        $experience_coupon = [];
                    } else {
                        $experience_coupon['is_have'] = true;
                    }
                } else {
                    $experience_coupon['is_have'] = false;
                }
            } else {
                //$experience_coupon = [];
                $experience_coupon['is_have'] = false;
            }
        }

        //底部充值活动列表
        $recharge = TeaRecharge::find()
                ->where(['store_id' =>\Yii::$app->request->input('store_id',0)])
                ->select(['price', 'give_money', 'give_coupon_ids', 'id'])
                ->limit(3)
                ->asArray()
                ->all();
        //var_dump($recharge);die;
        $arr = [];
        foreach ($recharge as &$value) {
            if ($value['give_coupon_ids']) {
                $arr = explode(',', $value['give_coupon_ids']);
            }
            $value['price'] = StringHelper::currency_format($value['price']);
            $value['give_money'] = StringHelper::currency_format($value['give_money']);

            $value['give_coupon_money'] = StringHelper::currency_format(TeaCoupon::find()->where(['id' => $arr])->sum('price'));
            $value['time'] = TeaCoupon::find()->where(['id' => $arr])->sum('max_time');
        }
        // var_dump($recharge);die;
        $store['rechargeList'] = ArrayHelper::arraySort($recharge, 'price');

        //商户简介
        $store['store_introduce'] = TeaGlobalConfig::find()
                ->select('store_introduce')
                ->where(['store_id' =>\Yii::$app->request->input('store_id',0)])
                ->scalar();
        $store['emperience_coupon'] = $experience_coupon;

        $slideInfo = TeaSlide::find()->where(['store_id' =>\Yii::$app->request->input('store_id',0)])
                ->select(['slide', 'type'])->asArray()->all();
        $store_slide = [];
        $adv_slide = [];
        foreach ($slideInfo as $v) {
            $slide = ImageHelper::tomedia($v['slide']);
            if ($v['type'] == 1) {
                $store_slide[] = $slide;
            } elseif ($v['type'] == 2) {
                $adv_slide[] = $slide;
            }
        }

        $store['store_slide'] = $store_slide;
        $store['adv_slide'] = $adv_slide;

        //$data = Yii::$App->request->post();
        //商家下包间列表
        $query = TeaHourse::find();
        $count = $query->count();
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            'pageParam' => 'page',
        ]);

        $list = $query->where(['store_id' => $store_id])->offset($pagination->offset)
        ->limit($pagination->limit)->orderBy('cprice DESC')->asArray()->all();
        //$list = array_reverse($list);

        $HourseStatus = HoursesStatus::listData();

        //上个月包间销量
        $timestamp = strtotime(date(time()));
        $firstday = date('Y-m-01 00:00:00', strtotime(date('Y', $timestamp).'-'.(date('m', $timestamp) - 1).'-01'));
        $lastday = date('Y-m-d 24:00:00', strtotime("$firstday +1 month -1 day"));

        $month_nums = TeaOrderList::find()
        ->where(['status' => 3])
        ->andWhere(['between', 'pay_time', $firstday, $lastday])
        ->indexBy('id')
        ->all();

        $month_num = [];

        unset($value);
        foreach ($month_nums as $key => $value) {
            ++$month_num[$key];
        }

        foreach ($list as &$value) {
            $value['max_num'] = $value['persons'];
            $value['month_num'] = $month_num[$value['id']] ?? random_int(100, 200);
            $value['picture'] = ImageHelper::tomedia($value['thumb']);
            $value['status_str'] = $HourseStatus[$value['status']];
        }
        //$store['hourse_list'] = ArrayHelper::arraySort($list, 'max_num');
        $store['hourse_list'] = $list;
//        $store['address'] = '西安市高新区'.$store['address'];

        return [
            'list' => $store,
            'total' => (int) $count,
            'pageSize' => $pageSize,
            'page' => $page,
        ];
    }
}
