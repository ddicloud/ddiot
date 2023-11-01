<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-14 09:32:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-14 11:48:22
 */

namespace common\plugins\diandi_hub\models\Searchs\goods;

use common\plugins\diandi_hub\models\goods\HubCategory;
use common\plugins\diandi_hub\models\goods\HubSpec;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\Pagination;

/**
 * HubSpecSearchs represents the model behind the search form of `addons\diandi_hub\models\goods\HubSpec`.
 */
class HubSpecSearchs extends HubSpec
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['spec_id', 'bloc_id', 'store_id', 'wxapp_id', 'create_time'], 'integer'],
            [['spec_name'], 'safe'],
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
        $query = HubSpec::find();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'spec_id' => $this->spec_id,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id,
            'wxapp_id' => $this->wxapp_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'spec_name', $this->spec_name]);

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
            $value['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $value['update_time'] = date('Y-m-d H:i:s', $value['update_time']);
            if ($value['category_id']) {
                $value['category_name'] = HubCategory::find()->where(['category_id' => $value['category_id']])->select('name')->scalar();
            } else {
                $value['category_name'] = '';
            }
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
