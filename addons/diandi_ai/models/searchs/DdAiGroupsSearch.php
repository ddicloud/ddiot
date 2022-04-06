<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-09-19 09:34:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-19 09:40:02
 */

namespace addons\diandi_ai\models\searchs;

use addons\diandi_ai\models\DdAiGroups;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DdAiGroupsSearch represents the model behind the search form of `common\models\DdAiGroups`.
 */
class DdAiGroupsSearch extends DdAiGroups
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ai_group_status'], 'integer'],
            [['name', 'createtime', 'updatetime'], 'safe'],
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
        $query = DdAiGroups::find();

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
            'id' => $this->id,
            'ai_group_status' => $this->ai_group_status,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
