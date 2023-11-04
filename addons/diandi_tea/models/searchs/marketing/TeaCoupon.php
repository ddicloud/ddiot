<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-17 09:49:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-01 09:46:45
 */

namespace addons\diandi_tea\models\searchs\marketing;

use addons\diandi_tea\models\enums\CouponType;
use addons\diandi_tea\models\marketing\TeaCoupon as TeaCouponModel;
use common\components\DataProvider\ArrayDataProvider;
use common\helpers\ImageHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * TeaCoupon represents the model behind the search form of `addons\diandi_tea\models\marketing\TeaCoupon`.
 */
class TeaCoupon extends TeaCouponModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'type', 'use_num', 'all_num', 'max_num'], 'integer'],
            [['create_time', 'update_time', 'name', 'explain', 'use_start', 'use_end', 'enable_start', 'enable_end', 'max_time', 'enable_store', 'enable_week', 'third_party', 'background', 'coupon_img', 'use_hourse'], 'safe'],
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
     * @return ArrayDataProvider|bool|ActiveDataProvider
     */
    public function search(array $params): ArrayDataProvider|bool|ActiveDataProvider
   {
        $query = TeaCouponModel::find();

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
            'type' => $this->type,
            'price' => $this->price,
            'use_start' => $this->use_start,
            'use_end' => $this->use_end,
            'enable_start' => $this->enable_start,
            'enable_end' => $this->enable_end,
            'use_num' => $this->use_num,
            'all_num' => $this->all_num,
            'max_num' => $this->max_num,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'explain', $this->explain])
            ->andFilterWhere(['like', 'max_time', $this->max_time])
            ->andFilterWhere(['like', 'enable_store', $this->enable_store])
            ->andFilterWhere(['like', 'enable_week', $this->enable_week])
            ->andFilterWhere(['like', 'third_party', $this->third_party]);

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

        $CouponType = CouponType::listData();

        foreach ($list as &$value) {
            $value['background'] = ImageHelper::tomedia($value['background']);
            $value['type_str'] = $CouponType[$value['type']];
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
