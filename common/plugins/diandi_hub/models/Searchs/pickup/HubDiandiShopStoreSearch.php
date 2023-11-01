<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-05 01:07:35
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:39:59
 */
 

namespace common\plugins\diandi_hub\models\Searchs\pickup;

use common\plugins\diandi_hub\models\store\HubShopStore;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * DdDiandiShopStoreSearch represents the model behind the search form of `App\modules\diandi_hub\models\DdDiandiShopStore`.
 */
class HubDiandiShopStoreSearch extends HubShopStore
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'mobile', 'create_time', 'update_time'], 'integer'],
            [['title', 'intro', 'address', 'describe'], 'safe'],
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
        global $_GPC;
        $query = HubShopStore::find();

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
            'id' => $this->id,
            'mobile' => $this->mobile,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'describe', $this->describe]);

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
