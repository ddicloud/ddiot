<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-26 10:34:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-26 11:24:48
 */


namespace addons\diandi_tea\models\searchs\marketing;

use addons\diandi_tea\models\enums\CouponType;
use addons\diandi_tea\models\enums\ReceiveType;
use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use addons\diandi_tea\models\marketing\TeaMemberCoupon as TeaMemberCouponModel;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;


/**
 * TeaMemberCoupon represents the model behind the search form of `addons\diandi_tea\models\marketing\TeaMemberCoupon`.
 */
class TeaMemberCoupon extends TeaMemberCouponModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'member_id', 'coupon_type', 'coupon_id', 'use_num', 'surplus_num', 'receive_type'], 'integer'],
            [['create_time', 'update_time', 'coupon_name', 'buy_time', 'end_time', 'use_time'], 'safe'],
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
     * Creates data provider instance with a search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider|false
     */
    public function search(array $params): ArrayDataProvider|bool
   {
        $query = TeaMemberCouponModel::find();
        $query->with('member');
    
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
            'buy_time' => $this->buy_time,
            'end_time' => $this->end_time,
            'use_time' => $this->use_time,
            'use_num' => $this->use_num,
            'surplus_num' => $this->surplus_num,
            'receive_type' => $this->receive_type,
        ]);

        $query->andFilterWhere(['like', 'coupon_name', $this->coupon_name]);
        
        $count = $query->count();
        $pageSize   =\Yii::$app->request->input('pageSize');
        $page       =\Yii::$app->request->input('page');
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
        
        $CouponType = CouponType::listData();
        $ReceiveType = ReceiveType::listData();
        foreach ($list as $key => &$value) {
           $value['coupon_type'] = $CouponType[$value['coupon_type']];
           $value['receive_type'] = $ReceiveType[$value['receive_type']];
        }

        return new ArrayDataProvider([
            'key'=>'id',
            'allModels' => $list,
             'totalCount' => $count,
            'total'=> $count,
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
        
    }
}
