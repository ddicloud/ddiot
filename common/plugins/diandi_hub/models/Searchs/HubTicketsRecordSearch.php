<?php

namespace common\plugins\diandi_hub\models\Searchs;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\plugins\diandi_hub\models\HubTicketsRecord;
use yii\data\Pagination;


/**
 * HubTicketsRecordSearch represents the model behind the search form of `addons\diandi_hub\models\HubTicketsRecord`.
 */
class HubTicketsRecordSearch extends HubTicketsRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'tickets_id', 'send_id', 'type'], 'integer'],
            [['content', 'created_at'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider

     */
    public function search($params)
    {
        global $_GPC;
        $query = HubTicketsRecord::find();



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'id' => $this->id,
            'tickets_id' => $this->tickets_id,
            'send_id' => $this->send_id,
            'type' => $this->type,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['>', 'id', $this->id ?? -9]);
        $query->andFilterWhere(['like', 'content', $this->content]);

        $count = $query->count();
        $pageSize   = Yii::$app->request->input('pageSize')??10;
        $page       = Yii::$app->request->input('page')??1;
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->orderBy('id DESC')
            ->limit($pagination->limit)
            ->all();
        $list = array_reverse($list);

        //foreach ($list as $key => &$value) {
        //    $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //    $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        //} 


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
            ]
        ]);

        return $provider;
    }
}
