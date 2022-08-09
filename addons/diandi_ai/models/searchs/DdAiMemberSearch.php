<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-09-19 09:34:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-19 09:40:10
 */

namespace addons\diandi_ai\models\searchs;

use addons\diandi_ai\models\DdAiMember;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DdAiMemberSearch represents the model behind the search form of `common\models\DdAiMember`.
 */
class DdAiMemberSearch extends DdAiMember
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'face_group_id', 'gender', 'wxapp_id', 'create_time', 'update_time', 'ai_age'], 'integer'],
            [['nickName', 'face_image', 'face_token', 'ai_gender', 'ai_glasses', 'ai_race', 'ai_emotion', 'face_shape', 'ai_quality_blur', 'ai_quality_illumination', 'ai_quality_completeness'], 'safe'],
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
        $query = DdAiMember::find();

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
            'user_id' => $this->user_id,
            'face_group_id' => $this->face_group_id,
            'gender' => $this->gender,
            // 'face_id' => $this->face_id,
            // 'uid' => $this->uid,
            'wxapp_id' => $this->wxapp_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'ai_age' => $this->ai_age,
        ]);

        $query->andFilterWhere(['like', 'nickName', $this->nickName])
            ->andFilterWhere(['like', 'face_image', $this->face_image])
            ->andFilterWhere(['like', 'face_token', $this->face_token])
            ->andFilterWhere(['like', 'ai_gender', $this->ai_gender])
            ->andFilterWhere(['like', 'ai_glasses', $this->ai_glasses])
            ->andFilterWhere(['like', 'ai_race', $this->ai_race])
            ->andFilterWhere(['like', 'ai_emotion', $this->ai_emotion])
            ->andFilterWhere(['like', 'face_shape', $this->face_shape])
            ->andFilterWhere(['like', 'ai_quality_blur', $this->ai_quality_blur])
            ->andFilterWhere(['like', 'ai_quality_illumination', $this->ai_quality_illumination])
            ->andFilterWhere(['like', 'ai_quality_completeness', $this->ai_quality_completeness]);

        return $dataProvider;
    }
}
