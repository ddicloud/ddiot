<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-01 14:59:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-24 16:27:09
 */

namespace common\plugins\diandi_hub\admin\store;

use common\plugins\diandi_hub\models\Searchs\store\HubStoreUser as HubStoreUserSearch;
use common\plugins\diandi_hub\models\store\HubStoreUser;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\DdMember;
use diandi\addons\models\BlocStore;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for HubStoreUser model.
 */
class UserController extends AController
{
    public string $modelSearchName = 'HubStoreUserSearch';

    /**
     * Lists all HubStoreUser models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubStoreUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubStoreUser model.
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;
        $detail = HubStoreUser::find()->where(['id'=>$id])->with(['store','member','bloc'])->asArray()->one();
        return ResultHelper::json(200,'获取成功', $detail);
    }

    /**
     * Creates a new HubStoreUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubStoreUser();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubStoreUser model.
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

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubStoreUser model.
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

    public function actionStorelist()
    {
        global $_GPC;

        $keywords =\Yii::$app->request->input('keywords');

        $where = [];

        $where1 = [];

        if (!empty($keywords)) {
            $where = ['like', 'name', $keywords];
        }

        // $haveStore = HubStoreUser::find()->select(['store_id'])->column();

        // if(!empty($haveStore)){
        //     $where1 = ['NOT IN','store_id',$haveStore];
        // }

        $list = BlocStore::find()->where($where)->limit(15)->asArray()->all();

        foreach ($list as $key => &$value) {
            $value['logo'] = ImageHelper::tomedia($value['logo']);
        }

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionMemberlist()
    {
        global $_GPC;

        $keywords =\Yii::$app->request->input('keywords');

        $where = [];

        $where1 = [];

        if (!empty($keywords)) {
            $where = ['like', 'username', $keywords];
        }

        $haveMember = HubStoreUser::find()->select(['member_id'])->column();

        if (!empty($haveMember)) {
            $where1 = ['NOT IN', 'member_id', $haveMember];
        }

        $list = DdMember::find()->where($where)->andFilterWhere($where1)->limit(15)->asArray()->all();

        foreach ($list as $key => &$value) {
            $value['logo'] = ImageHelper::tomedia($value['logo']);
        }

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * Finds the HubStoreUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubStoreUser the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubStoreUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
