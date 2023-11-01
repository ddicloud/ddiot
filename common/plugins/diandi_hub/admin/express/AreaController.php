<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-08 12:22:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 16:46:14
 */

namespace common\plugins\diandi_hub\admin\express;

use common\plugins\diandi_hub\models\express\HubExpressTemplate;
use common\plugins\diandi_hub\models\express\HubExpressTemplateArea;
use common\plugins\diandi_hub\models\Searchs\express\HubExpressTemplateArea as HubExpressTemplateAreaSearch;
use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * AreaController implements the CRUD actions for HubExpressTemplateArea model.
 */
class AreaController extends AController
{
    public string $modelSearchName = 'HubExpressTemplateAreaSearch';

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
     * Lists all HubExpressTemplateArea models.
     *
     * @return array
     */
    public function actionIndex()
    {
        global $_GPC;

        $template_id = Yii::$app->request->input('template_id');

        $searchModel = new HubExpressTemplateAreaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'template_id' => $template_id,
        ]);
    }

    /**
     * Displays a single HubExpressTemplateArea model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;

        $template_id = Yii::$app->request->input('template_id');
        $detail = HubExpressTemplateArea::find()->where(['id' => $id])->asArray()->one();
        $region = new DdRegion();
        $list = $region->find()->select(['name', 'id', 'pid'])->where(['IN', 'id', [$detail['province'], $detail['district']]])->asArray()->all();
        foreach ($list as $key => &$value) {
            $value['value'] = $value['id'];
        }
        $citylist = [];
        $citylist = ArrayHelper::itemsMerge($list, $pid = 0, 'id', 'pid', 'children');
        $detail['seleCitys'] = $citylist;

        return ResultHelper::json(200, '获取成功', $detail);
    }

    /**
     * Creates a new HubExpressTemplateArea model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        global $_GPC;

        $template_id = Yii::$app->request->input('template_id');
        $template = HubExpressTemplate::findOne($template_id);
        $express_id = $template['express_id'];
        $title = $template['title'];
        $model = new HubExpressTemplateArea();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'template_id' => $template_id]);
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'title' => $title,
            'express_id' => $express_id,
            'template_id' => $template_id,
        ]);
    }

    /**
     * Updates an existing HubExpressTemplateArea model.
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

        $template_id = Yii::$app->request->input('template_id');
        $template = HubExpressTemplate::findOne($template_id);
        $express_id = $template['express_id'];
        $title = $template['title'];

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'template_id' => $template_id]);
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'title' => $title,
            'express_id' => $express_id,
            'template_id' => $template_id,
        ]);
    }

    /**
     * Deletes an existing HubExpressTemplateArea model.
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

        $template_id = Yii::$app->request->input('template_id');

        $this->findModel($id)->delete();

        return ResultHelper::json(200, '获取成功', []);
    }

    /**
     * Finds the HubExpressTemplateArea model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubExpressTemplateArea the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubExpressTemplateArea::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
