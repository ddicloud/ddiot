<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-06 23:41:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 17:47:16
 */

namespace common\plugins\diandi_hub\admin\express;

use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\plugins\diandi_hub\models\express\HubExpressTemplate;
use common\plugins\diandi_hub\models\express\HubExpressTemplateArea;
use common\plugins\diandi_hub\models\Searchs\express\HubExpressTemplate as HubExpressTemplateSearch;
use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use Yii;
use yii\web\NotFoundHttpException;
use yii2mod\editable\EditableAction;

/**
 * TemplateController implements the CRUD actions for HubExpressTemplate model.
 */
class TemplateController extends AController
{
    public string $modelSearchName = 'HubExpressTemplate';

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
     * Lists all HubExpressTemplate models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HubExpressTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubExpressTemplate model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;
        $is_special = (int) $_GPC['is_special'];
        $detail = HubExpressTemplate::find()->where(['id' => $id])->asArray()->one();
        $region = new DdRegion();

        if (!empty($is_special)) {
            $list = $region->find()->select(['name', 'id', 'pid'])->where(['IN', 'id', [$detail['province'], $detail['district']]])->asArray()->all();
            foreach ($list as $key => &$value) {
                $value['value'] = $value['id'];
            }
            $citylist = [];
            $citylist = ArrayHelper::itemsMerge($list, $pid = 0, 'id', 'pid', 'children');
        } else {
            $seleCitys = HubExpressTemplateArea::find()->where([
                'is_special' => $is_special,
                'template_id' => $id,
            ])->select(['province', 'district'])->asArray()->all();
            $arr = [];
            foreach ($seleCitys as $key => $value) {
                $arr = array_merge($arr, array_values($value));
            }
            $list = $region->find()->select(['name', 'id', 'pid'])->where(['!=', 'level', 3])->andWhere(['IN', 'id', $arr])->asArray()->all();
            foreach ($list as $key => &$value) {
                $value['value'] = $value['id'];
            }
            $citylist = [];
            $citylist = ArrayHelper::itemsMerge($list, $pid = 0, 'id', 'pid', 'children');

            $detail['seleCitys'] = $citylist;
        }

        return ResultHelper::json(200, '获取成功', $detail);
    }

    public function actionInit()
    {
        $express = HubExpressCompany::find()->where(['status' => 1])->select(['id as value', 'title as text'])->asArray()->all();

        return ResultHelper::json(200, '获取成功', [
            'express' => $express,
        ]);
    }

    /**
     * Creates a new HubExpressTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        global $_GPC;
        $model = new HubExpressTemplate();
        $is_nationwide = $_GPC['is_nationwide'];
        $is_special = (int) $_GPC['is_special'];
        if (!empty($is_special)) {
            // 特殊区域处理
            $seleCitys = $_GPC['seleCitys'];
            $HubExpressTemplateArea = new HubExpressTemplateArea();

            foreach ($seleCitys as $key => $value) {
                $_HubExpressTemplateArea = clone $HubExpressTemplateArea;

                $data = [
                    'is_special' => (int) $_GPC['is_special'],
                    'template_id' => (int) $_GPC['template_id'],
                    'province' => $value['pid'],
                    'district' => $value['id'],
                    'express_id' => (int) $_GPC['express_id'],
                    'title' => $_GPC['title'],
                    'bynum_snum' => floatval($_GPC['bynum_snum']),
                    'bynum_sprice' => floatval($_GPC['bynum_sprice']),
                    'bynum_xnum' => floatval($_GPC['bynum_xnum']),
                    'bynum_xprice' => floatval($_GPC['bynum_xprice']),
                    'bynum_is_use' => floatval($_GPC['bynum_is_use']),

                    'weight_snum' => floatval($_GPC['weight_snum']),
                    'weight_sprice' => floatval($_GPC['weight_sprice']),
                    'weight_xnum' => floatval($_GPC['weight_xnum']),
                    'weight_xprice' => floatval($_GPC['weight_xprice']),
                    'weight_is_use' => floatval($_GPC['weight_is_use']),

                    'volume_snum' => floatval($_GPC['volume_snum']),
                    'volume_sprice' => floatval($_GPC['volume_sprice']),
                    'volume_xnum' => floatval($_GPC['volume_xnum']),
                    'volume_xprice' => floatval($_GPC['volume_xprice']),
                    'volume_is_use' => floatval($_GPC['volume_is_use']),
                ];
                $_HubExpressTemplateArea->setAttributes($data);
                $Res = $_HubExpressTemplateArea->save();
                $msg = ErrorsHelper::getModelError($_HubExpressTemplateArea);
                if (!empty($msg)) {
                    return ResultHelper::json(400, $msg);
                }
            }

            return ResultHelper::json(200, '新建成功');
        } else {
            if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
                // region_id
                $id = Yii::$app->db->getLastInsertID();
                if (empty($is_nationwide)) {
                    $seleCitys = $_GPC['seleCitys'];
                    $HubExpressTemplateArea = new HubExpressTemplateArea();

                    foreach ($seleCitys as $key => $value) {
                        $_HubExpressTemplateArea = clone $HubExpressTemplateArea;

                        $data = [
                            'is_special' => (int) $_GPC['is_special'],
                            'template_id' => $id,
                            'province' => $value['pid'],
                            'district' => $value['id'],
                            'express_id' => (int) $_GPC['express_id'],
                            'title' => $_GPC['title'],
                            'bynum_snum' => floatval($_GPC['bynum_snum']),
                            'bynum_sprice' => floatval($_GPC['bynum_sprice']),
                            'bynum_xnum' => floatval($_GPC['bynum_xnum']),
                            'bynum_xprice' => floatval($_GPC['bynum_xprice']),
                            'bynum_is_use' => floatval($_GPC['bynum_is_use']),

                            'weight_snum' => floatval($_GPC['weight_snum']),
                            'weight_sprice' => floatval($_GPC['weight_sprice']),
                            'weight_xnum' => floatval($_GPC['weight_xnum']),
                            'weight_xprice' => floatval($_GPC['weight_xprice']),
                            'weight_is_use' => floatval($_GPC['weight_is_use']),

                            'volume_snum' => floatval($_GPC['volume_snum']),
                            'volume_sprice' => floatval($_GPC['volume_sprice']),
                            'volume_xnum' => floatval($_GPC['volume_xnum']),
                            'volume_xprice' => floatval($_GPC['volume_xprice']),
                            'volume_is_use' => floatval($_GPC['volume_is_use']),
                        ];
                        $_HubExpressTemplateArea->setAttributes($data);
                        $Res = $_HubExpressTemplateArea->save();
                        $msg = ErrorsHelper::getModelError($_HubExpressTemplateArea);
                        if (!empty($msg)) {
                            return ResultHelper::json(400, $msg);
                        }
                    }
                }

                return ResultHelper::json(200, '新建成功', [
                    'model' => $model,
                ]);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(401, $msg);
            }
        }
    }

    /**
     * Updates an existing HubExpressTemplate model.
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
        $is_special = (int) $_GPC['is_special'];
        if (!empty($is_special)) {
            // 特殊区域处理
            $seleCitys = $_GPC['seleCitys'];
            $HubExpressTemplateArea = new HubExpressTemplateArea();

            $HubExpressTemplateArea->deleteAll([
                'template_id' => $id,
                'is_special' => (int) $_GPC['is_special'],
            ]);

            foreach ($seleCitys as $key => $value) {
                $_HubExpressTemplateArea = clone $HubExpressTemplateArea;

                $data = [
                      'is_special' => (int) $_GPC['is_special'],
                      'template_id' => (int) $_GPC['template_id'],
                      'province' => $value['pid'],
                      'district' => $value['id'],
                      'express_id' => (int) $_GPC['express_id'],
                      'title' => $_GPC['title'],
                      'bynum_snum' => floatval($_GPC['bynum_snum']),
                      'bynum_sprice' => floatval($_GPC['bynum_sprice']),
                      'bynum_xnum' => floatval($_GPC['bynum_xnum']),
                      'bynum_xprice' => floatval($_GPC['bynum_xprice']),
                      'bynum_is_use' => floatval($_GPC['bynum_is_use']),

                      'weight_snum' => floatval($_GPC['weight_snum']),
                      'weight_sprice' => floatval($_GPC['weight_sprice']),
                      'weight_xnum' => floatval($_GPC['weight_xnum']),
                      'weight_xprice' => floatval($_GPC['weight_xprice']),
                      'weight_is_use' => floatval($_GPC['weight_is_use']),

                      'volume_snum' => floatval($_GPC['volume_snum']),
                      'volume_sprice' => floatval($_GPC['volume_sprice']),
                      'volume_xnum' => floatval($_GPC['volume_xnum']),
                      'volume_xprice' => floatval($_GPC['volume_xprice']),
                      'volume_is_use' => floatval($_GPC['volume_is_use']),
                  ];
                $_HubExpressTemplateArea->setAttributes($data);
                $Res = $_HubExpressTemplateArea->save();
                $msg = ErrorsHelper::getModelError($_HubExpressTemplateArea);
                if (!empty($msg)) {
                    return ResultHelper::json(400, $msg);
                }
            }

            return ResultHelper::json(200, '修改成功');
        } else {
            if ($model->load($_GPC, '') && $model->save()) {
                // region_id
                if (empty($is_nationwide)) {
                    $seleCitys = $_GPC['seleCitys'];
                    $HubExpressTemplateArea = new HubExpressTemplateArea();
                    $HubExpressTemplateArea->deleteAll([
                        'template_id' => $id,
                        'is_special' => (int) $_GPC['is_special'],
                    ]);

                    foreach ($seleCitys as $key => $value) {
                        $_HubExpressTemplateArea = clone $HubExpressTemplateArea;
                        $data = [
                         'is_special' => (int) $_GPC['is_special'],
                         'template_id' => $id,
                         'province' => $value['pid'],
                         'district' => $value['id'],
                         'express_id' => (int) $_GPC['express_id'],
                         'title' => $_GPC['title'],
                         'bynum_snum' => floatval($_GPC['bynum_snum']),
                         'bynum_sprice' => floatval($_GPC['bynum_sprice']),
                         'bynum_xnum' => floatval($_GPC['bynum_xnum']),
                         'bynum_xprice' => floatval($_GPC['bynum_xprice']),
                         'bynum_is_use' => floatval($_GPC['bynum_is_use']),

                         'weight_snum' => floatval($_GPC['weight_snum']),
                         'weight_sprice' => floatval($_GPC['weight_sprice']),
                         'weight_xnum' => floatval($_GPC['weight_xnum']),
                         'weight_xprice' => floatval($_GPC['weight_xprice']),
                         'weight_is_use' => floatval($_GPC['weight_is_use']),

                         'volume_snum' => floatval($_GPC['volume_snum']),
                         'volume_sprice' => floatval($_GPC['volume_sprice']),
                         'volume_xnum' => floatval($_GPC['volume_xnum']),
                         'volume_xprice' => floatval($_GPC['volume_xprice']),
                         'volume_is_use' => floatval($_GPC['volume_is_use']),
                     ];
                        $_HubExpressTemplateArea->setAttributes($data);
                        $Res = $_HubExpressTemplateArea->save();
                        $msg = ErrorsHelper::getModelError($_HubExpressTemplateArea);
                        if (!empty($msg)) {
                            return ResultHelper::json(400, $msg);
                        }
                    }
                }

                return ResultHelper::json(200, '修改成功', [
                'model' => $model,
            ]);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
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
        global $_GPC;
        $is_special = (int) $_GPC['is_special'];
        $template_id = (int) $_GPC['template_id'];
        $cacheKey = 'regionExpress_'.$is_special;
        $region = new DdRegion();
        $regionVal = Yii::$app->cache->get($cacheKey);
        if ($regionVal) {
            $citylist = $regionVal;
        } else {
            $where = [];
            if (!empty($is_special)) {
                $seleCitys = HubExpressTemplateArea::find()->where(['template_id' => $template_id])->select(['province', 'district'])->asArray()->all();
                $havaIds = [];
                foreach ($seleCitys as $key => $value) {
                    $havaIds = array_merge($havaIds, array_values($value));
                }
                $where = ['not in', 'id', $havaIds];
            }
            $list = $region->find()->select(['name', 'id', 'pid'])->where(['!=', 'level', 3])->andWhere($where)->asArray()->all();
            foreach ($list as $key => &$value) {
                $value['value'] = $value['id'];
            }
            $citylist = [];
            $citylist = ArrayHelper::itemsMerge($list, $pid = 0, 'id', 'pid', 'children');

            Yii::$app->cache->set($cacheKey, $citylist);
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
                    'is_special' => 0,
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
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
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
