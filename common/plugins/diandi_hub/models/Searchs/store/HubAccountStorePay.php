<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-20 01:00:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-26 16:34:49
 */

namespace common\plugins\diandi_hub\models\Searchs\store;

use common\plugins\diandi_hub\models\enums\StorePayStatus;
use common\plugins\diandi_hub\models\store\HubAccountStorePay as HubAccountStorePayModel;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\Pagination;

/**
 * HubAccountStorePay represents the model behind the search form of `common\addons\diandi_hub\models\store\HubAccountStorePay`.
 */
class HubAccountStorePay extends HubAccountStorePayModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'member_id', 'operation_mid', 'status', 'affirm_mid', 'pay_time', 'update_time', 'create_time'], 'integer'],
            [['order_no', 'remark', 'transaction_id'], 'safe'],
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
        $query = HubAccountStorePayModel::find()
                    ->with(['member', 'affirm', 'operation']);

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
            'operation_mid' => $this->operation_mid,
            'money' => $this->money,
            'status' => $this->status,
            'affirm_mid' => $this->affirm_mid,
            'pay_time' => $this->pay_time,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id]);

        $query->orderBy(['create_time' => SORT_DESC]);

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
        // var_dump($query->createCommand()->getRawSql());
        // die;

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        $status = StorePayStatus::listData();
        foreach ($list as $key => &$value) {
            $value['create_time'] = date('Y-m-d H:i', $value['create_time']);
            $value['status'] = $status[$value['status']];
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
