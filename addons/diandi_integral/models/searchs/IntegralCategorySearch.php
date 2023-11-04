<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 16:15:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-28 17:01:18
 */

namespace addons\diandi_integral\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use addons\diandi_integral\models\IntegralCategory;
use common\helpers\ImageHelper;
use yii\data\ArrayDataProvider;

/**
 * DdCategorySearch represents the model behind the search form of `common\models\IntegralCategory`.
 */
class IntegralCategorySearch extends IntegralCategory
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['category_id','bloc_id','store_id', 'parent_id', 'sort', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['name', 'image_id'], 'safe'],
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
     * @return ArrayDataProvider|false
     */
    public function search(array $params): bool|ArrayDataProvider
    {
        $query = IntegralCategory::find();
        $query->with('name2');
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
        
        $data = $query->asArray()->all();
        foreach($data as $key => &$val){
            $val['image_id'] = ImageHelper::tomedia($val['image_id']);
        }

        return new ArrayDataProvider([
            'key'=>'category_id',
            'modelClass'=>IntegralCategory::class,
            'allModels' => $data,
            'pagination' => false,
            'sort' => [
                'attributes' => ['category_id'],
            ],
        ]);
    }
}
