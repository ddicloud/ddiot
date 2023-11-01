<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 03:30:21
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-26 15:29:40
 */

namespace common\plugins\diandi_hub\models\Searchs\refund;

use common\plugins\diandi_hub\models\enums\RefundStatus;
use common\plugins\diandi_hub\models\enums\RefundType;
use common\plugins\diandi_hub\models\enums\Status;
use common\plugins\diandi_hub\models\order\DdRefundReason;
use common\plugins\diandi_hub\models\order\HubRefundOrder as HubRefundOrderModel;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\Pagination;

/**
 * HubRefundOrder represents the model behind the search form of `common\addons\diandi_hub\models\order\HubRefundOrder`.
 */
class HubRefundOrder extends HubRefundOrderModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'order_id', 'reason_id', 'transaction_id', 'type', 'refund_status', 'status', 'member_id', 'goods_id', 'create_time', 'update_time'], 'integer'],
            [['refund_code', 'remark', 'thumbs', 'linkman', 'mobile'], 'safe'],
            [['money'], 'number'],
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
        $query = HubRefundOrderModel::find();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'reason_id' => $this->reason_id,
            'transaction_id' => $this->transaction_id,
            'money' => $this->money,
            'type' => $this->type,
            'refund_status' => $this->refund_status,
            'status' => $this->status,
            'member_id' => $this->member_id,
            'goods_id' => $this->goods_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'refund_code', $this->refund_code])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'thumbs', $this->thumbs])
            ->andFilterWhere(['like', 'linkman', $this->linkman])
            ->andFilterWhere(['like', 'mobile', $this->mobile]);

        $query->orderBy(['create_time' => SORT_DESC]);
        $count = $query->count();
        $pageSize = Yii::$app->request->input('pageSize');
        $page = Yii::$app->request->input('page');
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
        $refund_status = RefundStatus::listData();
        $refund_type = RefundType::listData();
        $status = Status::listData();
        foreach ($list as $key => &$value) {
            $value['create_time'] = date('Y-m-d H:i', $value['create_time']);
            $value['type'] = $refund_type[$value['type']];
            $value['refund_status'] = $refund_status[$value['refund_status']];
            $value['status'] = $status[$value['status']];
            $value['reason_id'] = DiandiHubRefundReason::find()->where(['id' => $value['reason_id']])->asArray()->one()['reason'];
        }

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
            ],
        ]);

        return $provider;
    }
}
