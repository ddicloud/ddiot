<?php

/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 15:40:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 18:32:45
 */

namespace common\plugins\diandi_hub\admin\goods;

use common\plugins\diandi_hub\models\advertising\HubLocationGoods;
use common\plugins\diandi_hub\models\DdGoods;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\express\HubExpressTemplate;
use common\plugins\diandi_hub\models\goods\HubCategory;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseLabel;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseParam;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpec;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpecRel;
use common\plugins\diandi_hub\models\goods\HubSpec;
use common\plugins\diandi_hub\models\goods\HubSpecValue;
use common\plugins\diandi_hub\models\MemberExpand;
use common\plugins\diandi_hub\models\Searchs\goods\HubBaseGoodsSearch;
use admin\controllers\AController;
use common\components\MyStringHelp;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\phpexcel\ExportModel;
use common\helpers\ResultHelper;
use common\widgets\MyActiveForm;
use Yii;
use yii\db\Transaction;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;
use yii2mod\editable\EditableAction;

/**
 * 库存管理.
 */
class DdGoodsController extends AController
{
    public $modelName = 'HubGoodsBaseGoods';

    public string $modelSearchName = 'HubBaseGoodsSearch';

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'common\widgets\ueditor\UEditorAction',
                'config' => [
                    // "imageUrlPrefix" => Yii::$App->request->hostInfo, //图片访问路径前缀
                    'imagePathFormat' => '../attachment/diandi_hub/image/{yyyy}{mm}{dd}/{time}{rand:6}', //上传保存路径
                    'imageMaxSize' => 10000000,
                    'imageCompressEnable' => true,
                ],
            ],
            'change-username' => [
                'class' => EditableAction::class,
                'modelClass' => DdGoods::class,
                'pkColumn' => 'goods_id',
            ],
        ];
    }

    /**
     * Lists all DdGoods models.
     *
     * @return array
     */
    public function actionIndex()
    {
        global $_GPC;
        $searchModel = new HubBaseGoodsSearch();
        $searchWhere = $_GPC[$this->modelSearchName];
        if (!empty($searchWhere) && $searchWhere != 'undefined') {
            $where[$this->modelSearchName] = array_merge($searchWhere, Yii::$app->request->queryParams[$this->modelSearchName]);
        } else {
            $where = Yii::$app->request->queryParams;
        }

        $dataProvider = $searchModel->search($where);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCates()
    {
        // 商品分类

        $where = [];

        $bloc_id = Yii::$app->params['bloc_id'];
        $store_id = Yii::$app->params['store_id'];

        if ($bloc_id) {
            $where['bloc_id'] = $bloc_id;
        }

        if ($store_id) {
            $where['store_id'] = $store_id;
        }

        $list = HubCategory::find()->select(['category_id', 'parent_id', 'name as label', 'category_id as value'])->where($where)->asArray()->all();

        $cates = ArrayHelper::itemsMerge($list, 0, 'category_id', 'parent_id', 'children', 2);
        // 'cates' => $cates,

        return ResultHelper::json(200, '获取成功', $cates);
    }

    /**
     * Displays a single DdGoods model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $detail = HubGoodsBaseGoods::find()->where(['goods_id' => $id])->findStore()->asArray()->one();

        $detail['category'] = [$detail['category_pid'], $detail['category_id']];
        $detail['label'] = unserialize($detail['label']);
        if (empty($detail['label'])) {
            $detail['label'] = [];
        }

        $params = HubGoodsBaseParam::findAll(['goods_id' => $id]);

        // $ss = DdGoodsSpec::find()->where(['goods_id'=>$goods_id])->with('specvalue');

        $specitems = HubGoodsBaseSpecRel::find()->where(['goods_id' => $id])->with(['spec', 'specvalue'])->asarray()->all() ?: [];

        $specv = [];
        // 组装多规格数据
        if (!empty($specitems)) {
            $detail['checked'] = true;
            $detail['spec_type'] = true;
            // specs[0][spec_name]: 颜色
            // specs[0][spec_item][0][spec_item_show]: 0
            // specs[0][spec_item][0][spec_item_title]:
            // specs[0][spec_item][0][spec_item_thumb]:
            // specs[0][spec_item][0][spec_value]: 红色

            // specs[0][spec_item][1][spec_item_show]: 0
            // specs[0][spec_item][1][spec_item_title]:
            // specs[0][spec_item][1][spec_item_thumb]:
            // specs[0][spec_item][1][spec_value]: 绿色
            $temp = [];
            foreach ($specitems as $key => $value) {
                // $detail['specs'][$key]['spec_name'] = $value['spec']['spec_name'];
                // $value['specvalue']['spec_item_show'] = $value['spec_item_show'];
                // $value['specvalue']['spec_item_thumb'] = $value['thumb'];
                // $value['specvalue']['spec_item_title'] = '';
                // $item = $value['specvalue'];
                // $item['spec_item_title'] = $item['spec_value'];
                // $detail['specs'][$key]['spec_item'][] = $item;

                // $specOne = $value['spec'];
                // $specvalueOne = $value['specvalue'];

                $specs[$value['spec_id']] = $value['spec_id'];

                // $detail['spec_item_thumb'][$value['spec_id']][$value['spec_value_id']] = $value['thumb'];
                // $spec_item_thumbs[$value['spec_id']][$value['spec_value_id']]['spec_item_thumb'] = $value['thumb'];
                // $spec_item_shows[$value['spec_id']][$value['spec_value_id']]['spec_item_show'] = $value['spec_item_show'];
                // $model->spec_item_thumb = $value['thumb'];

                // $specitem[$value['spec_id']][$value['specvalue']['spec_value_id']] = $value['specvalue']['spec_value'];
                $temp[] = $value['spec_value_id'];
            }
            $specitem = $temp;
            $specv = HubSpec::find()
                ->where(['in', 'spec_id', $specs])
                ->select('spec_name,spec_id')
                ->indexBy('spec_id')
                ->asArray()
                ->all();
        }

        $allspecs = HubGoodsBaseSpec::find()->where(['goods_id' => $id])->asArray()->all();
        // $DdGoodsSpecRel = new HubGoodsBaseSpecRel();
        // $html = $DdGoodsSpecRel->buildHtml($id);
        $spec_item_shows = [];
        $spec_item_thumbs = [];

        $express_template = HubExpressTemplate::find()->asArray()->all();

        $detail['express_template'] = $express_template;
        $detail['specitem'] = $specitem;
        $detail['params'] = $params;
        // 多规格数据
        //$detail['specs'] = $specs;
        $detail['spec_item_shows'] = $spec_item_shows;
        $detail['spec_item_thumbs'] = $spec_item_thumbs;
        // $detail['html'] = $html;
        $detail['specv'] = $specv;
        $detail['goods_specs'] = $allspecs;
        if (is_array($detail['label'])) {
            foreach ($detail['label'] as &$ve) {
                $ve = (int) $ve;
            }
        }

        return ResultHelper::json(200, '获取成功', $detail);
    }

    public function actionGetSpec()
    {
        global $_GPC;
        $category_id = Yii::$app->request->input('category_id')[1];
        if (empty($category_id)) {
            return ResultHelper::json(400, '缺少二级分类id');
        }
        $spec = HubSpec::find()->where(['category_id' => $category_id])->asArray()->all();
        // $spec_id = array_column($spec, 'spec_id');
        $res = [];

        if ($spec) {
            foreach ($spec as $key1 => $value1) {
                $spec_value = HubSpecValue::find()->where(['spec_id' => $value1['spec_id']])->asArray()->all();
                if ($spec_value) {
                    foreach ($spec_value as $key2 => $value2) {
                        $res['specs'][$key1]['spec_name'] = $value1['spec_name'];
                        $res['specs'][$key1]['spec_item'][$key2]['spec_value_id'] = $value2['spec_value_id'];
                        $res['specs'][$key1]['spec_item'][$key2]['spec_id'] = $value1['spec_id'];
                        $res['specs'][$key1]['spec_item'][$key2]['spec_value'] = $value2['spec_value'];
                        $res['specs'][$key1]['spec_item'][$key2]['spec_item_title'] = $value2['spec_value'];
                    }
                }
            }
        }

        return ResultHelper::json(200, '获取成功', $res);
    }

    public function goodsAdd()
    {
        $data = Yii::$app->request->post();

        $model = new HubGoodsBaseGoods();

        /* 基础信息 */
        $base = $data['HubGoodsBaseGoods'];
        $goods_base['HubGoodsBaseGoods'] = [
            'goods_name' => $base['goods_name'],
            'video' => $base['video'],
            'category_id' => $base['category_id'],
            'category_pid' => $base['category_pid'],
            'spec_type' => $base['spec_type'],
            'deduct_stock_type' => $base['deduct_stock_type'],
            'content' => str_replace('src="/backend/../attachment', 'width="100%" src="'.Yii::$app->request->hostInfo.'/attachment', $base['content']),
            'sales_initial' => $base['sales_initial'],
            'sales_actual' => $base['sales_actual'],
            'goods_sort' => $base['goods_sort'],
            'delivery_id' => is_numeric($base['delivery_id']) ? $base['delivery_id'] : 0,
            'goods_status' => $base['goods_status'],
            'thumb' => $base['thumb'],
            'images' => $base['images'],
            'is_delete' => $base['is_delete'],
            // 'images' => serialize($base['images']),
            'line_price' => $base['line_price'],
            'goods_price' => $base['goods_price'],
            'stock' => $base['stock'],
            'label' => $base['label'],
            // 'wxapp_id' => 'Wxapp ID',
            // 'create_time' => 'Create Time',
            // 'update_time' => 'Update Time',
            // 'spec_item_thumb' => '属性图片'
        ];
        // var_dump($data['specs']);
        // die;

        if ($model->validate($data)) {
            if ($model->load($goods_base)) {
                $tr = Yii::$app->db->beginTransaction(Transaction::READ_COMMITTED);
                try {
                    if ($model->save()) {
                        if (!empty($data['specs'])) {
                            $goods_id = Yii::$app->db->getLastInsertID();
                            $model->saveSpec($goods_id, $data['specs']);
                        }

                        $tr->commit();
                    } else {
                        $message = ErrorsHelper::getModelError($model);

                        throw new BadRequestHttpException($message);
                    }
                } catch (\Exception $e) {
                    $tr->rollBack();
                    throw $e;
                }

                return $this->redirect(['view', 'id' => $goods_id]);
            }
        }
    }

    //该方法是异步校验字段，输入框失去焦点之后自动会自动请求改地址
    public function actionValidate()
    {
        global $_GPC;
        $model = new HubGoodsBaseGoods();

        $base = Yii::$app->request->input('HubGoodsBaseGoods');
        $delivery_id = 0;
        if (isset($base['delivery_id'])) {
            $delivery_id = is_numeric($base['delivery_id']) ? $base['delivery_id'] : 0;
        }

        $goods_base['HubGoodsBaseGoods'] = [
            'goods_name' => $base['goods_name'],
            'video' => $base['video'],
            'category_id' => $base['category_id'],
            'category_pid' => $base['category_pid'],
            'spec_type' => $base['spec_type'],
            'deduct_stock_type' => $base['deduct_stock_type'],
            'content' => str_replace('src="/backend/../attachment', 'width="100%" src="'.Yii::$app->request->hostInfo.'/attachment', $base['content']),
            'sales_initial' => $base['sales_initial'],
            'sales_actual' => 0,
            'goods_weight' => $base['goods_weight'],
            'goods_sort' => $base['goods_sort'],
            'delivery_id' => $delivery_id,
            'goods_status' => $base['goods_status'],
            'thumb' => $base['thumb'],
            'is_delete' => isset($base['is_delete']) ? $base['is_delete'] : 0,
            'images' => serialize($base['images']),
            'line_price' => $base['line_price'],
            'goods_price' => $base['goods_price'],
            'stock' => $base['stock'],
            'label' => $base['label'],
            // 'wxapp_id' => 'Wxapp ID',
            // 'create_time' => 'Create Time',
            // 'update_time' => 'Update Time',
            // 'spec_item_thumb' => '属性图片'
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model->load($goods_base);

        return ActiveForm::validate($model);
    }

    public function actionInit()
    {
        global $_GPC;
        $where['store_id'] = Yii::$app->request->input('store_id');
        $where['bloc_id'] = Yii::$app->request->input('bloc_id');
        //   商品分类
        $catedatas = HubCategory::find()->select(['*', 'category_id as value', 'name as label'])->where($where)->asArray()->all();
        $catedata = ArrayHelper::itemsMerge($catedatas, 0, 'category_id', 'parent_id', 'children');
        // 运费模板
        $express_template = HubExpressTemplate::find()->asArray()->all();
        // 商品标签
        $label = HubGoodsBaseLabel::find()->select(['*', 'label as text', 'id as value'])->where($where)->asArray()->all();

        return ResultHelper::json(200, '获取成功', [
            'label' => $label,
            'catedata' => $catedata,
            'express_template' => $express_template,
        ]);
    }

    /**
     * Creates a new DdGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        global $_GPC;

        $adminId = Yii::$app->user->identity->user_id;
        // $bool = MemberExpand::checkAdminCert($adminId);
        // if ($bool !== true) {
        //     return ResultHelper::json(401, $bool, []);
        // }

        $model = new HubGoodsBaseGoods();

        $isself = Yii::$app->service->commonGlobalsService->isSelf();
        if ($isself) {
            $goods_type = GoodsTypeStatus::getValueByName('自营商品');
        } else {
            $goods_type = GoodsTypeStatus::getValueByName('店铺商品');
        }

        $base = $_GPC;
        $delivery_id = 0;
        if (isset($base['delivery_id'])) {
            $delivery_id = is_numeric($base['delivery_id']) ? $base['delivery_id'] : 0;
        }

        /* 基础信息 */
        $goods_base = [
            'goods_name' => $base['goods_name'],
            'video' => $base['video'],
            'category_id' => $base['category'][1],
            'category_pid' => $base['category'][0],
            'spec_type' => (int) $base['spec_type'],
            'deduct_stock_type' => $base['deduct_stock_type'],
            'content' => str_replace('src="/backend/../attachment', 'width="100%" src="'.Yii::$app->request->hostInfo.'/attachment', $base['content']),
            'sales_initial' => $base['sales_initial'],
            'sales_actual' => isset($base['sales_actual']) ? $base['sales_actual'] : 0,
            'goods_weight' => $base['goods_weight'],
            'goods_sort' => $base['goods_sort'],
            'delivery_id' => $delivery_id,
            'goods_status' => $base['goods_status'],
            'thumb' => $base['thumb'],
            'is_delete' => isset($base['is_delete']) ? $base['is_delete'] : 0,
            'images' => $base['images'],
            'line_price' => $base['line_price'],
            'goods_price' => $base['goods_price'],
            'stock' => $base['stock'],
            'label' => serialize($base['label']),
            'goods_type' => $goods_type,
            'express_type' => $base['express_type'],
            'goods_costprice' => $base['goods_costprice'],
            'volume' => $base['volume'],
            'exemption_type' => $base['exemption_type'],
            'exemption' => $base['exemption'],
            'express_template_id' => $base['express_template_id'],
            'selling_point' => $base['selling_point'],
            'goods_spec' => $base['goods_spec'],
            'specs' => $base['specs'],
            'addons_id' => $base['addons_id'],

            // 'wxapp_id' => 'Wxapp ID',
            // 'create_time' => 'Create Time',
            // 'update_time' => 'Update Time',
            // 'spec_item_thumb' => '属性图片'
        ];
        if ($model->load($goods_base, '') && $model->save()) {
            if (!empty($base['specs'])) {
                $goods_id = Yii::$app->db->getLastInsertID();
                // $model->saveSpec($goods_id, $base['specs']);
                if (Yii::$app->request->input('spec_type')) {
                    HubGoodsBaseSpec::saveData($goods_id, $base['goods_spec'], $base['specs']);
                }
            }

            return ResultHelper::json(200, '新建成功', ['id' => $goods_id]);
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $message, []);
        }

        return ResultHelper::json(200, '新建成功', []);
    }

    /**
     * Updates an existing DdGoods model.
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
        global $_GPC;
        $model = $this->findModel($id);

        $base = $_GPC;
        $delivery_id = 0;
        if (isset($base['delivery_id'])) {
            $delivery_id = is_numeric($base['delivery_id']) ? $base['delivery_id'] : 0;
        }
        /* 基础信息 */
        $goods_base = [
            'goods_name' => $base['goods_name'],
            'video' => $base['video'],
            'category_id' => $base['category'][1],
            'category_pid' => $base['category'][0],
            'spec_type' => (int) $base['spec_type'],
            'deduct_stock_type' => $base['deduct_stock_type'],
            'content' => str_replace('src="/backend/../attachment', 'width="100%" src="'.Yii::$app->request->hostInfo.'/attachment', $base['content']),
            'sales_initial' => $base['sales_initial'],
            'sales_actual' => isset($base['sales_actual']) ? $base['sales_actual'] : 0,
            'goods_weight' => $base['goods_weight'],
            'goods_sort' => $base['goods_sort'],
            'delivery_id' => $delivery_id,
            'goods_status' => $base['goods_status'],
            'thumb' => $base['thumb'],
            'is_delete' => isset($base['is_delete']) ? $base['is_delete'] : 0,
            'images' => $base['images'],
            'line_price' => $base['line_price'],
            'goods_price' => $base['goods_price'],
            'stock' => $base['stock'],
            'label' => serialize($base['label']),
            'goods_type' => $base['goods_type'],
            'express_type' => $base['express_type'],
            'goods_costprice' => $base['goods_costprice'],
            'volume' => $base['volume'],
            'exemption_type' => $base['exemption_type'],
            'exemption' => $base['exemption'],
            'express_template_id' => $base['express_template_id'],
            'selling_point' => $base['selling_point'],
            'goods_spec' => $base['goods_spec'],
            'specs' => $base['specs'],
            'addons_id' => $base['addons_id'],

            // 'wxapp_id' => 'Wxapp ID',
            // 'create_time' => 'Create Time',
            // 'update_time' => 'Update Time',
            // 'spec_item_thumb' => '属性图片'
        ];

        if ($model->load($goods_base, '') && $model->save()) {
            if ($base['specs']) {
                $goods_id = $base['goods_id'];
                $spec = new HubGoodsBaseGoods();
                // $spec->saveSpec($goods_id, $base['specs']);
                HubGoodsBaseSpec::saveData($id, $base['goods_spec'], $base['specs']);
            }

            return ResultHelper::json(200, '更新成功', ['id' => $goods_id]);
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $message, []);
        }

        return ResultHelper::json(200, '更新成功', []);
    }

    /**
     * Deletes an existing DdGoods model.
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
        global $_GPC;

        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功', []);
        //$ids = explode(',', Yii::$app->request->input('ids'));
        // $model = new HubGoodsBaseGoods();
        // $where = ['in', 'goods_id', $id];

        // $model->deleteAll($where);
        // // 删除商品有关的广告
        // if (HubLocationGoods::deleteAll($where)) {
        //     return ResultHelper::json(200, '删除成功', []);
        // } else {
        //     return ResultHelper::json(400, '删除失败', []);
        // }
    }

    public function actionExportdatalist()
    {
        global $_GPC;
        $where = [];

        $where['store_id'] = Yii::$app->params['store_id'];
        $where['bloc_id'] = Yii::$app->params['bloc_id'];

        $goodsList = HubGoodsBaseGoods::find()->where($where)->with(['store', 'cate'])->all();

        if (!empty($goodsList)) {
            $fileName = '商品'.date('Y-m-d H:i:s', time()).'.xls';
            $savePath = yii::getAlias('@attachment/diandi_hub/excel/goods'.date('Y/m/d/', time()));
            FileHelper::mkdirs($savePath);
            $Res = ExportModel::widget([
                'models' => $goodsList,  // 必须
                'fileName' => $fileName,  // 默认为:'excel.xls'
                'asAttachment' => false,  // 默认值, 可忽略
                'savePath' => $savePath,
                'headers' => [
                    'goods_id' => '商品ID',
                    'goods_name' => '商品名称',
                    'category_id' => '商品分类',
                    'store_id' => '所属商户',
                    'volume' => '体积',
                    'store_id' => '商户ID',
                    'video' => '短视频',
                    'label' => '商品标签',
                    'spec_type' => '商品规格',
                    'goods_weight' => '重量(克)',
                    // 'express_template_id'=>'运费模板',
                    'deduct_stock_type' => '库存计算方式',
                    // 'content' => '商品介绍',
                    'sales_initial' => '初始销量',
                    'sales_actual' => 'Sales Actual',
                    'goods_sort' => '商品排序',
                    'delivery_id' => '运费模板',
                    'goods_status' => '是否上架',
                    'is_delete' => '是否删除',
                    'goods_type' => '商品类型',
                    // 'images' => '商品相册',
                    'goods_costprice' => '成本价格',
                    // 'thumb' => '商品主图',
                    'line_price' => '市场价',
                    'sales_actual' => '实际销量',
                    'browse' => '浏览量',
                    'goods_price' => '销售价格',
                    'stock' => '库存',
                    'spec_item_thumb' => '属性图片',
                    'exemption' => '包邮条件',
                    'exemption_type' => '包邮条件类型',
                    'create_time' => '添加时间',
                    'update_time' => '更新时间',
                ],
                'columns' => [
                    'goods_id',
                    'goods_name',
                    'cate.name',
                    'store.name',
                    'volume',
                    'video',
                    'label',
                    'spec_type',
                    'goods_weight',
                    // 'express_template_id',
                    'deduct_stock_type',
                    // 'content',
                    'sales_initial',
                    'sales_actual',
                    'goods_sort',
                    'delivery_id',
                    'goods_status',
                    'is_delete',
                    [
                        'attribute' => 'goods_type',
                        'header' => '商品类型',
                        'format' => 'text',
                        'value' => function ($model) {
                            return GoodsTypeStatus::getLabel($model['goods_type']);
                        },
                    ],
                    // 'images',
                    'goods_costprice',
                    // 'thumb',
                    'line_price',
                    'sales_actual',
                    'browse',
                    'goods_price',
                    'stock',
                    'spec_item_thumb',
                    [
                        'attribute' => 'exemption_type',
                        'header' => '包邮方式',
                        'format' => 'text',
                        'value' => function ($model) {
                            $list = [
                                '1' => '元',
                                '2' => '件',
                            ];

                            if (!empty($model['exemption_type'])) {
                                return '满'.$model['exemption'].$list[$model['exemption_type']].'包邮';
                            } else {
                                return '未设置';
                            }
                        },
                    ],
                ],
                // 'mergeCells' => $cells,
            ]);

            return ResultHelper::json(200, '下载成功', [
                'url' => ImageHelper::tomedia('/diandi_hub/excel/goods'.date('Y/m/d/', time()).$fileName),
            ]);
        } else {
            return ResultHelper::json(400, '没有可以下载的数据');
        }
    }

    /**
     * 添加规格页面.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionSpecitem()
    {
        if (Yii::$app->request->isAjax) {
            // Yii::$App->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $pids = $data['specid'];

            $title = Yii::$app->request->post('title', '');
            $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);
            $ids = $MyStringHelp->CreateString('_');

            $specitem = [
                'ids' => $ids,
                'title' => $title,
                'show' => 1,
            ];
            $spec = [
                'ids' => $pids,
            ];
            $model = new HubGoodsBaseGoods();

            $form = MyActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

            return $this->renderAjax('spec_item', [
                'specitem' => $specitem,
                'spec' => $spec,
                'model' => $model,
                'form' => $form,
            ]);
        }
    }

    public function actionParam()
    {
        $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);

        $tag = $MyStringHelp->CreateString('_');
        $model = new HubGoodsBaseGoods();

        return $this->renderAjax('param', [
            'tag' => $tag,
            'model' => $model,
        ]);
    }

    /**
     * 添加规格
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionSpec()
    {
        global $_GPC;
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            $title = Yii::$app->request->post('title', '');
            $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);

            $ids = $MyStringHelp->CreateString('_');
            if (!empty($data['specid'])) {
                $ids = $data['specid'];
            }

            $model = new HubGoodsBaseGoods();

            $spec = [
                'id' => $ids,
                'title' => $title,
            ];

            return $this->renderPartial('spec', [
                'op' => Yii::$app->request->input('op'),
                'spec' => $spec,
                'model' => $model,
                'specitem' => [],
            ]);
        }
    }

    /**
     * Finds the DdGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DdGoods the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubGoodsBaseGoods::findOne(['goods_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
