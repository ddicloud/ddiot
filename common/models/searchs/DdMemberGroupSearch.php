<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-21 10:06:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-08 15:03:08
 */

namespace common\models\searchs;

use common\components\DataProvider\ArrayDataProvider;
use common\models\DdMemberGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * DdMemberGroupSearch represents the model behind the search form of `common\models\DdMemberGroup`.
 */
class DdMemberGroupSearch extends DdMemberGroup
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['item_name'], 'safe'],
            [['create_time', 'update_time', 'level', 'group_id', 'bloc_id', 'store_id'], 'integer'],
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

        $query = DdMemberGroup::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name]);

        $count = $query->count();
        $pageSize =\Yii::$app->request->input('pageSize',10);
        $page = \Yii::$app->request->input('page',1);
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

        $provider = new ArrayDataProvider([
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

        return $provider;
    }
}
