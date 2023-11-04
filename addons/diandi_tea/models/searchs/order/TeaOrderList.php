<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-18 17:48:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-27 09:45:04
 */

namespace addons\diandi_tea\models\searchs\order;

use addons\diandi_tea\models\order\TeaOrderList as TeaOrderListModel;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * TeaOrderList represents the model behind the search form of `addons\diandi_tea\models\order\TeaOrderList`.
 */
class TeaOrderList extends TeaOrderListModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'member_id', 'coupon_id', 'pay_type', 'status', 'hourse_id', 'is_use', 'order_type', 'set_meal_id', 'renew_order_id', 'pwd'], 'integer'],
            [['create_time', 'update_time', 'start_time', 'end_time', 'order_number', 'set_meal_name'], 'safe'],
            [['balance', 'amount_payable', 'discount', 'real_pay'], 'number'],
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
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ArrayDataProvider|bool|ActiveDataProvider
     */
    public function search(array $params): ArrayDataProvider|bool|ActiveDataProvider
   {
        $query = TeaOrderListModel::find();
        $query->with(['member']);
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
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'member_id' => $this->member_id,
            'coupon_id' => $this->coupon_id,
            'balance' => $this->balance,
            'amount_payable' => $this->amount_payable,
            'discount' => $this->discount,
            'real_pay' => $this->real_pay,
            'pay_type' => $this->pay_type,
            'status' => $this->status,
            'hourse_id' => $this->hourse_id,
            'is_use' => $this->is_use,
            'order_type' => $this->order_type,
            'set_meal_id' => $this->set_meal_id,
            'renew_order_id' => $this->renew_order_id,
        ]);

        $query->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'set_meal_name', $this->set_meal_name]);

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

        // print_r($list);die;
        //foreach ($list as $key => &$value) {
        //    $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //    $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        //}

        return new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $list,
            'totalCount' => $count ?? 0,
            'total' => $count ?? 0,
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
    }
}
