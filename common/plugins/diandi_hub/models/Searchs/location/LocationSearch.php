<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-05 12:40:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:14:12
 */

namespace common\plugins\diandi_hub\models\Searchs\location;

use common\plugins\diandi_hub\models\advertising\HubLocation;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * LocationSearch represents the model behind the search form of `common\addons\diandi_hub\models\HubLocation`.
 */
class LocationSearch extends HubLocation
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'store_id', 'bloc_id', 'maxnum', 'is_show'], 'integer'],
            [['name', 'mark'], 'safe'],
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
        $query = HubLocation::find();

        $this->load($params);

        if (!$this->validate()) {
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'store_id' => $this->store_id,
            'bloc_id' => $this->bloc_id,
            'maxnum' => $this->maxnum,
            'is_show' => $this->is_show,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'mark', $this->mark]);

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

        $dataProvider = new ArrayDataProvider([
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

        return $dataProvider;
    }
}
