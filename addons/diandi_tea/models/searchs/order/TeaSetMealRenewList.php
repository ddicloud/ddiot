<?php

namespace addons\diandi_tea\models\searchs\order;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use addons\diandi_tea\models\order\TeaSetMealRenewList as TeaSetMealRenewListModel;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;


/**
 * TeaSetMealRenewList represents the model behind the search form of `addons\diandi_tea\models\order\TeaSetMealRenewList`.
 */
class TeaSetMealRenewList extends TeaSetMealRenewListModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'order_id', 'set_meal_id', 'renew_num', 'member_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['price', 'renew_price'], 'number'],
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
    public function search(array $params): ArrayDataProvider|bool
   {
        $query = TeaSetMealRenewListModel::find();

        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'order_id' => $this->order_id,
            'set_meal_id' => $this->set_meal_id,
            'price' => $this->price,
            'renew_price' => $this->renew_price,
            'renew_num' => $this->renew_num,
            'member_id' => $this->member_id,
        ]);
        
        $count = $query->count();
        $pageSize   =\Yii::$app->request->input('pageSize');
        $page       =\Yii::$app->request->input('page');
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
        
        //foreach ($list as $key => &$value) {
        //    $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //    $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        //} 


        return new ArrayDataProvider([
            'key'=>'id',
            'allModels' => $list,
            'totalCount' => $count ?? 0,
            'total'=> $count ?? 0,
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
        
    }
}
