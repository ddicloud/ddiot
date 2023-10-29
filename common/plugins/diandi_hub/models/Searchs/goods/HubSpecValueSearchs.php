<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-14 09:32:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-14 18:19:31
 */

namespace common\plugins\diandi_hub\models\Searchs\goods;

use common\plugins\diandi_hub\models\goods\HubSpec;
use common\plugins\diandi_hub\models\goods\HubSpecValue;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\Pagination;

/**
 * HubSpecValueSearchs represents the model behind the search form of `addons\diandi_hub\models\goods\HubSpecValue`.
 */
class HubSpecValueSearchs extends HubSpecValue
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['spec_value_id', 'store_id', 'bloc_id', 'spec_id', 'create_time'], 'integer'],
            [['spec_value', 'category_ids'], 'safe'],
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
        $query = HubSpecValue::find();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'spec_value_id' => $this->spec_value_id,
            'store_id' => $this->store_id,
            'bloc_id' => $this->bloc_id,
            'spec_id' => $this->spec_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'spec_value', $this->spec_value]);

        $count = $query->count();
        $pageSize = $_GPC['pageSize'];
        $page = $_GPC['page'];
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
            $value['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $value['update_time'] = date('Y-m-d H:i:s', $value['update_time']);
            $value['spec_name'] = HubSpec::find()->where(['spec_id' => $value['spec_id']])->select('spec_name')->scalar();
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
