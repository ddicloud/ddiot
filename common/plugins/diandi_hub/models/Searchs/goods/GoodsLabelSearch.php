<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-16 13:43:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-26 14:32:06
 */

namespace common\plugins\diandi_hub\models\Searchs\goods;

use common\plugins\diandi_hub\models\goods\HubGoodsBaseLabel;
use common\components\DataProvider\ArrayDataProvider;
use common\helpers\ImageHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * GoodsLabelSearch represents the model behind the search form of `common\addons\diandi_hub\models\GoodsLabel`.
 */
class GoodsLabelSearch extends HubGoodsBaseLabel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id'], 'integer'],
            [['label', 'color'], 'safe'],
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
        $query = HubGoodsBaseLabel::find();

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
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'color', $this->color]);

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
        foreach ($list as $key => &$value) {
            $value['thumb'] = ImageHelper::tomedia($value['thumb']);
        }            
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
