<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:27:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-15 16:36:05
 */
 

namespace addons\diandi_integral\admin\order;

use addons\diandi_shop\models\DdDeliveryRule;
use Yii;
use addons\diandi_integral\models\IntegralDeliveryRule;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use addons\diandi_integral\models\searchs\IntegralDeliveryRuleSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;

/**
 * DdDeliveryRuleController implements the CRUD actions for DdDeliveryRule model.
 */
class DdDeliveryRuleController extends AController
{
    public string $modelSearchName = 'DdDeliveryRuleSearch';



    public function actionIndex(): array
    {
        $searchModel = new IntegralDeliveryRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id): array
    {
        $data = IntegralDeliveryRule::find()->with('delivery')->where(['rule_id' => $id])->asArray()->one();

        if(!empty($data['region'])){
            $data['region'] = explode(',',$data['region']);
            foreach($data['region'] as $k=>&$v){
                $v = intval($v);
            }
        }
        
        $data['blocs'] = [$data['bloc_id'],$data['store_id']];
        //$data['region'] = json_decode($data['region'],true);
        return ResultHelper::json(200,'获取成功', [
            'model' => $data,
        ]);
    }


    public function actionCreate(): array
   {
        $model = new IntegralDeliveryRule();
        $str = '';
        
        if(is_array(Yii::$app->request->input('region'))){
            foreach(Yii::$app->request->input('region') as $v){
                $str = $str.','.$v;
            }
           \Yii::$app->request->input('region') = trim($str,',');
        }

        $data = \Yii::$app->request->input();
        $blocs =\Yii::$app->request->input('blocs');
        $data['bloc_id'] = $blocs[0];
        $data['store_id']= $blocs[1];

        if ($model->load($data,'') && $model->save()) {
            return ResultHelper::json(200,'创建成功');
        }else{
            $message = ErrorsHelper::getModelError($model);
            return ResultHelper::json(401, $message);

        }
    }

    public function getId($data,$str=''){
        
        foreach($data as $key => $value){
            $str = $str.','.$value['id'];
            if($value['children']){
                $this->getId($value['children'],$str);
            }
        }
        
        return $str;
    }


    public function actionUpdate($id): array
   {
        try {
            $model = $this->findModel($id);
            $str = '';
            foreach(Yii::$app->request->input('region') as $v){
                $str = $str.','.$v;
            }

           \Yii::$app->request->input('region') = trim($str,',');


            $data = \Yii::$app->request->input();
            $blocs =\Yii::$app->request->input('blocs');
            $data['bloc_id'] = $blocs[0];
            $data['store_id']= $blocs[1];

            if ($model->load($data,'') && $model->save()) {
                return ResultHelper::json(200,'更新成功');
            }else{
                $message = ErrorsHelper::getModelError($model);
                return ResultHelper::json(401,$message);
            }
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }



    }


    public function actionDelete($id): array
    {
        try {
            $this->findModel($id)->delete();
        } catch (StaleObjectException|NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }
        return ResultHelper::json(200,'删除成功');
    }

    /**
     * Finds the DdDeliveryRule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array|ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = IntegralDeliveryRule::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
