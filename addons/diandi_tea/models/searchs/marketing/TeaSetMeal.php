<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-17 11:33:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-08 11:51:08
 */

namespace addons\diandi_tea\models\searchs\marketing;

use addons\diandi_tea\models\enums\SetMealType;
use addons\diandi_tea\models\marketing\TeaSetMeal as TeaSetMealModel;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * TeaSetMeal represents the model behind the search form of `addons\diandi_tea\models\marketing\TeaSetMeal`.
 */
class TeaSetMeal extends TeaSetMealModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'duration', 'type'], 'integer'],
            [['create_time', 'update_time', 'title'], 'safe'],
            [['price', 'renew_price'], 'number'],
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
        $query = TeaSetMealModel::find();

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
            'duration' => $this->duration,
            'price' => $this->price,
            'renew_price' => $this->renew_price,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

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

        $list = $query
            ->asArray()
            ->all();

        // $list = $query->offset($pagination->offset)
        // ->limit($pagination->limit)
        // ->asArray()
        // ->all();

        $SetMealType = SetMealType::listData();
        foreach ($list as $key => &$value) {
            $value['type_str'] = $SetMealType[$value['type']];
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
