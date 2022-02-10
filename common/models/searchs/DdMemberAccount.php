<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-05 00:09:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-05 00:11:03
 */
 

namespace common\models\searchs;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\models\DdMemberAccount as DdMemberAccountModel;
use yii\data\Pagination;


/**
 * DdMemberAccount represents the model behind the search form of `common\models\DdMemberAccount`.
 */
class DdMemberAccount extends DdMemberAccountModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bloc_id', 'store_id', 'member_id', 'level', 'user_integral', 'accumulate_integral', 'give_integral', 'frozen_integral', 'status', 'create_time', 'update_time'], 'integer'],
            [['user_money', 'accumulate_money', 'give_money', 'consume_money', 'frozen_money', 'consume_integral', 'credit1', 'credit2', 'credit3', 'credit4', 'credit5'], 'number'],
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
        $query = DdMemberAccountModel::find()->with(['member','store']);


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
            'member_id' => $this->member_id,
            'level' => $this->level,
            'user_money' => $this->user_money,
            'accumulate_money' => $this->accumulate_money,
            'give_money' => $this->give_money,
            'consume_money' => $this->consume_money,
            'frozen_money' => $this->frozen_money,
            'user_integral' => $this->user_integral,
            'accumulate_integral' => $this->accumulate_integral,
            'give_integral' => $this->give_integral,
            'consume_integral' => $this->consume_integral,
            'frozen_integral' => $this->frozen_integral,
            'credit1' => $this->credit1,
            'credit2' => $this->credit2,
            'credit3' => $this->credit3,
            'credit4' => $this->credit4,
            'credit5' => $this->credit5,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);
        
        $count = $query->count();
        $pageSize   = $_GPC['pageSize'];
        $page       = $_GPC['page'];
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
            

        $provider = new ArrayDataProvider([
            'key'=>'id',
            'allModels' => $list,
            'totalCount' => isset($count) ? $count : 0,
            'total'=> isset($count) ? $count : 0,
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
