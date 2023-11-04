<?php

/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 15:40:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-16 14:09:16
 */

namespace addons\diandi_integral\admin\goods;

use addons\diandi_distribution\models\express\DistributionExpressTemplate;
use addons\diandi_integral\models\IntegralCategory;
use addons\diandi_integral\models\IntegralGoods;
use addons\diandi_integral\models\searchs\IntegralGoodsSearch;
use addons\diandi_integral\services\GoodsService;
use admin\controllers\AController;
use common\components\MyStringHelp;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\LevelTplHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Transaction;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii2mod\editable\EditableAction;

/**
 * DdGoodsController implements the CRUD actions for DdGoods model.
 */
class DdGoodsController extends AController
{
    public string $modelName = 'IntegralGoods';

    public string $modelSearchName = 'IntegralGoodsSearch';

    public function actions(): array
    {
        return [
            'upload' => [
                'class' => 'common\widgets\ueditor\UEditorAction',
                'config' => [
                    // "imageUrlPrefix" => Yii::$App->request->hostInfo, //图片访问路径前缀
                    'imagePathFormat' => '../attachment/diandi_integral/image/{yyyy}{mm}{dd}/{time}{rand:6}', //上传保存路径
                    'imageMaxSize' => 10000000,
                    'imageCompressEnable' => true,
                ],
            ],
            'change-username' => [
                'class' => EditableAction::class,
                'modelClass' => IntegralGoods::class,
                'pkColumn' => 'goods_id',
            ],
        ];
    }


    public function actionIndex(): array
    {
        $searchModel = new IntegralGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id): array
    {
        $model = IntegralGoods::find()->with('delivery')->where(['goods_id' => $id])->asArray()->one();

        //  $model['thumb'] = $model['thumb'];
        $model['images'] = unserialize($model['images']);
        $slides = [];
        if ($model['video']) {
            $slides[] = [
                'type' => 'video',
                'url' => ImageHelper::tomedia($model['video']),
            ];
        }

        $model['slides'] = $slides;

        $model['category_id'] = [
            $model['category_pid'],
            $model['category_id'],
        ];

        $model['blocs'] = [$model['bloc_id'], $model['store_id']];

        return ResultHelper::json(200, '获取成功', ['model' => $model]);
    }

    public function goodsAdd(): array
    {
        $data = Yii::$app->request->post();
        $model = new IntegralGoods();

        /* 基础信息 */
        $base = $data['IntegralGoods'];
        $goods_base['IntegralGoods'] = [
            'bloc_id' => $base['blocs'][0],
            'store_id' => $base['blocs'][1],
            'goods_name' => $base['goods_name'],
            'category_id' => $base['category_id'],
            'category_pid' => $base['category_pid'],
            'spec_type' => $base['spec_type'],
            'deduct_stock_type' => $base['deduct_stock_type'],
            'content' => str_replace('src="/backend/../attachment', 'width="100%" src="' . Yii::$app->request->hostInfo . '/attachment', $base['content']),
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
            'goods_integral' => $base['goods_integral'],

            'exemption_type' => $base['exemption_type'],
            'exemption' => $base['exemption'],
            'express_template_id' => $base['express_template_id'],

            // 'wxapp_id' => 'Wxapp ID',
            // 'create_time' => 'Create Time',
            // 'update_time' => 'Update Time',
            // 'spec_item_thumb' => '属性图片'
        ];

        if ($model->validate($data)) {
            if ($model->load($goods_base)) {
                $tr = Yii::$app->db->beginTransaction(Transaction::READ_COMMITTED);
                try {
                    if ($model->save()) {
                        $goods_id = Yii::$app->db->getLastInsertID();
                        GoodsService::saveSpec($goods_id, $data);
                        $tr->commit();
                    } else {
                        $message = ErrorsHelper::getModelError($model);

                        throw new BadRequestHttpException($message);
                    }
                } catch (\Exception $e) {
                    $tr->rollBack();
                    return ResultHelper::json(400, $e->getMessage(), (array)$e);
                }

                return ResultHelper::json(200, '获取成功', ['view', 'id' => $goods_id]);
            } else {
                return ResultHelper::json(400, '商品信息保存失败');
            }
        } else {
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(400, $msg);
        }
    }

    //该方法是异步校验字段，输入框失去焦点之后自动会自动请求改地址
    public function actionValidate(): array
   {
        $model = new IntegralGoods();

        $base =\Yii::$app->request->input('IntegralGoods');
        $delivery_id = 0;
        if (isset($base['delivery_id'])) {
            $delivery_id = is_numeric($base['delivery_id']) ? $base['delivery_id'] : 0;
        }

        $goods_base['IntegralGoods'] = [
            'goods_name' => $base['goods_name'],
            'category_id' => $base['category_id'],
            'category_pid' => $base['category_pid'],
            'spec_type' => $base['spec_type'],
            'deduct_stock_type' => $base['deduct_stock_type'],
            'content' => str_replace('src="/backend/../attachment', 'width="100%" src="' . Yii::$app->request->hostInfo . '/attachment', $base['content']),
            'sales_initial' => $base['sales_initial'],
            'sales_actual' => 0,
            'goods_weight' => $base['goods_weight'],
            'goods_sort' => $base['goods_sort'],
            'delivery_id' => $delivery_id,
            'goods_status' => $base['goods_status'],
            'thumb' => $base['thumb'],
            'is_delete' => $base['is_delete'] ?? 0,
            'images' => serialize($base['images']),
            'line_price' => $base['line_price'],
            'goods_price' => $base['goods_price'],
            'stock' => $base['stock'],
            'label' => $base['label'],
            'goods_integral' => $base['goods_integral'],

            'volume' => $base['volume'],
            'express_type' => $base['express_type'],
            'express_template_id' => $base['express_template_id'],
            // 'wxapp_id' => 'Wxapp ID',
            // 'create_time' => 'Create Time',
            // 'update_time' => 'Update Time',
            // 'spec_item_thumb' => '属性图片'
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model->load($goods_base);

        return ActiveForm::validate($model);
    }

    public function actionCreate(): array
    {
        $model = new IntegralGoods();

        $data = Yii::$app->request->post();
        $delivery_id = 0;
        if (isset($base['delivery_id'])) {
            $delivery_id = is_numeric($base['delivery_id']) ? $base['delivery_id'] : 0;
        }

        /* 基础信息 */
        //$base = $data['IntegralGoods'];
        $base = $data;
        $category_pid = IntegralCategory::find()->select(['parent_id'])->where(['category_id' => $base['category_id']])->asArray()->one()['parent_id'];
        //$goods_base['IntegralGoods'] = [
        $goods_base = [
            'bloc_id' => $base['blocs'][0],
            'store_id' => $base['blocs'][1],
            'goods_name' => $base['goods_name'],
            'category_id' => $base['category_id'][1],
            'category_pid' => $base['category_id'][0],
            'spec_type' => $base['spec_type'],
            'deduct_stock_type' => $base['deduct_stock_type'],
            'content' => str_replace('src="/backend/../attachment', 'width="100%" src="' . Yii::$app->request->hostInfo . '/attachment', $base['content']),
            'sales_initial' => $base['sales_initial'],
            'sales_actual' => $base['sales_actual'] ?? 0,
            'goods_weight' => $base['goods_weight'],
            'goods_sort' => $base['goods_sort'],
            'delivery_id' => $delivery_id,
            'goods_status' => $base['goods_status'],
            'thumb' => $base['thumb'],
            'is_delete' => $base['is_delete'] ?? 0,
            'images' => $base['images'],
            'line_price' => $base['line_price'],
            'goods_price' => $base['goods_price'],
            'stock' => $base['stock'],
            'label' => $base['label'],
            'goods_integral' => $base['goods_integral'],

            'volume' => $base['volume'],
            'express_type' => $base['express_type'],
            'express_template_id' => $base['express_template_id'],

            // 'wxapp_id' => 'Wxapp ID',
            // 'create_time' => 'Create Time',
            // 'update_time' => 'Update Time',
            // 'spec_item_thumb' => '属性图片'
        ];

        //var_dump($goods_base);die;
        if ($model->load($goods_base, '') && $model->save()) {
            $goods_id = Yii::$app->db->getLastInsertID();
            GoodsService::saveSpec($goods_id, $data);

            return ResultHelper::json(200, '添加成功');
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $message, []);
        }
    }


    public function actionInit(): array
    {
        $model = new IntegralGoods();
        $modelcate = new IntegralCategory();

        $Helper = new LevelTplHelper([
            'pid' => 'parent_id',
            'cid' => 'category_id',
            'title' => 'name',
            'model' => $modelcate,
            'id' => 'category_id',
        ]);
        $query = $modelcate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);
        $specitem = [];
        $params = [];
        $html = '';
        $spec = [
            'id' => $MyStringHelp->CreateString('_'),
        ];
        $model->goods_status = 1;
        $model->deduct_stock_type = 20;
        $model->label = '新品';

        $catedata = IntegralCategory::find()->all();

        $model = new IntegralGoods();

        $spec_item_shows = [];
        $spec_item_thumbs = [];

        $express_template = DistributionExpressTemplate::find()->asArray()->all();

        $model->goods_status = 1;

        $model->deduct_stock_type = 20;
        $model->express_type = 1;

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'express_template' => $express_template,
            'catedata' => $catedata,
            'modelcate' => $modelcate,
            'dataProvider' => $dataProvider,
            'spec_item_thumbs' => $spec_item_thumbs,
            'spec_item_shows' => $spec_item_shows,
            'Helper' => $Helper,
            'specitem' => $specitem,
            'params' => $params,
            'spec' => $spec,
            'op' => 'create',
        ]);
    }


    public function actionUpdate($id): array
   {
        $model = IntegralGoods::find()->where(['id' => $id])->asArray()->one();

       \Yii::$app->request->input('category_pid') =\Yii::$app->request->input('category_id')[1];
       \Yii::$app->request->input('category_id') =\Yii::$app->request->input('category_id')[0];

        if ($model->load($_GPC, '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功');
        } else {
            $message = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $message);
        }
    }


    public function actionDelete($id): array
    {
        try {
            $this->findModel($id)->delete();
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(200, '删除成功', ['index']);
    }


    public function actionSpecitem()
    {
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
        $model = new IntegralGoods();


        return ResultHelper::json(200, '添加成功', [
            'specitem' => $specitem,
            'spec' => $spec,
            'model' => $model
        ]);
    }


    public function actionParam(): array
    {
        $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);

        $tag = $MyStringHelp->CreateString('_');
        $model = new IntegralGoods();

        return ResultHelper::json(200, '获取成功', [
            'tag' => $tag,
            'model' => $model,
        ]);
    }


    public function actionSpec(): array
   {
        $data = Yii::$app->request->post();

        $title = Yii::$app->request->post('title', '');
        try {
            $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);
        } catch (Exception $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        $ids = $MyStringHelp->CreateString('_');
        if (!empty($data['specid'])) {
            $ids = $data['specid'];
        }

        $model = new IntegralGoods();

        $spec = [
            'id' => $ids,
            'title' => $title,
        ];

        return ResultHelper::json(200, '添加成功', [
            'op' =>\Yii::$app->request->input('op'),
            'spec' => $spec,
            'model' => $model,
            'specitem' => [],
        ]);
    }

    /**
     * Finds the DdGoods model based on its primary key value.
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
        if (($model = IntegralGoods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
