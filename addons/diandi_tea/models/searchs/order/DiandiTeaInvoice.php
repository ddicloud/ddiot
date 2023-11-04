<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-07 16:01:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-09 14:31:56
 */

namespace addons\diandi_tea\models\searchs\order;

use addons\diandi_tea\models\order\TeaInvoice;
use api\models\DdMember;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * DiandiTeaInvoice represents the model behind the search form of `addons\diandi_tea\models\order\TeaInvoice`.
 */
class DiandiTeaInvoice extends TeaInvoice
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'order_id', 'status', 'member_id', 'type'], 'integer'],
            [['create_time', 'update_time', 'invoice_url', 'company', 'social_code', 'phone', 'email', 'bank', 'bank_address', 'company_address', 'taxpayer_no'], 'safe'],
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
        $query = TeaInvoice::find();

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
            'status' => $this->status,
            'member_id' => $this->member_id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'invoice_url', $this->invoice_url])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'social_code', $this->social_code])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email]);

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
            $value['invoice_url'] = unserialize($value['invoice_url']);
            $value['username'] = DdMember::find()->where(['member_id' => $value['member_id']])->asArray()->one()['username'];
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
