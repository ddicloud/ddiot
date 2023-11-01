<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 21:45:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-24 14:15:57
 */

namespace common\plugins\diandi_hub\admin\member;

use common\plugins\diandi_hub\models\member\HubMemberLevel;
use common\plugins\diandi_hub\models\Searchs\member\HubMemberLevel as HubMemberLevelSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\DdMember as ModelsDdMember;
use diandi\addons\models\BlocStore;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * MemberlevelController implements the CRUD actions for HubMemberLevel model.
 */
class MemberlevelController extends AController
{
    public string $modelSearchName = 'HubMemberLevelSearch';

    /**
     * Lists all HubMemberLevel models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubMemberLevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubMemberLevel model.
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
   {
        $id =\Yii::$app->request->input('id');
        $model = HubMemberLevel::find()->where(['id' => $id])->with(['level', 'levelParent', 'member', 'memberParent', 'wxappfans', 'wechatfans', 'store'])->asArray()->one();

        $member_store_id = $model['member_store_id'];
        $storelists = BlocStore::find()->where(['IN', 'store_id', explode(',', $member_store_id)])->asArray()->all();

        $family = $model['family'];
        $memberlist = ModelsDdMember::find()->where(['IN', 'member_id', explode(',', $family)])->asArray()->all();

        return ResultHelper::json(200, '获取成功', [
            'memberlist' => $memberlist,
            'model' => $model,
            'storelists' => $storelists,
            'member_store_id' => $member_store_id,
        ]);
    }

    /**
     * Updates an existing HubMemberLevel model.
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

        $member_store_id =\Yii::$app->request->input('HubMemberLevel')['member_store_id'];

        $have = HubMemberLevel::find()->where(['member_store_id' => $member_store_id])->asArray()->one();

        if (!empty($have)) {
            // 清空该店铺所有的店主
            HubMemberLevel::updateAll(['is_store' => 0, 'member_store_id' => 0], ['member_store_id' => $member_store_id]);
        }

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

    public function actionStorelist()
   {
        $keywords =\Yii::$app->request->input('keywords');
        $where = [];
        $where1 = [];
        if (!empty($keywords)) {
            $where = ['like', 'name', $keywords];
        }

        $haveStore = HubMemberLevel::find()->where(['!=', 'member_store_id', 0])->select(['member_store_id'])->column();

        $store_ids_str = implode(',', $haveStore);

        if (!empty($store_ids_str)) {
            $where1 = ['NOT IN', 'store_id', explode(',', $store_ids_str)];
        }

        $list = BlocStore::find()->where($where)->andFilterWhere($where1)->limit(15)->asArray()->all();

        foreach ($list as $key => &$value) {
            $value['logo'] = ImageHelper::tomedia($value['logo']);
        }

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * Finds the HubMemberLevel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubMemberLevel the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = HubMemberLevel::find()->where(['id' => $id])->with(['level', 'levelParent', 'member', 'memberParent', 'wxappfans', 'wechatfans'])->one();
        if (!empty($model)) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
