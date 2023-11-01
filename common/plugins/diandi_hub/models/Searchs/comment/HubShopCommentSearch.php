<?php
/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 10:08:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-01 18:51:20
 */

namespace common\plugins\diandi_hub\models\Searchs\comment;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\plugins\diandi_hub\models\comment\HubShopComment;
use common\components\DataProvider\ArrayDataProvider;
use yii\data\Pagination;

/**
 * DdShopCommentSearch represents the model behind the search form of `App\modules\diandi_hub\models\DdShopComment`.
 */
class HubShopCommentSearch extends HubShopComment
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'user_id', 'status', 'star_level','bloc_id','store_id','type'], 'integer'],
            [['comment', 'create_time'], 'safe'],
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
        $query = HubShopComment::find();

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
            'type' => $this->type,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'star_level' => $this->star_level,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'create_time', $this->create_time]);

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
