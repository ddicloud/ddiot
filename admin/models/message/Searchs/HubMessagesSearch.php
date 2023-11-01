<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-18 17:50:20
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-05 19:57:36
 */

namespace admin\models\message\Searchs;

use admin\models\message\HubMessages;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\Pagination;

/**
 * HubMessagesSearch represents the model behind the search form of `addons\diandi_hub\models\HubMessages`.
 */
class HubMessagesSearch extends HubMessages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bloc_id', 'store_id', 'category_id', 'view', 'status'], 'integer'],
            [['title', 'content', 'admin_ids', 'publish_at', 'created_at', 'updated_at'], 'safe'],
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
        $query = HubMessages::find();

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
            'category_id' => $this->category_id,
            'view' => $this->view,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'admin_ids', $this->admin_ids])
            ->andFilterWhere(['like', 'publish_at', $this->publish_at]);

        $count = $query->count();
        $pageSize =\Yii::$app->request->input('pageSize',10);
        $page = \Yii::$app->request->input('page',1);
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        //foreach ($list as $key => &$value) {
        //    $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //    $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        //}

        $provider = new ArrayDataProvider([
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

        return $provider;
    }

    public function searchList($params)
   {
        $query = HubMessages::find();

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
            'category_id' => $this->category_id,
            'view' => $this->view,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'admin_ids', $this->admin_ids])
            ->andFilterWhere(['like', 'publish_at', $this->publish_at]);
        $query->andWhere('find_in_set(' . \Yii::$app->user->identity->user_id . ', admin_ids) OR admin_ids = ""');
        $count = $query->count();
        $pageSize =\Yii::$app->request->input('pageSize',10);
        $page = \Yii::$app->request->input('page',1);
        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('publish_at DESC')
            ->with(['currentUserRead'])
        // ->createCommand()
        // ->getRawSql();
            ->asArray()
            ->all();

        //foreach ($list as $key => &$value) {
        //    $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        //    $value['update_time'] = date('Y-m-d H:i:s',$value['update_time']);
        //}

        $provider = new ArrayDataProvider([
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

        return $provider;
    }
}
