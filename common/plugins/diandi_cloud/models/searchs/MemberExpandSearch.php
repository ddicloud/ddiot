<?php

namespace common\plugins\diandi_cloud\models\searchs;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\plugins\diandi_cloud\models\MemberExpand;
use yii\data\Pagination;


/**
 * MemberExpandSearch represents the model behind the search form of `addons\diandi_cloud\models\MemberExpand`.
 */
class MemberExpandSearch extends MemberExpand
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['member_id', 'admin_id', 'is_developer', 'cert_gold_status', 'cert_type', 'cert_status', 'audit', 'audit_type'], 'integer'],
            [['cert_gold'], 'number'],
            [['pay_at', 'pay_no', 'id_card_front', 'id_card_reverse', 'id_card_expired_at', 'license', 'audit_opinion', 'created_at'], 'safe'],
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
        $query = MemberExpand::find();



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'member_id' => $this->member_id,
            // 'admin_id' => $this->admin_id,
            'is_developer' => $this->is_developer,
            'cert_gold' => $this->cert_gold,
            'cert_gold_status' => $this->cert_gold_status,
            'pay_at' => $this->pay_at,
            'cert_type' => $this->cert_type,
            'cert_status' => $this->cert_status,
            'id_card_expired_at' => $this->id_card_expired_at,
            'audit' => $this->audit,
            'audit_type' => $this->audit_type,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'pay_no', $this->pay_no])
            ->andFilterWhere(['like', 'id_card_front', $this->id_card_front])
            ->andFilterWhere(['like', 'id_card_reverse', $this->id_card_reverse])
            ->andFilterWhere(['like', 'license', $this->license])
            ->andFilterWhere(['like', 'audit_opinion', $this->audit_opinion]);

        $count = $query->count();
        $pageSize   = $_GPC['pageSize']??10;
        $page       = $_GPC['page']??1;
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->with('member')
            ->asArray()
            ->all();

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
