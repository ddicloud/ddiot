<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:20:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:38:08
 */
 

 
namespace common\plugins\diandi_hub\models\Searchs\pickup;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\plugins\diandi_hub\models\DdDelivery;
use common\plugins\diandi_hub\models\order\HubDelivery;
use common\components\DataProvider\ArrayDataProvider;
use yii\data\Pagination;

/**
 * DdDeliverySearch represents the model behind the search form of `common\models\DdDelivery`.
 */
class HubDeliverySearch extends HubDelivery
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['delivery_id','bloc_id','store_id', 'method', 'sort', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
   {
        
        $query = HubDelivery::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'delivery_id' => $this->delivery_id, 
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'method' => $this->method,
            'sort' => $this->sort,
            'wxapp_id' => $this->wxapp_id,
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

        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $list,
            'totalCount' => isset($count) ? $count : 0,
            'total' => isset($count) ? $count : 0,
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

        return $dataProvider;
    }
}
