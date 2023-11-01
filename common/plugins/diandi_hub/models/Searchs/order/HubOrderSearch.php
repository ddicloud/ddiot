<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-15 16:08:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-26 11:32:36
 */

namespace common\plugins\diandi_hub\models\Searchs\order;

use common\plugins\diandi_hub\models\enums\OrderStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\enums\PayStatus;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\components\DataProvider\ArrayDataProvider;
use common\helpers\DateHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * DdOrderSearch represents the model behind the search form of `App\modules\diandi_hub\models\DdOrder`.
 */
class HubOrderSearch extends HubOrder
{
    public $between_time;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id', 'bloc_id', 'store_id', 'pay_status', 'pay_time', 'delivery_status', 'delivery_time', 'receipt_status', 'receipt_time', 'user_id', 'wxapp_id', 'create_time', 'update_time', 'pay_type'], 'integer'],
            [['order_no', 'express_company', 'express_no', 'transaction_id', 'order_status', 'between_time'], 'safe'],
            [['total_price', 'pay_price', 'express_price'], 'number'],
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
        $query = HubOrder::find()->where(['is_split' => 0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
            'pay_type' => $this->pay_type,
            'pay_status' => $this->pay_status,
            'pay_time' => $this->pay_time,
            'express_price' => $this->express_price,
            'delivery_status' => $this->delivery_status,
            'delivery_time' => $this->delivery_time,
            'receipt_status' => $this->receipt_status,
            'receipt_time' => $this->receipt_time,
            'user_id' => $this->user_id,
            // 'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        if (is_numeric($this->order_status)) {
            $query->andFilterWhere(['order_status' => $this->order_status]);
        }

        if (!empty($this->between_time)) {
            list($start_time, $end_time) = explode(',', $this->between_time);
            $start_time = DateHelper::dateToInt($start_time);
            $end_time = DateHelper::dateToInt($end_time);
            $query->andFilterWhere(['between', 'create_time', $start_time, $end_time]);
        }

        $ago = DateHelper::dayAgo($this->create_time);
        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'express_company', $this->express_company])
            ->andFilterWhere(['like', 'express_no', $this->express_no])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
            // ->andFilterWhere(['like', 'create_time', $this->create_time])
            ->andFilterWhere(['between', 'create_time', $ago['start'], $ago['end']])
            ->orderBy('create_time desc');
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
        $order_status = OrderStatus::listData();
        $pay_status = PayStatus::listData();
        $order_type = OrderTypeStatus::listData();
        foreach ($list as &$val) {
            $val['create_time'] = date('Y-m-d H:i', $val['create_time']);
            $val['pay_time'] = date('Y-m-d H:i', $val['pay_time']);
            $val['order_status'] = $order_status[$val['order_status']];
            $val['pay_status'] = $pay_status[$val['pay_status']];
            $val['order_type'] = $order_type[$val['order_type']];
        }

        $dataProvider = new ArrayDataProvider([
                'key' => 'order_id',
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
