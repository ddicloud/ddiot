<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:20:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-29 14:25:14
 */
 

 
namespace addons\diandi_integral\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use addons\diandi_integral\models\IntegralDelivery;
use common\components\DataProvider\ArrayDataProvider;
use yii\data\Pagination;

/**
 * DdDeliverySearch represents the model behind the search form of `common\models\IntegralDelivery`.
 */
class IntegralDeliverySearch extends IntegralDelivery
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['delivery_id','bloc_id','store_id', 'sort',  'create_time', 'update_time'], 'integer'],
            [['name'], 'safe'],
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
     * Creates data provider instance with a search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider|false
     */
    public function search(array $params): ArrayDataProvider|bool
   {
        $DbInteral = new IntegralDelivery;
        $query = $DbInteral->find();
        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       
        $this->load($params);
    
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'delivery_id' => $this->delivery_id, 
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'sort' => $this->sort,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);
        
        
        $query->andFilterWhere(['like', 'name', $this->name]);
  
        $count = $query->count();
        $pageSize =\Yii::$app->request->input('pageSize');
        $page =\Yii::$app->request->input('page');

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();


        return new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $list,
            'totalCount' => $count ?? 0,
            'total' => $count ?? 0,
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
            ],
        ]);
    }
}
