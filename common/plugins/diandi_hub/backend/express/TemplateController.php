<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-06 23:41:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 12:29:41
 */

namespace common\plugins\diandi_hub\backend\express;

use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\plugins\diandi_hub\models\express\HubExpressTemplate;
use common\plugins\diandi_hub\models\express\HubExpressTemplateArea;
use common\plugins\diandi_hub\models\Searchs\express\HubExpressTemplate as HubExpressTemplateSearch;
use backend\controllers\BaseController;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii2mod\editable\EditableAction;

/**
 * TemplateController implements the CRUD actions for HubExpressTemplate model.
 */
class TemplateController extends BaseController
{
    public $modelSearchName = 'HubExpressTemplateSearch';

    public function actions()
    {
        return [
            'change-username' => [
                'class' => EditableAction::class,
                'modelClass' => HubExpressTemplate::class,
                'pkColumn' => 'id',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Lists all HubExpressTemplate models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubExpressTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubExpressTemplate model.
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        global $_GPC;
        $id = $_GPC['id'];

        if (Yii::$app->request->isPost) {
             try {
            $view = $this->findModel($id)->toArray();
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

            $bynum_snum = floatval($view['bynum_snum']);
            $bynum_sprice = floatval($view['bynum_sprice']);
            $bynum_xnum = floatval($view['bynum_xnum']);
            $bynum_xprice = floatval($view['bynum_xprice']);
            $bynum_is_use = floatval($view['bynum_is_use']);

            $weight_snum = floatval($view['weight_snum']);
            $weight_sprice = floatval($view['weight_sprice']);
            $weight_xnum = floatval($view['weight_xnum']);
            $weight_xprice = floatval($view['weight_xprice']);
            $weight_is_use = floatval($view['weight_is_use']);

            $volume_snum = floatval($view['volume_snum']);
            $volume_sprice = floatval($view['volume_sprice']);
            $volume_xnum = floatval($view['volume_xnum']);
            $volume_xprice = floatval($view['volume_xprice']);
            $volume_is_use = floatval($view['volume_is_use']);

            $list[] = [
                'type' => '计件收费',
                'snum' => $bynum_snum,
                'sprice' => $bynum_sprice,
                'xnum' => $bynum_xnum,
                'xprice' => $bynum_xprice,
                'is_use' => $bynum_is_use,
            ];

            $list[] = [
                'type' => '计重收费',
                'snum' => $weight_snum,
                'sprice' => $weight_sprice,
                'xnum' => $weight_xnum,
                'xprice' => $weight_xprice,
                'is_use' => $weight_is_use,
            ];

            $list[] = [
                'type' => '计体积收费',
                'snum' => $volume_snum,
                'sprice' => $volume_sprice,
                'xnum' => $volume_xnum,
                'xprice' => $volume_xprice,
                'is_use' => $volume_is_use,
            ];

            return ResultHelper::json(200, '获取成功', [
                'list' => $list,
                'title' => $view['title'],
                'express_id' => $view['express_id'],
                'template_id' => $view['id'],
            ]);
        }

        return $this->renderView('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HubExpressTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubExpressTemplate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $express = HubExpressCompany::find()->where(['status' => 1])->asArray()->all();

        return $this->render('create', [
            'model' => $model,
            'express' => $express,
        ]);
    }

    /**
     * Updates an existing HubExpressTemplate model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // 更新所有区域的正常模板价格
            $view = $_GPC['HubExpressTemplate'];

            $data = [
                    'bynum_snum' => floatval($view['bynum_snum']),
                    'bynum_sprice' => floatval($view['bynum_sprice']),
                    'bynum_xnum' => floatval($view['bynum_xnum']),
                    'bynum_xprice' => floatval($view['bynum_xprice']),

                    'weight_snum' => floatval($view['weight_snum']),
                    'weight_sprice' => floatval($view['weight_sprice']),
                    'weight_xnum' => floatval($view['weight_xnum']),
                    'weight_xprice' => floatval($view['weight_xprice']),

                    'volume_snum' => floatval($view['volume_snum']),
                    'volume_sprice' => floatval($view['volume_sprice']),
                    'volume_xnum' => floatval($view['volume_xnum']),
                    'volume_xprice' => floatval($view['volume_xprice']),
                ];

            $HubExpressTemplateArea = new HubExpressTemplateArea();
            $HubExpressTemplateArea->updateAll($data, [
                    'is_special' => 0,
                    'template_id' => $id,
                ]);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        $express = HubExpressCompany::find()->where(['status' => 1])->asArray()->all();

        return $this->render('update', [
            'model' => $model,
            'express' => $express,
        ]);
    }

    public function actionGetarea()
    {
        global $_GPC;
        $express_id = $_GPC['express_id'];
        $template_id = $_GPC['template_id'];
        $HubExpressTemplateArea = new HubExpressTemplateArea();
        $list = $HubExpressTemplateArea->find()->where([
            'express_id' => $express_id,
            'template_id' => $template_id,
        ])->select('region_id')->column();

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionCitylist()
    {
        $region = new DdRegion();
        $regionVal = Yii::$app->cache->get('regionExpress');
        if ($regionVal) {
            $citylist = $regionVal;
        } else {
            $list = $region->find()->select(['name', 'id', 'pid'])->where(['!=', 'level', 3])->asArray()->all();
            foreach ($list as $key => &$value) {
                $value['value'] = $value['id'];
            }
            $citylist = [];
            $citylist = ArrayHelper::itemsMerge($list, $pid = 0, 'id', 'pid', 'children');

            Yii::$app->cache->set('regionExpress', $citylist);
        }

        return ResultHelper::json(200, '获取成功', $citylist);
    }

    public function actionTemplatearea()
    {
        global $_GPC;

        $region_ids = $_GPC['region_ids'];
        if (!empty($region_ids)) {
            $title = $_GPC['title'];
            $express_id = $_GPC['express_id'];
            $template_id = $_GPC['template_id'];

            // if(empty($express_id)){
            //      return ResultHelper::json(400,'请更新快递模板后选择适用区域',[]);
            // }
            $view = $this->findModel($template_id);

            $HubExpressTemplateArea = new HubExpressTemplateArea();

            $HubExpressTemplateArea->deleteAll([
                'express_id' => $express_id,
                'template_id' => $template_id,
            ]);
            if (in_array(0, $region_ids)) {
                $region_list[] = 0; //00代表全国
            } else {
                $region_list = $region_ids;
            }
            foreach ($region_list as $key => $region_id) {
                $_HubExpressTemplateArea = clone $HubExpressTemplateArea;
                $data = [
                    'title' => $title,
                    'express_id' => $express_id,
                    'template_id' => $template_id,
                    'region_id' => $region_id,
                    'bynum_snum' => $view['bynum_snum'],
                    'bynum_sprice' => $view['bynum_sprice'],
                    'bynum_xnum' => $view['bynum_xnum'],
                    'bynum_xprice' => $view['bynum_xprice'],
                    'bynum_is_use' => $view['bynum_is_use'],
                    'weight_snum' => $view['weight_snum'],
                    'weight_sprice' => $view['weight_sprice'],
                    'weight_xnum' => $view['weight_xnum'],
                    'weight_xprice' => $view['weight_xprice'],
                    'weight_is_use' => $view['weight_is_use'],
                    'volume_snum' => $view['volume_snum'],
                    'volume_sprice' => $view['volume_sprice'],
                    'volume_xnum' => $view['volume_xnum'],
                    'volume_xprice' => $view['volume_xprice'],
                    'volume_is_use' => $view['volume_is_use'],
                    'is_special' => (int) $_GPC['is_special'],
                ];
                $_HubExpressTemplateArea->setAttributes($data);
                if (!$_HubExpressTemplateArea->save()) {
                    $msg = ErrorsHelper::getModelError($_HubExpressTemplateArea);

                    return ResultHelper::json(400, $msg, []);
                }
            }

            return ResultHelper::json(200, '添加成功', []);
        }
    }

    /**
     * Deletes an existing HubExpressTemplate model.
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

        return $this->redirect(['index']);
    }

    /**
     * Finds the HubExpressTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubExpressTemplate the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubExpressTemplate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
