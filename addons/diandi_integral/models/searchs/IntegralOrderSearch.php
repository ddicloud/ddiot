<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-15 16:08:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-29 19:11:07
 */

namespace addons\diandi_integral\models\searchs;

use addons\diandi_integral\models\enums\DeliveryStatus;
use addons\diandi_integral\models\enums\OrderStatus;
use addons\diandi_integral\models\enums\PayStatus;
use addons\diandi_integral\models\enums\ReceiptStatus;
use addons\diandi_integral\models\IntegralOrder;
use common\components\DataProvider\ArrayDataProvider;
use common\helpers\DateHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * DdOrderSearch represents the model behind the search form of `App\modules\diandi_integral\models\IntegralOrder`.
 */
class IntegralOrderSearch extends IntegralOrder
{
    public mixed $between_time = '';

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id', 'bloc_id', 'store_id', 'pay_status', 'pay_time', 'delivery_status', 'delivery_time', 'receipt_status', 'receipt_time', 'order_status', 'user_id', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['order_no', 'express_company', 'express_no', 'transaction_id', 'between_time'], 'safe'],
            [['total_price', 'pay_price', 'express_price'], 'number'],
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
     * Creates data provider instance with a search query applied.
     *
     * @param array $params
     *
     * @return ArrayDataProvider|false
     */
    public function search(array $params): ArrayDataProvider|bool
   {

        $query = IntegralOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!empty($params['IntegralOrderSearch']['create_time'])) {
            $this->create_time = $params['IntegralOrderSearch']['create_time'] = strtotime($params['IntegralOrderSearch']['create_time']);
        }

        $this->load($params);
        if (!$this->validate()) {
            return false;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'total_price' => $this->total_price,
            'pay_price' => $this->pay_price,
            'pay_status' => $this->pay_status,
            'pay_time' => $this->pay_time,
            'express_price' => $this->express_price,
            'delivery_status' => $this->delivery_status,
            'delivery_time' => $this->delivery_time,
            'receipt_status' => $this->receipt_status,
            'receipt_time' => $this->receipt_time,
            'order_status' => $this->order_status,
            'user_id' => $this->user_id,
            'wxapp_id' => $this->wxapp_id,
            // 'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        if($this->create_time){
            $ago = DateHelper::dayAgo($this->create_time);
            
            $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'express_company', $this->express_company])
            ->andFilterWhere(['like', 'express_no', $this->express_no])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
            // ->andFilterWhere(['like', 'create_time', $this->create_time])
            ->andFilterWhere(['between', 'create_time', $ago['start'], $ago['end']])
            ->orderBy('create_time desc');
        }else{
            $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'express_company', $this->express_company])
            ->andFilterWhere(['like', 'express_no', $this->express_no])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
            // ->andFilterWhere(['like', 'create_time', $this->create_time])
            //->andFilterWhere(['between', 'create_time', $ago['start'], $ago['end']])
            ->orderBy('create_time desc');
        }
        
        
        

        if (!empty($this->between_time)) {
            list($start_time, $end_time) = explode(',', $this->between_time);
            $start_time = DateHelper::dateToInt($start_time);
            $end_time = DateHelper::dateToInt($end_time);
            $query->andFilterWhere(['between', 'create_time', $start_time, $end_time]);
        }

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

        $orderstatus = OrderStatus::listData();
        $payStatus = PayStatus::listData();
        $DeliveryStatus = DeliveryStatus::listData();
        $ReceiptStatus = ReceiptStatus::listData();
        

        foreach ($list as $key => &$value) {
            
            $value['order_status'] = $orderstatus[$value['order_status']];
            $value['pay_status'] = $payStatus[$value['pay_status']];
            $value['delivery_status'] = $DeliveryStatus[$value['delivery_status']];
            $value['receipt_status'] = $ReceiptStatus[$value['receipt_status']];
        }

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
