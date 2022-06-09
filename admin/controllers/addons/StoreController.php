<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 15:07:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-09 10:55:03
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use admin\models\addons\models\Bloc;
use admin\models\enums\StoreStatus;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\LevelTplHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use diandi\addons\models\BlocStore;
use diandi\addons\models\searchs\BlocStoreSearch;
use diandi\addons\models\searchs\StoreCategory;
use diandi\addons\models\StoreLabel;
use diandi\addons\models\StoreLabelLink;
use Yii;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * StoreController implements the CRUD actions for BlocStore model.
 */
class StoreController extends AController
{
    public $modelSearchName = 'BlocStore';

    public $modelClass = '';

    public $bloc_id;

    public $extras = [];

    public function actions()
    {
        $this->bloc_id = Yii::$app->request->get('bloc_id', 0);
        $actions = parent::actions();
        $actions['get-region'] = [
            'class' => \diandi\region\RegionAction::className(),
            'model' => DdRegion::className(),
        ];

        return $actions;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BlocStore models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $bloc_id = $this->bloc_id ? $this->bloc_id : Yii::$app->params['bloc_id'];

        $searchModel = new BlocStoreSearch([
            'bloc_id' => $bloc_id,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionChildcate()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $parent_id = $data['parent_id'];
            $cates = StoreCategory::findAll(['parent_id' => $parent_id]);

            return ResultHelper::json(200, '获取成功', $cates);
        }
    }

    public function actionCategory()
    {
        $cates = StoreCategory::find()->select(['parent_id', 'category_id', 'name as label', 'category_id as value'])->asArray()->all();
        $list = ArrayHelper::itemsMerge($cates, 0, 'category_id', 'parent_id', 'children');

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * Displays a single BlocStore model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $BlocStore = new BlocStore([
            'extras' => $this->extras,
        ]);
        $detail = $BlocStore::find()->where(['store_id' => $id])->asArray()->one();
        $detail['logo'] = $detail['logo'];
        $detail['extra'] = unserialize($detail['extra']);
        $detail['county'] = (int) $detail['county'];
        $detail['province'] = (int) $detail['province'];
        $detail['provinceCityDistrict'] = [
            (int) $detail['province'], (int) $detail['city'], (int) $detail['county'],
        ];
        $detail['category'] = [
            $detail['category_pid'],
            $detail['category_id'],
        ];

        $detail['address'] = [
            'address' => $detail['address'],
            'lat' => $detail['latitude'],
            'lng' => $detail['longitude'],
        ];

        $storage = Yii::$app->params['conf']['oss']['remote_type'];
        $url = '';
        switch ($storage) {
            case 'locai':
                $url = Yii::$app->request->hostInfo;
                break;
            case 'alioss':
                $url = Yii::$app->params['conf']['oss']['Aliyunoss_url'];
            break;
            case 'qiniu':
                $url = Yii::$app->params['conf']['oss']['Qiniuoss_url'];
            break;
            case 'cos':
                $url = Yii::$app->params['conf']['oss']['Tengxunoss_url'];
            break;
            default:
                $url = Yii::$app->request->hostInfo;
            break;
        }
        $detail['config'] = [
            'attachmentUrl' => $url.'/attachment',
        ];

        return ResultHelper::json(200, '获取成功', $detail);
    }

    /**
     * Creates a new BlocStore model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        global $_GPC;

        $model = new BlocStore([
            'extras' => $this->extras,
        ]);

        $modelcate = new StoreCategory();

        $Helper = new LevelTplHelper([
            'pid' => 'parent_id',
            'cid' => 'category_id',
            'title' => 'name',
            'model' => $modelcate,
            'id' => 'category_id',
        ]);

        $link = new StoreLabelLink();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            $data['lng_lat'] = json_encode([
                'lng' => $data['longitude'],
                'lat' => $data['latitude'],
            ]);

            if ($model->load($data, '') && $model->save()) {
                $StoreLabelLink = $_GPC['StoreLabelLink'];

                if (!empty($StoreLabelLink['label_id'])) {
                    foreach ($StoreLabelLink['label_id'] as $key => $label_id) {
                        $_link = clone  $link;
                        $bloc_id = $model->bloc_id;
                        $store_id = $model->store_id;
                        $data = [
                            'bloc_id' => $bloc_id,
                            'store_id' => $store_id,
                            'label_id' => $label_id,
                        ];
                        $_link->setAttributes($data);
                        $_link->save();
                    }
                }

                return $this->redirect(['view', 'id' => $model->store_id, 'bloc_id' => $model->bloc_id]);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                throw new HttpException(400, $msg);
            }
        }

        $labels = StoreLabel::find()->select(['id', 'name'])->indexBy(
            'id'
        )->asArray()->all();

        $linkValue = [];

        return ResultHelper::json(200, '获取成功', [
            'link' => $link,
            'linkValue' => $linkValue,
            'labels' => $labels,
            'model' => $model,
            'Helper' => $Helper,
            'bloc_id' => $this->bloc_id,
        ]);
    }

    /**
     * Updates an existing BlocStore model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;

        $model = $this->findModel($id);
        $model['extra'] = unserialize($model['extra']);
        $link = new StoreLabelLink();

        $bloc_id = $model->bloc_id;
        $store_id = $model->store_id;

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            $StoreLabelLink = $_GPC['StoreLabelLink'];
            $link->deleteAll([
                    'store_id' => $store_id,
                ]);

            if (!empty($StoreLabelLink['label_id'])) {
                foreach ($StoreLabelLink['label_id'] as $key => $label_id) {
                    $_link = clone  $link;
                    $data = [
                            'bloc_id' => $bloc_id,
                            'store_id' => $store_id,
                            'label_id' => $label_id,
                        ];
                    $_link->setAttributes($data);
                    $_link->save();
                }
            }

            return ResultHelper::json(200, '更新成功');
        } else {
            $error = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $error);
        }
    }

    public function actionBlocs()
    {
        $model = new Bloc();

        $lists = $model->find()->select(['bloc_id', 'pid', 'business_name as label', 'bloc_id as id'])->asArray()->all();

        $list = ArrayHelper::itemsMerge($lists, 0, 'bloc_id', 'pid', 'children');

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionStorestatus()
    {
        $list = StoreStatus::listData();

        $lists = [];

        foreach ($list as $key => $value) {
            $lists[] = [
                'text' => $value,
                'value' => $key,
            ];
        }

        return ResultHelper::json(200, '获取成功', $lists);
    }

    /**
     * Deletes an existing BlocStore model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $bloc_id = $this->bloc_id;

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the BlocStore model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return BlocStore the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $BlocStore = new BlocStore([
            'extras' => $this->extras,
        ]);
        if (($model = $BlocStore::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
