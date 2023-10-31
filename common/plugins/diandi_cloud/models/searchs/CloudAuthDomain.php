<?php

namespace common\plugins\diandi_cloud\models\searchs;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\plugins\diandi_cloud\models\CloudAuthDomain as CloudAuthDomainModel;
use yii\data\Pagination;


/**
 * CloudAuthDomain represents the model behind the search form of `addons\diandi_cloud\models\CloudAuthDomain`.
 */
class CloudAuthDomain extends CloudAuthDomainModel
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'member_id', 'status', 'create_time', 'update_time'], 'integer'],
            [['domin_url', 'start_time', 'end_time'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider

     */
    public function search($params)
    {
        global $_GPC;
        $memberSearch = $_GPC['MemberSearch'] ?? [];
        $query = CloudAuthDomainModel::find();
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'member_id' => $this->member_id,
            'status' => $this->status,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'domin_url', $this->domin_url])
            ->joinWith(['member' => function ($query) use ($memberSearch) {
                $query->andFilterWhere(['like', 'dd_member.username', $memberSearch['username']])
                    ->andFilterWhere(['like', 'dd_member.mobile', $memberSearch['mobile']]);
            }]);

        $count = $query->count();
        $pageSize   = $_GPC['pageSize']??10;
        $page       = $_GPC['page']??1;
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

        //foreach ($list as $key => &$value) {
        //    $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //    $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        //} 


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
            ]
        ]);

        return $provider;
    }
}
