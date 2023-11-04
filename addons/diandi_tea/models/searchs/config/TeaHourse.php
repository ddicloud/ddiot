<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-16 15:08:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-13 09:46:44
 */

namespace addons\diandi_tea\models\searchs\config;

use addons\diandi_tea\models\config\TeaHourse as TeaHourseModel;
use addons\diandi_tea\models\enums\HoursesStatus;
use common\components\DataProvider\ArrayDataProvider;
use common\helpers\ImageHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * TeaHourse represents the model behind the search form of `addons\diandi_tea\models\config\TeaHourse`.
 */
class TeaHourse extends TeaHourseModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'max_num', 'status'], 'integer'],
            [['create_time', 'update_time', 'name', 'picture', 'introduce', 'tip', 'set_meal_ids', 'slide'], 'safe'],
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
        $query = TeaHourseModel::find();

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
            'max_num' => $this->max_num,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'picture', $this->picture])
            ->andFilterWhere(['like', 'introduce', $this->introduce])
            ->andFilterWhere(['like', 'tip', $this->tip])
            ->andFilterWhere(['like', 'set_meal_ids', $this->set_meal_ids]);

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

        $HourseStatus = HoursesStatus::listData();
        foreach ($list as &$value) {
            $value['picture'] = ImageHelper::tomedia($value['picture']);
            $value['status_str'] = $HourseStatus[$value['status']];
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
