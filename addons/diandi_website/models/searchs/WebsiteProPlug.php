<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-07 09:09:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-07 12:01:01
 */

namespace addons\diandi_website\models\searchs;

use addons\diandi_website\models\WebsiteProPlug as WebsiteProPlugModel;
use common\components\DataProvider\ArrayDataProvider;
use common\helpers\ImageHelper;
use yii\base\Model;
use yii\data\Pagination;

/**
 * WebsiteProPlug represents the model behind the search form of `addons\diandi_website\models\WebsiteProPlug`.
 */
class WebsiteProPlug extends WebsiteProPlugModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'store_id', 'bloc_id'], 'integer'],
            [['create_time', 'update_time', 'logo', 'title', 'content'], 'safe'],
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
        $query = WebsiteProPlugModel::find();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'store_id' => $this->store_id,
            'bloc_id' => $this->bloc_id,
        ]);

        $query->andFilterWhere(['like', 'create_time', $this->create_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

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
            $value['logo'] = ImageHelper::tomedia($value['logo']);
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
