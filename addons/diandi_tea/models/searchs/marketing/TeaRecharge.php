<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-22 10:41:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-28 16:12:28
 */

namespace addons\diandi_tea\models\searchs\marketing;

use addons\diandi_tea\models\marketing\TeaRecharge as TeaRechargeModel;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * TeaRecharge represents the model behind the search form of `addons\diandi_tea\models\marketing\TeaRecharge`.
 */
class TeaRecharge extends TeaRechargeModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'type'], 'integer'],
            [['create_time', 'update_time', 'give_coupon_ids'], 'safe'],
            [['price', 'give_money'], 'number'],
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
        $query = TeaRechargeModel::find();

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
            'price' => $this->price,
            'give_money' => $this->give_money,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'give_coupon_ids', $this->give_coupon_ids]);

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

        foreach ($list as $key => &$value) {
            if ($value['give_coupon_ids']) {
                $give_coupon_ids = explode(',', $value['give_coupon_ids']);
                $data = TeaCoupon::find()->select(['name'])->where(['id' => $give_coupon_ids])->asArray()->all();
                $new = [];
                foreach ($data as $a => $b) {
                    $new[] = $b['name'];
                }
                $value['give_coupon_name'] = implode(',', $new);
            }
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
