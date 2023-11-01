<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-21 10:15:36
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:08:06
 */


namespace common\plugins\diandi_hub\models\Searchs\account;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\plugins\diandi_hub\models\account\HubMemberAccount as HubMemberAccountModel;
use yii\data\Pagination;


/**
 * HubMemberAccount represents the model behind the search form of `common\addons\diandi_hub\models\account\HubMemberAccount`.
 */
class HubMemberAccount extends HubMemberAccountModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'is_store', 'member_id', 'create_time', 'update_time'], 'integer'],
            [['self_money', 'self_withdraw', 'self_freeze', 'team_money', 'team_withdraw', 'team_freeze', 'store_money', 'store_withdraw', 'store_freeze'], 'number'],
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
        $query = HubMemberAccountModel::find();

        

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
            'is_store' => $this->is_store,
            'member_id' => $this->member_id,
            'self_money' => $this->self_money,
            'self_withdraw' => $this->self_withdraw,
            'self_freeze' => $this->self_freeze,
            'team_money' => $this->team_money,
            'team_withdraw' => $this->team_withdraw,
            'team_freeze' => $this->team_freeze,
            'store_money' => $this->store_money,
            'store_withdraw' => $this->store_withdraw,
            'store_freeze' => $this->store_freeze,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);
        
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
