<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-01 11:49:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:41:49
 */

namespace common\plugins\diandi_hub\admin\conf;

use common\plugins\diandi_hub\models\money\HubPriceConf;
use common\plugins\diandi_hub\models\Searchs\config\HubPriceConfSearch as ConfigHubPriceConfSearch;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii2mod\editable\EditableAction;

/**
 * PriceConfController implements the CRUD actions for HubPriceConf model.
 */
class PriceConfController extends AController
{
    public $prices = [];
    public $level_ids = [];
    public $group_ids = [];

    public function actions()
    {
        $prices = [
            'price1' => 'price1',
            'price2' => 'price2',
            'price3' => 'price3',
            'price4' => 'price4',
            'price5' => 'price5',
            'price6' => 'price6',
        ];

        $this->prices = $prices;

        $this->level_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $this->group_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        return [
            'change-use' => [
                'class' => EditableAction::class,
                'modelClass' => HubPriceConf::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    // public function actionIndex()
    // {
    //     $model = new \common\addons\diandi_hub\models\HubPriceConf();

    //     if ($model->load(Yii::$App->request->post())) {
    //         if ($model->validate()) {
    //             // form inputs are valid, do something here
    //             return;
    //         }
    //     }

    //     return $this->render('price', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Lists all HubPriceConf models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConfigHubPriceConfSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'prices' => $this->prices,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubPriceConf model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return ResultHelper::json(200, '获取成功', [
            'prices' => $this->prices,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HubPriceConf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $HubPriceConf = new HubPriceConf();
        $pricefield = $HubPriceConf->find()->asArray()->all();
        foreach ($pricefield as $key => $value) {
            unset($this->prices[$value['pricefield']]);
        }

        if (!$this->prices) {
            Yii::$app->session->setFlash('error', '没有需要配置的价格了');

            return $this->redirect(['index']);
        }

        $model = new HubPriceConf();

          if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
      return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        $model->is_use = 0;

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'prices' => $this->prices,
            'level_ids' => $this->level_ids,
            'group_ids' => $this->group_ids,
        ]);
    }

    /**
     * Updates an existing HubPriceConf model.
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
        $model = $this->findModel($id);

          if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
      return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'prices' => $this->prices,
            'level_ids' => $this->level_ids,
            'group_ids' => $this->group_ids,
        ]);
    }

    /**
     * Deletes an existing HubPriceConf model.
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
 return ResultHelper::json(200,'删除成功');
    }

    /**
     * Finds the HubPriceConf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubPriceConf the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubPriceConf::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
