<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 00:17:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-15 15:19:58
 */

namespace addons\diandi_integral\admin\order;

use addons\diandi_distribution\models\enums\PayStatus;
use addons\diandi_integral\models\enums\DeliveryStatus;
use addons\diandi_integral\models\enums\OrderStatus;
use addons\diandi_integral\models\enums\ReceiptStatus;
use addons\diandi_integral\models\IntegralCompany;
use addons\diandi_integral\models\IntegralOrder;
use addons\diandi_integral\models\IntegralOrderAddress;
use addons\diandi_integral\models\IntegralOrderGoods;
use addons\diandi_integral\models\searchs\IntegralOrderSearch;
use addons\diandi_integral\services\OrderService;
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
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * DdOrderController implements the CRUD actions for DdOrder model.
 */
class DdOrderController extends AController
{
    public string $modelSearchName = 'IntegralOrderSearch';

    public function actions(): array
    {
        $actions = parent::actions();
        $actions['get-region'] = [
            'class' => \diandi\region\RegionAction::class,
            'model' => DdRegion::class,
        ];

        return $actions;
    }


    public function actionIndex(): array
    {

        $searchModel = new IntegralOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id): array
    {
        $detail = OrderService::detail($id);
        $address = IntegralOrderAddress::findOne(['order_id' => $id]);
        $region = new DdRegion();
        $Helper = new LevelTplHelper([
            'pid' => 'pid',
            'cid' => 'id',
            'title' => 'name',
            'model' => $region,
            'id' => 'id',
        ]);

        $express = IntegralCompany::find()->asArray()->all();

        $goodsModel = IntegralOrderGoods::find()->where(['order_id' => $id])->asArray()->all();

        $model = IntegralOrder::find()->where(['order_id' => $id])->asArray()->one();

        $orderstatus = OrderStatus::listData();
        $payStatus = PayStatus::listData();
        $DeliveryStatus = DeliveryStatus::listData();
        $ReceiptStatus = ReceiptStatus::listData();

        $model['order_status'] = $orderstatus[$model['order_status']];
        $model['pay_status'] = $payStatus[$model['pay_status']];
        $model['delivery_status'] = $DeliveryStatus[$model['delivery_status']];
        $model['receipt_status'] = $ReceiptStatus[$model['receipt_status']];

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'goodsModel' => $goodsModel,
            'express' => $express,
            'detail' => $detail,
            'address' => $address,
            'Helper' => $Helper,
        ]);
    }


    public function actionUpaddress(): array
    {
        $data = Yii::$app->request->post();
        $DdOrderAddress = new IntegralOrderAddress();
        $datas = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'province_id' => $data['province_id'],
            'city_id' => $data['city_id'],
            'region_id' => $data['region_id'],
            'detail' => $data['detail'],
            //'detail' => $data['DdOrderAddress']['detail'],
        ];
        $order_id = $data['order_id'];
        if ($DdOrderAddress->updateAll($datas, ['order_id' => $order_id])) {
            return ResultHelper::json(200, '更新成功');
        } else {
            $message = ErrorsHelper::getModelError($DdOrderAddress);

            return ResultHelper::json(401, $message);
        }
    }


    public function actionExpresscode(): array
   {
        $express_no =\Yii::$app->request->input('express_no');
        $express_company =\Yii::$app->request->input('express_company');
        $order_id =\Yii::$app->request->input('order_id');
        $DistributionOrder = new IntegralOrder();
        $Res = $DistributionOrder::updateAll([
            'express_no' => $express_no,
            'express_company' => $express_company,
        ], ['order_id' => $order_id,
        ]);
        if ($Res) {
            return ResultHelper::json(200, '快递单号添加成功');
        } else {
            $msg = ErrorsHelper::getModelError($DistributionOrder);

            return ResultHelper::json(401, $msg);
        }
    }


    public function actionExportdatalist(): array
   {

        $pay_status =\Yii::$app->request->input('pay_status');
        $pay_type =\Yii::$app->request->input('pay_type');
        $order_status =\Yii::$app->request->input('order_status');
        $between_time =\Yii::$app->request->input('between_time');

        $where = [];

        $tableName = IntegralOrder::tableName();
        $where[$tableName . '.store_id'] = Yii::$app->params['store_id'];
        $where[$tableName . '.bloc_id'] = Yii::$app->params['bloc_id'];

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
//        $id = explode(',', $ids);

        $goodsList = IntegralOrderGoods::find()->innerJoinWith(['order' => function ($query) use ($where, $timeWhere) {
            $query->where($where)->andFilterWhere($timeWhere);
        }, 'address'])->all();

        // foreach ($goodsList as $key => $value) {
        //     if(empty($value['order'])){
        //         $idss[$value['order_id']] = $value;
        //     }
        // }

        // p($where,$timeWhere,DistributionOrderGoods::find()->innerJoinWith(['order'=>function($query) use ($where,$timeWhere)
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
                    $cell[$order_id] = ["A{$start}:A{$Gcount}", "B{$start}:B{$Gcount}", "C{$start}:C{$Gcount}", "D{$start}:D{$Gcount}", "E{$start}:E{$Gcount}", "F{$start}:F{$Gcount}", "G{$start}:G{$Gcount}",
                        "H{$start}:H{$Gcount}", "I{$start}:I{$Gcount}", "J{$start}:J{$Gcount}", "K{$start}:K{$Gcount}", "L{$start}:L{$Gcount}", "M{$start}:M{$Gcount}", "N{$start}:N{$Gcount}", "O{$start}:O{$Gcount}",
                        "P{$start}:P{$Gcount}", "Q{$start}:Q{$Gcount}", "R{$start}:R{$Gcount}", "S{$start}:S{$Gcount}",];
                    foreach ($cell[$order_id] as $k => $item) {
                        $cells[] = $item;
                    }
                }
                $num = $num + $val;
            }

            $fileName = '订单' . date('Y-m-d H:i:s', time()) . '.xls';
            $savePath = yii::getAlias('@attachment/diandi_integral/excel/' . date('Y/m/d/', time()));
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
                            return $model['goods_attr'] ? '[' . $model['goods_attr'] . ']' . $model['goods_name'] : $model['goods_name'];
                        },
                    ],
                    'goods_price',
                    'goods_costprice',
                    'total_num',
                ],
                'mergeCells' => $cells,
            ]);

            return ResultHelper::json(200, '下载成功', [
                'url' => ImageHelper::tomedia('/diandi_integral/excel/' . date('Y/m/d/', time()) . $fileName),
            ]);
        } else {
            return ResultHelper::json(400, '没有可以下载的数据');
        }
    }


    public function actionCreate(): array
    {
        $model = new IntegralOrder();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '创建成功');
        } else {
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(400, $msg);
        }
    }


    public function actionUpdate($id): array
    {
        $model = IntegralOrder::find()->where(['id' => $id])->asArray()->one();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '更新成功');
        } else {
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(400, $msg);
        }
    }


    public function actionDelete($id): array
    {
        try {
            $this->findModel($id)->delete();
        } catch (StaleObjectException|NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);

        }

        return ResultHelper::json(200, '删除成功');
    }


    // 订单操作
    public function actionConfirm(): array
    {
        $data = Yii::$app->request->post();
        $ctype = $data['ctype'];
        $order_id = $data['order_id'];

        return OrderService::confirmOrder($order_id, $ctype);
    }


    /**
     * @throws \Throwable
     * @throws HttpException
     */
    public function actionExportdata(): void
    {
        $ids = Yii::$app->request->get('ids');
        $id = explode(',', $ids);

        $goodsList = IntegralOrderGoods::find()->where(['order_id' => $id])->select(['order_id', 'goods_name', 'goods_price', 'total_num', 'goods_attr'])->with(['order', 'address'])->all();

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
                    $cell[$order_id] = ["A{$start}:A{$Gcount}", "B{$start}:B{$Gcount}", "C{$start}:C{$Gcount}", "D{$start}:D{$Gcount}", "E{$start}:E{$Gcount}", "F{$start}:F{$Gcount}", "G{$start}:G{$Gcount}",
                        "H{$start}:H{$Gcount}", "I{$start}:I{$Gcount}", "J{$start}:J{$Gcount}", "K{$start}:K{$Gcount}", "L{$start}:L{$Gcount}", "M{$start}:M{$Gcount}", "N{$start}:N{$Gcount}", "O{$start}:O{$Gcount}",
                        "P{$start}:P{$Gcount}", "Q{$start}:Q{$Gcount}", "R{$start}:R{$Gcount}", "S{$start}:S{$Gcount}",];
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
                    [
                        'attribute' => 'order.delivery_time',
                        'header' => '要求送达时间',
                        'format' => 'text',
                        'value' => function ($model) {
                            return $model['order']['delivery_time'] > 0 ? date('Y-m-d H:i:s', $model['order']['delivery_time']) : '未设置';
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
                            return $model['goods_attr'] ? '[' . $model['goods_attr'] . ']' . $model['goods_name'] : $model['goods_name'];
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


    public function actionPrintsip(): array
    {
        $Lodop_ip = Yii::$app->settings->get('DiandiShopStroe', 'Lodop_ip');

        return ResultHelper::json(200, '打印数据请求成功', [
            'Lodop_ip' => $Lodop_ip,
        ]);

    }


    public function actionPrintcloud(): array
    {
        $ids = Yii::$app->request->post('ids');
        $res = OrderService::cloudPrint($ids);

        return ResultHelper::json(200, '打印数据请求成功', $res);
    }


    public function actionPrints(): array
    {
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


    public function actionDeletes(): array
    {
        $ids = Yii::$app->request->post('ids');
        $DdOrder = new IntegralOrder();
        $DdOrderGoods = new IntegralOrderGoods();
        $DdOrderAddress = new IntegralOrderAddress();

        $DdOrder::deleteAll(['order_id' => $ids]);
        $DdOrderGoods::deleteAll(['order_id' => $ids]);
        $DdOrderAddress::deleteAll(['order_id' => $ids]);

        if (ErrorsHelper::getModelError($DdOrder)) {
            $errors = ErrorsHelper::getModelError($DdOrder);

            return ResultHelper::json(401, $errors);
        }
        if (ErrorsHelper::getModelError($DdOrderGoods)) {
            $errors = ErrorsHelper::getModelError(IntegralOrderGoods::class);

            return ResultHelper::json(401, $errors);
        }
        if (ErrorsHelper::getModelError($DdOrderAddress)) {
            $errors = ErrorsHelper::getModelError($DdOrderAddress);

            return ResultHelper::json(401, $errors);
        }

        return ResultHelper::json(200, '删除成功', []);

    }

    /**
     * Finds the DdOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|ActiveRecord the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = IntegralOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
