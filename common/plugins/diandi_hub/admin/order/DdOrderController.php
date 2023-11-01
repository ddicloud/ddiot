<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 00:17:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-04 18:01:37
 */

namespace common\plugins\diandi_hub\admin\order;

use common\plugins\diandi_hub\models\enums\DeliveryStatus;
use common\plugins\diandi_hub\models\enums\OrderStatus;
use common\plugins\diandi_hub\models\enums\OrderStatus as EnumsOrderStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\enums\PayStatus;
use common\plugins\diandi_hub\models\enums\PayTypeStatus;
use common\plugins\diandi_hub\models\enums\ReceiptStatus;
use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\plugins\diandi_hub\models\order\HubOrderAddress;
use common\plugins\diandi_hub\models\order\HubOrderGoods;
use common\plugins\diandi_hub\models\Searchs\order\HubOrderSearch as OrderHubOrderSearch;
use common\plugins\diandi_hub\services\OrderService;
use admin\controllers\AController;
use common\helpers\DateHelper;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\LevelTplHelper;
use common\helpers\phpexcel\ExportModel;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * DdOrderController implements the CRUD actions for DdOrder model.
 */
class DdOrderController extends AController
{
    public string $modelSearchName = 'HubOrderSearch';

    public function actions()
    {
        $actions = parent::actions();
        $actions['get-region'] = [
            'class' => \diandi\region\RegionAction::class,
            'model' => DdRegion::class,
        ];

        return $actions;
    }

    /**
     * Lists all DdOrder models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $lists['all'] = '全部';
        $list = EnumsOrderStatus::listData();
        foreach ($list as $key => $value) {
            $lists[$key] = $value;
        }
        foreach ($lists as $key => $item) {
            $titles[] = $item;
            $urls[] = 'index';
            $options[] = ['HubOrderSearch[order_status]' => $key];
        }

        $searchModel = new OrderHubOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // ExportModel::widget([
        //     'models' => DdOrder::find()->all(),  // 必须
        //     'asAttachment' => true,  // 默认值, 可忽略
        // ]);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'titles' => $titles,
            'urls' => $urls,
            'options' => $options,
        ]);
    }

    /**
     * Displays a single DdOrder model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $detail = OrderService::detail($id);
        $address = HubOrderAddress::findOne(['order_id' => $id]);
        $region = new DdRegion();
        $Helper = new LevelTplHelper([
            'pid' => 'pid',
            'cid' => 'id',
            'title' => 'name',
            'model' => $region,
            'id' => 'id',
        ]);
        $express = HubExpressCompany::find()->where(['status' => 1])->asArray()->all();

        $model = HubOrder::find()->where(['order_id' => $id])->asArray()->one();
        $order_status = OrderStatus::listData();
        $pay_status = PayStatus::listData();
        $order_type = OrderTypeStatus::listData();
        $delivery_status = DeliveryStatus::listData();
        $receipt_status = ReceiptStatus::listData();
        $model['create_time'] = date('Y-m-d H:i', $model['create_time']);
        $model['pay_time'] = date('Y-m-d H:i', $model['pay_time']);
        $model['order_status'] = $order_status[$model['order_status']];
        $model['pay_status'] = $pay_status[$model['pay_status']];
        $model['order_type'] = $order_type[$model['order_type']];
        $model['receipt_status'] = $receipt_status[$model['receipt_status']];
        $model['delivery_status'] = $delivery_status[$model['delivery_status']];

        $detail['address']['address_id'] = [$detail['address']['province_id'], $detail['address']['city_id'], $detail['address']['region_id']];

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'detail' => $detail,
            'express' => $express,
            'address' => $address,
            'Helper' => $Helper,
        ]);
    }

    // 修改订单收货地址
    public function actionUpaddress()
   {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $DdOrderAddress = new HubOrderAddress();
            $datas = [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'province_id' => $data['address_id'][0],
                'city_id' => $data['address_id'][1],
                'region_id' => $data['address_id'][2],
                'detail' => $data['detail'],
            ];
            $order_id = $data['order_id'];
            if ($DdOrderAddress->updateAll($datas, ['order_id' => $order_id])) {
                return ResultHelper::json(200, '更新成功', []);
            } else {
                $message = ErrorsHelper::getModelError($DdOrderAddress);

                return ResultHelper::json(400, '更新失败', $message);
            }
        }
    }

    public function actionExpresscode()
   {
        if (Yii::$app->request->isPost) {
            $expressCode =\Yii::$app->request->input('expressCode');
            $express_company =\Yii::$app->request->input('express_company');
            $order_id =\Yii::$app->request->input('order_id');
            $HubOrder = new HubOrder();
            $Res = $HubOrder::updateAll([
                'express_no' => $expressCode,
                'express_company' => $express_company,
            ], [
                'order_id' => $order_id,
            ]);
            if ($Res) {
                return  ResultHelper::json(200, '快递单号添加成功', []);
            } else {
                $msg = ErrorsHelper::getModelError($HubOrder);

                return  ResultHelper::json(400, $msg, []);
            }
        }
    }

    /**
     * Updates an existing DdOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DdOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    // 订单操作
    public function actionConfirm()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $ctype = $data['ctype'];
            $order_id = $data['order_id'];

            return OrderService::confirmOrder($order_id, $ctype);
        }
    }

    public function actionExportdata()
    {
        $ids = Yii::$app->request->get('ids');
        $id = explode(',', $ids);

        $goodsList = HubOrderGoods::find()->where(['order_id' => $id])->select(['order_id', 'goods_name', 'goods_price', 'total_num', 'goods_attr'])->with(['order', 'address'])->all();

        if ($goodsList) {
            $DdRegion = new DdRegion();
            $region = $DdRegion->find()->indexBy('id')->asArray()->all();
            $cells = [];
            $o = array_column($goodsList, 'order_id');
            $Gcounts = array_count_values($o);

            $num = 2;
            // 计算合并
            foreach ($Gcounts as $order_id => $val) {
                if ($val > 1) {
                    $goods = '';
                    $start = $num; //第几行开始
                    $Gcount = $num + $val - 1;
                    $cell[$order_id] = [
                        "A{$start}:A{$Gcount}", "B{$start}:B{$Gcount}", "C{$start}:C{$Gcount}", "D{$start}:D{$Gcount}", "E{$start}:E{$Gcount}", "F{$start}:F{$Gcount}", "G{$start}:G{$Gcount}",
                        "H{$start}:H{$Gcount}", "I{$start}:I{$Gcount}", "J{$start}:J{$Gcount}", "K{$start}:K{$Gcount}", "L{$start}:L{$Gcount}", "M{$start}:M{$Gcount}", "N{$start}:N{$Gcount}", "O{$start}:O{$Gcount}",
                        "P{$start}:P{$Gcount}", "Q{$start}:Q{$Gcount}", "R{$start}:R{$Gcount}", "S{$start}:S{$Gcount}",
                    ];
                    foreach ($cell[$order_id] as $k => $item) {
                        array_push($cells, $item);
                    }
                }
                $num = $num + $val;
            }

            ExportModel::widget([
                'models' => $goodsList,  // 必须
                'fileName' => '订单' . date('Y-m-d H:i:s', time()) . '.xls',  // 默认为:'excel.xls'
                'asAttachment' => true,  // 默认值, 可忽略
                'headers' => [
                    'order.order_no' => '订单编号',
                    'order.total_price' => '订单总价',
                    'order.pay_price' => '支付金额',
                    'order.pay_status' => '支付状态',
                    'order.pay_time' => '支付时间',
                    'order.order_status' => '订单状态',
                    'order.transaction_id' => '微信单号',
                    'order.remark' => '订单备注',
                    'order.create_time' => '下单时间',
                    'order.user_id' => '下单人ID',
                    'address.name' => '姓名',
                    'address.phone' => '联系方式',
                    'address.detail' => '地址详情',
                    'order.express_price' => '快递费',
                    'order.express_company' => '快递公司',
                    'order.express_no' => '快递编号',
                    'order.delivery_status' => '发货状态',
                    'order.delivery_time' => '要求送达时间',
                    'order.receipt_status' => '收货状态',
                    'order.receipt_time' => '收货时间',
                    'goods_name' => '商品名称',
                    'goods_price' => '商品价格',
                    'total_num' => '商品数量',
                ],
                'columns' => [
                    'order.order_no',
                    'order.total_price',
                    'order.pay_price',
                    [
                        'attribute' => 'order.pay_status',
                        'header' => '付款状态',
                        'format' => 'text',
                        'value' => function ($model) {
                            return $model['order']['pay_status'] == 1 ? '已支付' : '未付款';
                        },
                    ],
                    [
                        'attribute' => 'order.pay_time',
                        'header' => '付款时间',
                        'format' => 'text',
                        'value' => function ($model) {
                            return $model['order']['pay_time'] > 0 ? date('Y-m-d H:i:s', $model['order']['pay_time']) : '未支付';
                        },
                    ],
                    [
                        'attribute' => 'order.pay_time',
                        'header' => '订单状态',
                        'format' => 'text',
                        'value' => function ($model) {
                            return OrderStatus::getLabel($model['order']['order_status']);
                        },
                    ],
                    'order.transaction_id',
                    'order.remark',
                    [
                        'attribute' => 'order.create_time',
                        'header' => '下单时间',
                        'format' => 'text',
                        'value' => function ($model) {
                            return date('Y-m-d H:i:s', $model['order']['create_time']);
                        },
                    ],
                    'order.user_id',
                    'address.name',
                    'address.phone',
                    [
                        'attribute' => 'address.detail',
                        'header' => '收货地址',
                        'format' => 'text',
                        'value' => function ($model) use ($region) {
                            return $region[$model['address']['region_id']]['merger_name'] . $model['address']['detail'];
                        },
                    ],
                    'order.express_price',
                    'order.express_company',
                    'order.express_no',
                    [
                        'attribute' => 'order.delivery_status',
                        'header' => '发货时间',
                        'format' => 'text',
                        'value' => function ($model) {
                            return $model['order']['delivery_status'] == 1 ? '已发货' : '未发货';
                        },
                    ],
                    'order.receipt_status',
                    [
                        'attribute' => 'order.receipt_time',
                        'header' => '收货时间',
                        'format' => 'text',
                        'value' => function ($model) {
                            return $model['order']['receipt_time'] > 0 ? date('Y-m-d H:i:s', $model['order']['receipt_time']) : '未收货';
                        },
                    ],
                    [
                        'attribute' => 'goods_name',
                        'header' => '商品名称',
                        'format' => 'text',
                        'value' => function ($model) {
                            return   $model['goods_attr'] ? '[' . $model['goods_attr'] . ']' . $model['goods_name'] : $model['goods_name'];
                        },
                    ],
                    'goods_price',
                    'total_num',
                ],
                'mergeCells' => $cells,
            ]);
        } else {
            throw new HttpException(400, '没有可以导出的数据');
        }
    }

    public function actionExportdatalist()
   {

        $pay_status =\Yii::$app->request->input('pay_status');
        $pay_type =\Yii::$app->request->input('pay_type');
        $order_status =\Yii::$app->request->input('order_status');
        $between_time =\Yii::$app->request->input('between_time');

        $where = [];

        $tableName = HubOrder::tableName();
        $where[$tableName . '.store_id'] = Yii::$app->params['store_id'];
        $where[$tableName . '.bloc_id'] = Yii::$app->params['bloc_id'];

        $where[$tableName . '.is_split'] = 0;

        if (is_numeric($pay_status)) {
            $where[$tableName . '.pay_status'] = $pay_status;
        }

        if (is_numeric($pay_type)) {
            $where[$tableName . '.pay_type'] = $pay_type;
        }

        if (is_numeric($order_status)) {
            $where[$tableName . '.order_status'] = $order_status;
        }

        $timeWhere = [];
        if (!empty($between_time)) {
            $start_time = DateHelper::dateToInt($between_time[0]);
            $end_time = DateHelper::dateToInt($between_time[1]);
            $timeWhere = ['between', $tableName . '.create_time', $start_time, $end_time];
        }

        $ids = Yii::$app->request->get('ids');
        $id = explode(',', $ids);

        $goodsList = HubOrderGoods::find()->innerJoinWith(['order' => function ($query) use ($where, $timeWhere) {
            $query->where($where)->andFilterWhere($timeWhere);
        }, 'address'])->all();

        // foreach ($goodsList as $key => $value) {
        //     if(empty($value['order'])){
        //         $idss[$value['order_id']] = $value;
        //     }
        // }

        // p($where,$timeWhere,HubOrderGoods::find()->innerJoinWith(['order'=>function($query) use ($where,$timeWhere)
        // {
        //     $query->where($where);
        // }, 'address'])->select(['order_id', 'goods_name', 'goods_price', 'total_num','goods_attr'])->where($whereGoods)->andFilterWhere($timeWhere)->createCommand()->getRawSql(),$idss);
        // die;

        if (!empty($goodsList)) {
            $DdRegion = new DdRegion();
            $region = $DdRegion->find()->indexBy('id')->asArray()->all();
            $cells = [];
            $o = array_column($goodsList, 'order_id');
            $Gcounts = array_count_values($o);

            $num = 2;
            // 计算合并
            foreach ($Gcounts as $order_id => $val) {
                if ($val > 1) {
                    $goods = '';
                    $start = $num; //第几行开始
                    $Gcount = $num + $val - 1;
                    $cell[$order_id] = [
                        "A{$start}:A{$Gcount}", "B{$start}:B{$Gcount}", "C{$start}:C{$Gcount}", "D{$start}:D{$Gcount}", "E{$start}:E{$Gcount}", "F{$start}:F{$Gcount}", "G{$start}:G{$Gcount}",
                        "H{$start}:H{$Gcount}", "I{$start}:I{$Gcount}", "J{$start}:J{$Gcount}", "K{$start}:K{$Gcount}", "L{$start}:L{$Gcount}", "M{$start}:M{$Gcount}", "N{$start}:N{$Gcount}", "O{$start}:O{$Gcount}",
                        "P{$start}:P{$Gcount}", "Q{$start}:Q{$Gcount}", "R{$start}:R{$Gcount}", "S{$start}:S{$Gcount}",
                    ];
                    foreach ($cell[$order_id] as $k => $item) {
                        array_push($cells, $item);
                    }
                }
                $num = $num + $val;
            }

            $fileName = '订单' . date('Y-m-d H:i:s', time()) . '.xls';
            $savePath = yii::getAlias('@attachment/diandi_hub/excel/' . date('Y/m/d/', time()));
            FileHelper::mkdirs($savePath);
            $Res = ExportModel::widget([
                'models' => $goodsList,  // 必须
                'fileName' => $fileName,  // 默认为:'excel.xls'
                'asAttachment' => false,  // 默认值, 可忽略
                'savePath' => $savePath,
                'headers' => [
                    'order.order_no' => '订单编号',
                    'order.total_price' => '订单总价',
                    'order.pay_price' => '支付金额',
                    'order.pay_type' => '支付方式',
                    'order.pay_status' => '支付状态',
                    'order.pay_time' => '支付时间',
                    'order.order_status' => '订单状态',
                    'order.transaction_id' => '微信单号',
                    'order.remark' => '订单备注',
                    'order.create_time' => '下单时间',
                    'address.name' => '姓名',
                    'address.phone' => '联系方式',
                    'address.detail' => '地址详情',
                    'order.express_price' => '快递费',
                    'order.express_company' => '快递公司',
                    'order.express_no' => '快递编号',
                    'order.delivery_status' => '发货状态',
                    'order.delivery_time' => '要求送达时间',
                    'order.receipt_status' => '收货状态',
                    'order.receipt_time' => '收货时间',
                    'goods_name' => '商品名称',
                    'goods_price' => '商品价格',
                    'goods_costprice' => '成本价格',
                    'total_num' => '商品数量',
                ],
                'columns' => [
                    'order.order_no',
                    'order.total_price',
                    'order.pay_price',
                    [
                        'attribute' => 'order.pay_type',
                        'header' => '付款方式',
                        'format' => 'text',
                        'value' => function ($model) {
                            return  PayTypeStatus::getLabel($model['order']['pay_type']);
                        },
                    ],
                    [
                        'attribute' => 'order.pay_status',
                        'header' => '付款状态',
                        'format' => 'text',
                        'value' => function ($model) {
                            return $model['order']['pay_status'] == 1 ? '已支付' : '未付款';
                        },
                    ],
                    [
                        'attribute' => 'order.pay_time',
                        'header' => '付款时间',
                        'format' => 'text',
                        'value' => function ($model) {
                            return $model['order']['pay_time'] > 0 ? date('Y-m-d H:i:s', $model['order']['pay_time']) : '未支付';
                        },
                    ],
                    [
                        'attribute' => 'order.pay_time',
                        'header' => '订单状态',
                        'format' => 'text',
                        'value' => function ($model) {
                            return OrderStatus::getLabel($model['order']['order_status']);
                        },
                    ],
                    'order.transaction_id',
                    'order.remark',
                    [
                        'attribute' => 'order.create_time',
                        'header' => '下单时间',
                        'format' => 'text',
                        'value' => function ($model) {
                            return date('Y-m-d H:i:s', $model['order']['create_time']);
                        },
                    ],
                    'address.name',
                    'address.phone',
                    [
                        'attribute' => 'address.detail',
                        'header' => '收货地址',
                        'format' => 'text',
                        'value' => function ($model) use ($region) {
                            return $region[$model['address']['region_id']]['merger_name'] . $model['address']['detail'];
                        },
                    ],
                    'order.express_price',
                    'order.express_company',
                    'order.express_no',
                    [
                        'attribute' => 'order.delivery_status',
                        'header' => '发货时间',
                        'format' => 'text',
                        'value' => function ($model) {
                            return $model['order']['delivery_status'] == 1 ? '已发货' : '未发货';
                        },
                    ],
                    'order.receipt_status',
                    [
                        'attribute' => 'order.receipt_time',
                        'header' => '收货时间',
                        'format' => 'text',
                        'value' => function ($model) {
                            return $model['order']['receipt_time'] > 0 ? date('Y-m-d H:i:s', $model['order']['receipt_time']) : '未收货';
                        },
                    ],
                    [
                        'attribute' => 'goods_name',
                        'header' => '商品名称',
                        'format' => 'text',
                        'value' => function ($model) {
                            return   $model['goods_attr'] ? '[' . $model['goods_attr'] . ']' . $model['goods_name'] : $model['goods_name'];
                        },
                    ],
                    'goods_price',
                    'goods_costprice',
                    'total_num',
                ],
                'mergeCells' => $cells,
            ]);

            return ResultHelper::json(200, '下载成功', [
                'url' => ImageHelper::tomedia('/diandi_hub/excel/' . date('Y/m/d/', time()) . $fileName),
            ]);
        } else {
            return ResultHelper::json(400, '没有可以下载的数据');
        }
    }

    public function actionPrintsip()
    {
        if (Yii::$app->request->isPost) {
            $Lodop_ip = Yii::$app->settings->get('DiandiShopStroe', 'Lodop_ip');

            return ResultHelper::json(200, '打印数据请求成功', [
                'Lodop_ip' => $Lodop_ip,
            ]);
        }
    }

    public function actionPrintcloud()
    {
        if (Yii::$app->request->isPost) {
            $ids = Yii::$app->request->post('ids');
            $res = OrderService::cloudPrint($ids);

            return ResultHelper::json(200, '打印数据请求成功', $res);
        }
    }

    public function actionPrints()
    {
        if (Yii::$app->request->isPost) {
            $ids = Yii::$app->request->post('ids');
            $list = OrderService::details($ids);
            foreach ($list as $key => &$value) {
                $value['create_time'] = date('m-d H:i:s', strtotime($value['create_time']));
            }
            $info = Yii::$app->settings->getAllBySection('DiandiShopStroe');
            $info['logo'] = ImageHelper::tomedia($info['logo']);
            $info['banner'] = ImageHelper::tomedia($info['banner']);
            $info['wxappName'] = Yii::$app->settings->get('Wxapp', 'name');
            $wxappHeadimg = Yii::$app->settings->get('Wxapp', 'headimg');
            $info['wxappHeadimg'] = ImageHelper::tomedia($wxappHeadimg);

            $Lodop_ip = Yii::$app->settings->get('DiandiShopStroe', 'Lodop_ip');

            return ResultHelper::json(200, '打印数据请求成功', [
                'order' => $list,
                'store' => $info,
                'admin' => Yii::$app->user->identity->username,
                'time' => date('m-d H:i:s', time()),
                'Lodop_ip' => $Lodop_ip,
            ]);
        }
    }

    public function actionDeletes()
    {
        if (Yii::$app->request->isPost) {
            $ids = Yii::$app->request->post('ids');
            $DdOrder = new HubOrder();
            $DdOrderGoods = new HubOrderGoods();
            $DdOrderAddress = new HubOrderAddress();

            $DdOrder::deleteAll(['order_id' => $ids]);
            $DdOrderGoods::deleteAll(['order_id' => $ids]);
            $DdOrderAddress::deleteAll(['order_id' => $ids]);

            if (ErrorsHelper::getModelError($DdOrder)) {
                $errors = ErrorsHelper::getModelError($DdOrder);

                return ResultHelper::json(401, '删除失败', $errors);
            }
            if (ErrorsHelper::getModelError($DdOrderGoods)) {
                $errors = ErrorsHelper::getModelError(HubOrderGoods::class);

                return ResultHelper::json(401, '删除失败', $errors);
            }
            if (ErrorsHelper::getModelError($DdOrderAddress)) {
                $errors = ErrorsHelper::getModelError($DdOrderAddress);

                return ResultHelper::json(401, '删除失败', $errors);
            }

            return ResultHelper::json(200, '删除成功', []);
        }
    }

    /**
     * Finds the DdOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DdOrder the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
