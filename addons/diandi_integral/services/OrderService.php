<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 23:31:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-19 10:17:30
 */

namespace addons\diandi_integral\services;

use addons\diandi_integral\models\enums\OrderStatus;
use addons\diandi_integral\models\enums\PayStatus;
use addons\diandi_integral\models\IntegralGoods;
use addons\diandi_integral\models\IntegralGoodsSpec;
use addons\diandi_integral\models\IntegralOrder;
use addons\diandi_integral\models\IntegralOrderAddress;
use addons\diandi_integral\models\IntegralOrderGoods;
use addons\diandi_integral\models\IntegralSpecValue;
use admin\modules\officialaccount\models\DdWechatFans;
use common\components\printcloud\Feie;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\helpers\StringHelper;
use common\models\DdCorePaylog;
use common\models\DdRegion;
use common\models\DdUserAddress;
use common\services\BaseService;
use GuzzleHttp\Client;
use Yii;
use yii\data\Pagination;
use yii\helpers\Json;

class OrderService extends BaseService
{
    // 创建订单

    /**
     * Undocumented function.
     *
     * @param [type] $user_id       用户id
     * @param [type] $total_price   订单总额
     * @param [type] $express_price 运费
     * @param [type] $express_type  地址类型 1配送点 2自由地址
     * @param [type] $name          姓名
     * @param [type] $phone         电话
     *
     * @return array
     */
    public static function creategoodsorder($user_id, $goods_id, $goods_num, $total_price, $express_price, $express_type, $address_id, $remark, $name, $phone, $delivery_time, $spec_id = '', $isMoney = 1): array
    {
        if (!$total_price) {
            return ResultHelper::json(400, 'total_price 必须');
        }

        if (!isset($express_price)) {
            return ResultHelper::json(400, 'express_price 必须');
        }

        if (!$address_id) {
            return ResultHelper::json(400, 'address_id 必须');
        }

        $express_price = $express_type == 0 ? $express_price : 0;
        $areas = DdUserAddress::findOne(['address_id' => $address_id]);
        $region_id = $areas['city_id'];
        $order_id = 0;
        $good = GoodsService::getOrderDetail($goods_id, $goods_num, $spec_id, $express_type, $region_id);

        $goods = $good['goods'];
        $order_body = $goods[0]['goods']['goods_name'];
        // 兑换该商品的积分
        $pay_integral = $goods[0]['goods']['goods_integral'];
        // 订单基础信息写入
        $orderbase = [
            'order_no' => self::CreateOrderno(), //订单编号
            'pay_integral' => $pay_integral,
            'total_price' => number_format($total_price, 2, '.', ''), //付款总额
            'pay_price' => $total_price + $express_price, //订单金额
            'pay_status' => PayStatus::NONPAYMENT, //支付状态
            'is_money' => (int)$isMoney, //支付状态
            'remark' => (string)$remark, //订单备注
            'order_body' => $order_body,
            // "pay_time" => $order['pay_time'], //付款时间
            'express_price' => $express_price, //运费
            // "express_company" => $order['express_company'], //快递公司
            // "express_no" => $order['express_no'], //快递号码
            // "delivery_status" => $order['delivery_status'], //发货状态
            // "delivery_time" => $order['delivery_time'], //发货时间
            // "receipt_status" => $order['receipt_status'], //收货状态
            // "receipt_time" => $order['receipt_time'], //收货时间
            'order_status' => OrderStatus::NONPAYMENT, //订单状态
            // "transaction_id" => $order['transaction_id'], //微信支付订单号
            'user_id' => $user_id, //会员id
        ];
        $transaction = IntegralOrder::getDb()->beginTransaction();
        try {
            $DdOrder = new IntegralOrder();
            $goods_specs = [];
            $orderbase_body = [];
            if ($DdOrder->load($orderbase, '') && $DdOrder->save()) {
                $order_id = $DdOrder->order_id;
                // 订单商品
                if ($goods) {
                    // 保存订单商品信息
                    $DdOrderGoods = new  IntegralOrderGoods();
                    $DdGoodsSpec = new IntegralGoodsSpec();
                    $goods_ids = array_column($goods, 'goods_id');
                    $specAll = $DdGoodsSpec::find()->where(['goods_id' => $goods_ids])->with(['goodsSpecRel'])
                        ->asArray()
                        ->all();

                    foreach ($specAll as $key => $value) {
                        $goods_specs[$value['goods_id']][$value['spec_sku_id']] = $value;
                    }
                    $store_id = Yii::$app->params['store_id'];
                    $specValueAll = IntegralSpecValue::find()->indexBy('spec_value_id')->asArray()->all();
                    loggingHelper::writeLog('diandi_hotel', 'creategoodsorder', '订单兑换商品列表', $goods);
                    foreach ($goods as $items) {
                        $item = $items['goods'];

                        $orderbase_body[] = $item['goods_name'];
                        $goods_spec = $goods_specs[$goods_id][$spec_id] ?? [];
                        $goods_price = $items['goods_price'];
                        $goods_integral = $items['goods_integral'];
                        $total_num = (int)$items['number'];
                        $goods_weight = empty($spec_id) ? $item['goods_weight'] : $goods_spec['goods_weight'];
                        $goods_no = '';
                        if (empty($spec_id)) {
                            $goods_no = isset($item['goods_no'])??'';
                        } else {
                            $goods_no = isset($goods_spec['goods_no'])??'';
                        }

                        $total_price = $goods_price * $total_num;

                        if(isset($items['spec_id'])){
                            $goods_spec_id = isset($goods_specs[$item['goods_id']][$items['spec_id']]['goods_spec_id'])??0;
                        }else{
                            $goods_spec_id = 0;
                        }


                        $spec_sku_id = isset($goods_specs[$goods_id][$spec_id]['spec_sku_id'])??0 ;

                        $order_goods = [
                            'goods_id' => $item['goods_id'],
                            'goods_name' => $item['goods_name'],
                            'thumb' => $item['thumb'],
                            'deduct_stock_type' => $item['deduct_stock_type'],
                            'stock_up' => $item['deduct_stock_type'] == 10 ? 1 : 0,
                            'spec_type' => empty($spec_id) ? 1 : 0,
                            'goods_attr' =>$spec_sku_id? $specValueAll[$spec_sku_id]['spec_value']:'',
                            'content' => $item['content'] ? $item['content'] : 'rr',
                            'goods_no' => (string) $goods_no,
                            'goods_price' => $goods_price,
                            'goods_integral' => $goods_integral,
                            'goods_weight' => $goods_weight,
                            'total_num' => $total_num,
                            'total_price' => $total_price,
                            'order_id' => $order_id,
                            'user_id' => $user_id,
                        ];

                        if ($spec_id) {
                            $order_goods['spec_sku_id'] = isset($goods_specs[$goods_id][$spec_id]['spec_sku_id'])??'';
                            $order_goods['goods_spec_id'] = isset($goods_specs[$goods_id][$spec_id]['goods_spec_id'])??'';
                        } else {
                            $order_goods['spec_sku_id'] = (string) $spec_sku_id;
                            $order_goods['goods_spec_id'] = (string) $goods_spec_id;
                        }

                        $_DdOrderGoods = clone $DdOrderGoods;
                        $_DdOrderGoods->setAttributes($order_goods);
                        if (!$_DdOrderGoods->save()) {
                            $msg = ErrorsHelper::getModelError($_DdOrderGoods);
                            return ResultHelper::json(400, $msg);
                        }
                    }
                    // 校验库存并操作库存
                    self::stockReduce($goods);
                }
                $DdOrderAddress = new IntegralOrderAddress();
                // 0 外卖配送-取用户的地址  1上门取货-取配送点

                $order_address = [
                    'name' => $areas['name'],
                    'phone' => $areas['phone'],
                    'province_id' => $areas['province_id'],
                    'city_id' => $areas['city_id'],
                    'region_id' => $areas['region_id'],
                    'detail' => $areas['detail'],
                    'delivery_time' => $delivery_time,
                    'order_id' => $order_id,
                    'user_id' => $user_id,
                ];
                $DdOrderAddress->load($order_address, '');

                $DdOrderAddress->save($order_address);
                // 订单收货地址
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }
        $orderbase['order_id'] = $order_id;
        $orderbase['body'] = $orderbase_body[0];
        // 写入订单支付日志
        self::paylog($orderbase, $order_id);

        return $orderbase;
    }

    // 减少库存

    /**
     * @throws \Exception
     */
    public static function stockReduce($goods): void
    {
        $path = Yii::getAlias('@runtime/diandi_integral/log/order.log');
        if (!empty($goods) && is_array($goods)) {
            FileHelper::writeLog($path, '下单商品库存处理' . json_encode($goods));
            $DdGoods = new IntegralGoods();
            // 实时获取当前商品库存
            $goods_ids = array_column($goods, 'goods_id');
            // 获取所有的商品库存
            $stocks = $DdGoods->find()
                ->where(['goods_id' => $goods_ids])
                ->select(['stock', 'goods_id'])
                ->indexBy('goods_id')
                ->asArray()
                ->all();
            $DdGoodsSpec = new IntegralGoodsSpec();

            foreach ($goods as $item) {
                $_DdGoods = clone $DdGoods;
                $_DdGoodsSpec = clone $DdGoodsSpec;
                // 更新库存
                if ($item['goods']['deduct_stock_type'] == 10) {
                    // 实时库存
                    $stock = $stocks[$item['goods_id']]['stock'];
                    if ($item['number'] > $stock) {
                        throw new \Exception($item['goods_name'] . '库存不足');
                    }
                    $res = $_DdGoods::updateAllCounters(['stock' => -$item['number']], ['goods_id' => $item['goods_id']]);
                    FileHelper::writeLog($path, '下单商品库存处理结果' . json_encode($res));
                    FileHelper::writeLog($path, '更新数据' . json_encode([['stock' => -$item['number']], ['goods_id' => $item['goods_id']]]));
                    if (!empty($item['spec_id'])) {
                        $_DdGoodsSpec::updateAllCounters(
                            [
                                'stock_num' => -$item['number'],
                                'sales_initial' => +$item['total_num'],
                                'sales_actual' => +$item['total_num'],
                            ],
                            [
                                'goods_id' => $item['goods_id'],
                                'spec_sku_id' => $item['spec_id'],
                            ]
                        );
                    }
                }
            }
        }
    }

    /**
     * 订单操作.
     *
     * @param [type] $order_id
     * @param [type] $ctype
     *
     * @return array
     */
    public static function confirmOrder($order_id, $ctype): array
    {
        $massage = '操作成功';
        switch ($ctype) {
            case 'qxdd':
                // 取消订单
                $res = IntegralOrder::updateAll(['order_status' => OrderStatus::getValueByName('已取消')], ['order_id' => $order_id]);
                $massage = '取消成功';
                break;
            case 'qrfh':
                // 确认发货
                $res = IntegralOrder::updateAll([
                    'order_status' => OrderStatus::getValueByName('已发货'),
                    'delivery_status' => 1,
                    'delivery_time' => time(),
                ], ['order_id' => $order_id]);
                $massage = '兑换成功';
                break;
            case 'qrsh':
                // 确认收货
                $res = IntegralOrder::updateAll([
                    'order_status' => OrderStatus::getValueByName('已收货'),
                    'receipt_status' => 1,
                    'receipt_time' => time(),
                ], ['order_id' => $order_id]);
                $massage = '确认收货成功';
                break;
            case 'scdd':
                // 删除订单
                $DdOrder = new IntegralOrder();
                $DdOrderGoods = new IntegralOrderGoods();
                $DdOrderAddress = new IntegralOrderAddress();

                $DdOrder::deleteAll(['order_id' => $order_id]);
                $DdOrderGoods::deleteAll(['order_id' => $order_id]);
                $DdOrderAddress::deleteAll(['order_id' => $order_id]);
                $massage = '删除成功';

                break;
            case 'qrfk':
                // 确认付款
                $logPath = Yii::getAlias('@runtime/diandi_integral/order.log');
                $orders = IntegralOrder::findOne(['order_id' => $order_id]);
                IntegralOrder::updateAll([
                    'order_status' => OrderStatus::ACCOUNTPAID,
                    'pay_status' => 1,
                    'pay_time' => time(),
                ], ['order_id' => $order_id]);

                $massage = '付款成功';
                break;
        }
        $orderinfo = self::detail($order_id);

        return ResultHelper::json(200, $massage, $orderinfo);
    }

    public static function exchangeCredit($order_id, $total_fee): array
    {
        $detail = self::detail($order_id);
        $member_id = $detail['user_id'];

        loggingHelper::writeLog('diandi_distribution', 'exchangeCredit', '积分扣除开始', $detail);

        if ($detail['is_money'] == 1) {
            return ResultHelper::json(400, '已经处理过');
        }

        $orderGoods = $detail['goods'];

        loggingHelper::writeLog('diandi_distribution', 'exchangeCredit', '订单商品', $orderGoods);

        $addlogUrl = '/api/diandi_distribution/account/addlog';

        loggingHelper::writeLog('diandi_distribution', 'exchangeCredit', '写入日志记录接口地址', $addlogUrl);

        foreach ($orderGoods as $key => $value) {
            $goods_integral = $value['goods_integral'];
            $exchange_status = $value['exchange_status'];
            if (intval($exchange_status) == 0) {
                $client = new Client([
                    // Base URI is used with relative requests
                    'base_uri' => Yii::$app->request->hostInfo,
                    // You can set any number of default request options.
                    'timeout' => 60,
                ]);

                $change_type = 8;

                $order_type = 6;

                $goods_type = 4;

                $account_type = 1;

                $data = [
                    'member_id' => $member_id,
                    'order_id' => $order_id,
                    'money' => -$goods_integral,
                    'order_goods_id' => $value['order_goods_id'],
                    'change_type' => $change_type,
                    'account_type' => $account_type,
                    'order_type' => $order_type,
                    'goods_type' => $goods_type,
                    'order_price' => $goods_integral,
                    'goods_id' => $value['goods_id'],
                    'goods_price' => $goods_integral,
                    'performance' => 0,
                ];

                loggingHelper::writeLog('diandi_distribution', 'exchangeCredit', '写入日志记录数据', $data);

                $response = $client->request('POST', $addlogUrl, [
                    'form_params' => $data,
                ]);
                $body = $response->getBody(); //获取响应体，对象
                $bodyStr = (string)$body; //对象转字串

                $res = json_decode($bodyStr, true);

                $log_account_id = $res['data']['log_account_id'];

                loggingHelper::writeLog('diandi_distribution', 'exchangeCredit', '写入日志记录结果', $res);

                $Res = Yii::$app->service->commonMemberService->updateAccount($member_id, 'user_integral', -$goods_integral, $log_account_id);
                Yii::$app->service->commonMemberService->updateAccount($member_id, 'credit1', -$goods_integral, $log_account_id);

                loggingHelper::writeLog('diandi_distribution', 'exchangeCredit', '用户资产更新结果', $Res);

                if ($Res) {
                    // 更新用户余额

                    Yii::$app->service->commonMemberService->updateAccount($member_id, 'user_money', -$value['goods_price'], $log_account_id);

                    IntegralOrderGoods::updateAll([
                        'exchange_status' => 1,
                    ], [
                        'order_id' => $order_id,
                        'goods_id' => $value['goods_id'],
                    ]);

                    IntegralOrder::updateAll([
                        'is_money' => 1,
                        'pay_status' => 1,
                        'order_status' => 1,
                        'pay_time' => time(),
                        'pay_price' => $goods_integral,
                        // 'total_price' => $Res['account']['user_integral'],
                    ], [
                        'order_id' => $order_id,
                    ]);
                    IntegralGoods::updateAllCounters([
                        'sales_actual' => 1,
                    ], ['goods_id' => $value['goods_id']]);

                    return ResultHelper::json(200, '变更余额成功');
                } else {

                    return ResultHelper::json(400, '变更余额失败');
                }
            }
        }
        return ResultHelper::json(400, '变更余额失败');

    }

    //积分兑换明细
    public static function exchangelist($member_id)
    {
        $list = IntegralOrder::find()
            ->alias('order')
            ->join('LEFT JOIN', 'dd_diandi_integral_order_goods goods', 'goods.order_id = order.order_id')
            ->where(['order.user_id' => $member_id, 'order.pay_status' => 1])
            ->select(['order.*', "FROM_UNIXTIME(order.pay_time,'%Y-%m') as month", 'goods.thumb'])
            ->asArray()
            ->all();

        foreach ($list as $key => &$val) {
            $val['pay_time'] = date('Y-m-d H:i:s', $val['pay_time']);
            $val['pay_price'] = round($val['pay_price']);
            $val['total_price'] = round($val['total_price']);
        }

        return $list;
    }

    // 订单列表
    public static function list($user_id, $order_status, $pageSize)
    {
        $page = Yii::$app->request->get('page');

        $where = []; //初始化条件数组
        $where['user_id'] = $user_id;
        if (is_numeric($order_status) && $order_status > -1) {
            $where['order_status'] = $order_status;
        }

        $bloc_id = Yii::$app->params['bloc_id'];
        $store_id = Yii::$app->params['store_id'];

        if ($bloc_id) {
            $where['bloc_id'] = $bloc_id;
            $condition['bloc_id'] = $bloc_id;
        }

        if ($store_id) {
            $where['store_id'] = $store_id;
            $condition['store_id'] = $store_id;
        }

        // 创建一个 DB 查询来获得所有
        $query = IntegralOrder::find()->where($where)->andWhere(['!=', 'order_status', 10])->with([
            'goods' => function ($query) use ($condition) {
                $query->where($condition);
            },
            'store',
        ])->orderBy('create_time desc');

        // 得到订单的总数（但是还没有从数据库取数据）
        $count = $query->count();
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
        ]);
        $list = $query->offset($pagination->offset)
            ->asArray()
            ->limit($pagination->limit)
            ->all();

        foreach ($list as &$item) {
            $item['create_time'] = date('m-d H:i:s', $item['create_time']);
            $item['status_label'] = OrderStatus::getLabel($item['order_status']);
        }

        return $list;
    }

    // 订单详情
    public static function detail($id)
    {
        $DdOrder = new IntegralOrder();
        $detail = $DdOrder->find()
            ->with(['goods', 'address'])
            ->where(['order_id' => $id])
            ->asArray()->one();
        $region = DdRegion::find()->where(['id' => $detail['address']['region_id']])->select('merger_name')->one();
        $detail['address']['address_detail'] = $region['merger_name']??'';
        $detail['address']['address_id'] = [$detail['address']['province_id'], $detail['address']['city_id'], $detail['address']['region_id']];
        // var_dump($detail['goods']);die;
        //    if(is_array(array_column($detail['goods'])){
        //         $total_nums = array_column($detail['goods'], 'total_num');
        //    }
        // $total_nums = array_column($detail['goods'], 'total_num');
        //   $detail['goods_total'] = array_sum($total_nums);
        //   $detail['goods_total'] = $detail['goods']['total_num'];

        $detail['pay_time'] = date('Y-m-d H:i:s', $detail['pay_time']);
        $detail['receipt_time'] = date('Y-m-d H:i:s', $detail['receipt_time']);
        $detail['create_time'] = date('Y-m-d H:i:s', $detail['create_time']);

        $detail['status_label'] = OrderStatus::getLabel($detail['order_status']);

        return $detail;
    }

    // 订单详情
    public static function details($ids)
    {
        $DdOrder = new IntegralOrder();
        $details = $DdOrder->find()
            ->with(['goods', 'address'])
            ->where(['order_id' => $ids])
            ->asArray()->all();

        foreach ($details as $key => $value) {
            $region_ids[] = $value['address']['region_id'];
        }
        $regions = DdRegion::find()->where(['id' => $region_ids])->select(['id', 'merger_name'])
            ->indexBy('id')
            ->all();

        foreach ($details as $key => &$detail) {
            $region_id = $value['address']['region_id'];
            $region = $regions[$region_id];
            $detail['address']['address_detail'] = $region['merger_name'];

            $total_nums = array_column($detail['goods'], 'total_num');
            $detail['goods_total'] = array_sum($total_nums);

            $detail['pay_time'] = date('Y-m-d H:i:s', $detail['pay_time']);
            $detail['receipt_time'] = date('Y-m-d H:i:s', $detail['receipt_time']);
            $detail['create_time'] = date('Y-m-d H:i:s', $detail['create_time']);
        }

        return $details;
    }

    // 物流跟踪
    public function logistics()
    {
    }

    // 写入订单支付日志
    public static function paylog($order, $order_id): bool
    {
        $user_id = $order['user_id'];
        $fans = DdWechatFans::getFansByUid($user_id);
        $openid = $fans['openid']??'';
        $data = [
            'type' => 'wechat',
            'openid' => $openid,
            'member_id' => $user_id,
            'uniontid' => $order['order_no'],
            'fee' => $order['total_price'],
            'status' => 0,
            'module' => 'diandi_integral',
            'tag' => '小程序下单',
        ];
        $DdCorePaylog = new DdCorePaylog();
        $DdCorePaylog->load($data, '');
        return $DdCorePaylog->save();
    }

    // 生成订单编号
    public static function CreateOrderno()
    {
        return date('Ymd') . substr(implode('', array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    // 订单打印
    public static function cloudPrint($order_ids = [])
   {

        $logPath = Yii::getAlias('@runtime/diandi_integral/print/log/' . date('Y/m/d') . '/wechat.log');

        $list = self::details($order_ids);

        $info = Yii::$app->settings->getAllBySection('DiandiShopStroe');
        $info['logo'] = ImageHelper::tomedia($info['logo']);
        $info['banner'] = ImageHelper::tomedia($info['banner']);
        $wxappName = Yii::$app->settings->get('Wxapp', 'name');
        $wxappHeadimg = Yii::$app->settings->get('Wxapp', 'headimg');

        $Lodop_ip = Yii::$app->settings->get('DiandiShopStroe', 'Lodop_ip');

        $Feie = new Feie();
        $DdOrder = new IntegralOrder();
        foreach ($list as $key => $value) {
            $storeInfo = Yii::$app->service->commonGlobalsService->getStoreDetail($value['store_id']);
            $conf = Yii::$app->service->commonGlobalsService->getConf($value['bloc_id']);

            FileHelper::writeLog($logPath, '打印参数' . Json::encode($storeInfo) . '/store_id:' . Yii::$app->params['store_id']);
            FileHelper::writeLog($logPath, '打印参数公司' . Json::encode($storeInfo) . '/store_id:' . Yii::$app->params['bloc_id']);

            $codeUrl = $conf['wxapp']['codeUrl'];
            FileHelper::writeLog($logPath, 'codeUrl' . Json::encode($codeUrl));

            if (!empty($value['print_id'])) {
                continue;
            }

            $_DdOrder = clone $DdOrder;
            $order_id = $value['order_id'];
            $pay_status_str = $value['pay_status'] == 0 ? '未付款' : '已付款';
            $address = $value['address']['address_detail'] . $value['address']['detail'];
            $mobile = $value['address']['phone'];
            $create_name = $value['address']['name'];
            $remark = $value['remark'] ? $value['remark'] : '无';
            $content[$order_id] = "<CB>{$wxappName}</CB><BR>";
            $create_time = $value['create_time'];
            $content[$order_id] .= '<C>空港食品&物流公司联合打造</C><BR>';

            $content[$order_id] .= '名称　　　　　 单价  数量 金额<BR>';

            $content[$order_id] .= '--------------------------------<BR>';
            foreach ($value['goods'] as $k => $goods) {
                if (!empty($goods['goods_attr'])) {
                    $goods_name_strs = '[' . $goods['goods_attr'] . ']' . $goods['goods_name'];
                } else {
                    $goods_name_strs = $goods['goods_name'];
                }

                loggingHelper::writeLog('diandi_integral', 'cloudPrint', '商品名称字符', $goods_name_strs);

                $goods_names = self::mbStrSplit($goods_name_strs, 7);
                loggingHelper::writeLog('diandi_integral', 'cloudPrint', '打印商品名称', $goods_names);
                $goods_name = $goods_names[0];
                $total_num = str_pad($goods['total_num'], 4, ' ', STR_PAD_RIGHT);
                $goods_price = str_pad($goods['goods_price'], 5, ' ', STR_PAD_RIGHT);
                $total_price = str_pad($goods['total_price'], 4, ' ', STR_PAD_RIGHT);
                $content[$order_id] .= "{$goods_name} {$goods_price} {$total_num}  {$total_price}<BR>";

                if (count($goods_names) > 1) {
                    foreach ($goods_names as $gkey => $gvalue) {
                        if ($gkey > 0) {
                            $content[$order_id] .= "{$gvalue} <BR>";
                        }
                    }
                }
            }
            $content[$order_id] .= '--------------------------------<BR>';
            $content[$order_id] .= '<C>付款信息</C><BR>';
            $content[$order_id] .= "是否付款：{$pay_status_str}<BR>";
            $content[$order_id] .= "合计：{$value['pay_price']}(含运费{$value['express_price']})元<BR>";

            $content[$order_id] .= '--------------------------------<BR>';
            $content[$order_id] .= '<C>送货信息</C><BR>';
            $content[$order_id] .= "订单备注：{$remark}<BR>";

            $content[$order_id] .= '--------------------------------<BR>';
            $content[$order_id] .= "送货地点：{$address}<BR>";
            $content[$order_id] .= "联 系 人：{$create_name}<BR>";
            $content[$order_id] .= "联系电话：{$mobile}<BR>";
            $content[$order_id] .= "下单时间：{$create_time}<BR>";
            $content[$order_id] .= "送达时间：{$value['address']['delivery_time']}<BR>";
            $content[$order_id] .= '--------------------------------<BR><BR>';

            $content[$order_id] .= "<QR>{$codeUrl}</QR>"; //把二维码字符串用标签套上即可自动生成二维码
            loggingHelper::writeLog('diandi_integral', 'cloudPrint', '打印内容', $content[$order_id]);

            $res[$order_id] = $Feie::printMsg($content[$order_id], $storeInfo['printNum']);

            loggingHelper::writeLog('diandi_integral', 'cloudPrint', '打印结果', $res[$order_id]);

            $Res[$order_id] = json_decode($res[$order_id], true);
            $_DdOrder->updateAll(['print_id' => $Res[$order_id]['data']], ['order_id' => $order_id]);
        }

        return $Res;
    }

    public static function mbStrSplit($string, $len = 1)
    {
        $lengs = StringHelper::strLength($string);
        $l = ceil($lengs / $len);
        for ($i = 1; $i <= $l; ++$i) {
            $str = StringHelper::cut_str($string, $len, '');
            $string = str_replace($str, '', $string);
            $array[] = $str;
        }

        return $array;
    }
}
