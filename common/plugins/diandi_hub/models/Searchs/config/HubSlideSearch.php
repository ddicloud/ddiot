<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-04 23:31:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:37:34
 */

namespace common\plugins\diandi_hub\models\Searchs\config;

use common\plugins\diandi_hub\models\advertising\HubSlide;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\components\DataProvider\ArrayDataProvider;
use yii\data\Pagination;

/**
 * HubSlideSearch represents the model behind the search form of `common\addons\diandi_hub\models\HubSlide`.
 */
class HubSlideSearch extends HubSlide
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'store_id', 'bloc_id', 'update_time', 'create_time'], 'integer'],
            [['thumb', 'title'], 'safe'],
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
        global $_GPC;
        $query = HubSlide::find();

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
            'store_id' => $this->store_id,
            'bloc_id' => $this->bloc_id,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'title', $this->title]);

        $count = $query->count();
        $pageSize = $_GPC['pageSize'];
        $page = $_GPC['page'];
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
