<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:20:21
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-30 17:27:42
 */
 

namespace addons\diandi_integral\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use addons\diandi_integral\models\IntegralDeliveryRule;
use common\components\DataProvider\ArrayDataProvider;
use yii\data\Pagination;

/**
 * DdDeliveryRuleSearch represents the model behind the search form of `common\models\IntegralDeliveryRule`.
 */
class IntegralDeliveryRuleSearch extends IntegralDeliveryRule
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['rule_id','bloc_id','store_id', 'delivery_id', 'create_time'], 'integer'],
            [['region'], 'safe'],
            [['first', 'first_fee', 'additional', 'additional_fee'], 'number'],
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
     * @return ArrayDataProvider|ActiveDataProvider
     */
    public function search(array $params): ArrayDataProvider|ActiveDataProvider
   {
        $query = IntegralDeliveryRule::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'rule_id' => $this->rule_id, 
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'delivery_id' => $this->delivery_id,
            'first' => $this->first,
            'first_fee' => $this->first_fee,
            'additional' => $this->additional,
            'additional_fee' => $this->additional_fee,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'region', $this->region]);

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
            'key' => 'rule_id',
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
