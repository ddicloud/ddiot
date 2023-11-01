<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-16 13:45:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:40:13
 */

namespace common\plugins\diandi_hub\models\Searchs\pickup;

use common\plugins\diandi_hub\models\HubShopAreas as ModelsHubShopAreas;
use common\plugins\diandi_hub\models\pickup\HubShopAreas as PickupHubShopAreas;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * DdShopAreas represents the model behind the search form of `App\modules\diandi_hub\models\DdShopAreas`.
 */
class HubShopAreas extends PickupHubShopAreas
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['area_id', 'bloc_id', 'store_id', 'create_time', 'status', 'province_id', 'city_id', 'region_id'], 'integer'],
            [['area_name', 'address', 'logo'], 'safe'],
            [['freight'], 'number'],
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
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
   {
        $query = PickupHubShopAreas::find();

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
            'area_id' => $this->area_id,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'create_time' => $this->create_time,
            'status' => $this->status,
            'freight' => $this->freight,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'region_id' => $this->region_id,
        ]);

        $query->andFilterWhere(['like', 'area_name', $this->area_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'logo', $this->logo]);

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
