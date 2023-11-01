<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-30 15:00:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-19 11:07:08
 */

namespace common\plugins\diandi_hub\models\Searchs\location;

use common\plugins\diandi_hub\models\advertising\HubLocationGoods;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * LocationGoodsSearch represents the model behind the search form of `common\addons\diandi_hub\models\LocationGoods`.
 */
class LocationGoodsSearch extends HubLocationGoods
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'store_id', 'bloc_id', 'goods_id', 'location_id', 'is_show'], 'integer'],
            [['mark'], 'safe'],
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
        $query = HubLocationGoods::find()
                ->joinWith('goods as g')
                ->joinWith('location as l');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            return false;
        }

        $query->where([
            'g.goods_status' => 1,
            'l.store_id' => $this->store_id,
            'l.bloc_id' => $this->bloc_id,
            ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'goods_id' => $this->goods_id,
            'location_id' => $this->location_id,
            'is_show' => $this->is_show,
        ]);

        $query->andFilterWhere(['like', 'mark', $this->mark]);

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
