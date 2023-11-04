<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-18 17:48:09
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-25 16:20:11
 */

namespace addons\diandi_tea\models\searchs\order;

use addons\diandi_tea\models\enums\CouponType;
use addons\diandi_tea\models\order\TeaCouponList as TeaCouponListModel;
use api\models\DdMember;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * TeaCouponList represents the model behind the search form of `addons\diandi_tea\models\order\TeaCouponList`.
 */
class TeaCouponList extends TeaCouponListModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'member_id', 'coupon_type', 'coupon_id', 'order_id'], 'integer'],
            [['create_time', 'update_time', 'coupon_name'], 'safe'],
            [['price'], 'number'],
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
        $query = TeaCouponListModel::find();
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
            'member_id' => $this->member_id,
            'coupon_type' => $this->coupon_type,
            'coupon_id' => $this->coupon_id,
            'order_id' => $this->order_id,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'coupon_name', $this->coupon_name]);

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

        $couponType = CouponType::listData();
        foreach ($list as $key => &$value) {
            $value['coupon_type'] = $couponType[$value['coupon_type']];
            $member = DdMember::find()->select(['username'])->where(['member_id' => $value['member_id']])->asArray()->one();
            $value['username'] =$member?$member['username']:'';
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
