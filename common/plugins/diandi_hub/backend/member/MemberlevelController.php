<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 21:45:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-12 18:44:19
 */
 

namespace common\plugins\diandi_hub\backend\member;

use api\models\DdMember;
use Yii;
use common\plugins\diandi_hub\models\member\HubMemberLevel;
use common\plugins\diandi_hub\models\Searchs\member\HubMemberLevel as HubMemberLevelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\DdMember as ModelsDdMember;
use diandi\addons\models\BlocStore;

/**
 * MemberlevelController implements the CRUD actions for HubMemberLevel model.
 */
class MemberlevelController extends BaseController
{
    public $modelSearchName = "HubMemberLevelSearch";
    
   

    /**
     * Lists all HubMemberLevel models.
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubMemberLevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // p($dataProvider);
        return $this->renderView('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubMemberLevel model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        global $_GPC;
        $id = $_GPC['id'];
        $model = HubMemberLevel::find()->where(['id'=>$id])->with(['level','levelParent','member','memberParent','wxappfans','wechatfans','store'])->asArray()->one();
        
        $member_store_id = $model['member_store_id'];
        $storelists = BlocStore::find()->where(['IN','store_id',explode(',',$member_store_id)])->asArray()->all();
        
        $family = $model['family'];
        $memberlist = ModelsDdMember::find()->where(['IN','member_id',explode(',',$family)])->asArray()->all();
        
        return $this->renderView('view', [
            'memberlist' => $memberlist,
            'model' => $model,
            'storelists' => $storelists,
            'member_store_id' => $member_store_id,
        ]);
    }

   

    /**
     * Updates an existing HubMemberLevel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;
        
        $member_store_id = $_GPC['HubMemberLevel']['member_store_id'];
        
        $have = HubMemberLevel::find()->where(['member_store_id'=>$member_store_id])->asArray()->one();
        
        if(!empty($have)){
            // 清空该店铺所有的店主
            HubMemberLevel::updateAll(['is_store'=>0,'member_store_id'=>0],['member_store_id'=>$member_store_id]);    
        }
        
        $model = $this->findModel($id);

        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionStorelist()
    {
        global $_GPC;
        $keywords = $_GPC['keywords'];
        $where = [];
        $where1 =[];
        if(!empty($keywords)){
            $where = ['like','name',$keywords];
        }
        
        $haveStore = HubMemberLevel::find()->where(['!=','member_store_id',0])->select(['member_store_id'])->column();
       
        $store_ids_str = implode(',',$haveStore);

        if(!empty($store_ids_str)){
            $where1 = ['NOT IN','store_id',explode(',',$store_ids_str)];
        }

        $list = BlocStore::find()->where($where)->andFilterWhere($where1)->limit(15)->asArray()->all();
        
        foreach ($list as $key => &$value) {
            $value['logo']  = ImageHelper::tomedia($value['logo']);
        }
        
        return ResultHelper::json(200, '获取成功', $list);
        
    }
  

    /**
     * Finds the HubMemberLevel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubMemberLevel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = HubMemberLevel::find()->where(['id'=>$id])->with(['level','levelParent','member','memberParent','wxappfans','wechatfans'])->one();
        if (!empty($model)) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
