<?php

namespace addons\diandi_tea\models\searchs\config;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use addons\diandi_tea\models\config\TeaTemplate as TeaTemplateModel;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

/**
 * TeaTemplate represents the model behind the search form of `addons\diandi_tea\models\config\TeaTemplate`.
 */
class TeaTemplate extends TeaTemplateModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'msg_type'], 'integer'],
            [['create_time', 'update_time', 'template_code', 'keywords'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
    * Creates data provider instance with search query applied
    *
    * @param array $params
    *
    * @return ArrayDataProvider|bool|ActiveDataProvider
    */
    public function search(array $params): ArrayDataProvider|bool|ActiveDataProvider
   {
        $query = TeaTemplateModel::find();

        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'msg_type' => $this->msg_type,
        ]);

        $query->andFilterWhere(['like', 'template_code', $this->template_code])
            ->andFilterWhere(['like', 'keywords', $this->keywords]);
        
        $count = $query->count();
        $pageSize   =\Yii::$app->request->input('pageSize');
        $page       =\Yii::$app->request->input('page');
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
        //foreach ($list as $key => &$value) {
        //    $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //    $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        //} 
            

        return new ArrayDataProvider([
            'key'=>'id',
            'allModels' => $list,
            'totalCount' => isset($count) ?? 0,
            'total'=> isset($count) ?? 0,
            'sort' => [
                'attributes' => [
                    //'member_id',
                ],
                'defaultOrder' => [
                    //'member_id' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]);
        
    }
}
