<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 16:15:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-17 15:14:06
 */

namespace common\plugins\diandi_hub\models\Searchs\goods;

use common\plugins\diandi_hub\models\goods\HubCategory;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * DdCategorySearch represents the model behind the search form of `common\models\DdCategory`.
 */
class HubCategorySearch extends HubCategory
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['category_id', 'bloc_id', 'store_id', 'parent_id', 'sort', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['name', 'image_id'], 'safe'],
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
        $query = HubCategory::find();

        // add conditions that should always apply here

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'category_id' => $this->category_id,
            // 'parent_id' => $this->parent_id,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'sort' => $this->sort,
            'wxapp_id' => $this->wxapp_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

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
            ->orderBy('sort DESC')
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
        // return $dataProvider;
    }
}
