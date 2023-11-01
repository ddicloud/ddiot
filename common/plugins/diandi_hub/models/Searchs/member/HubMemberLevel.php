<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 21:41:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-22 22:17:59
 */
 

namespace common\plugins\diandi_hub\models\Searchs\member;

use yii\base\Model;
use common\components\DataProvider\ArrayDataProvider;
use common\plugins\diandi_hub\models\member\HubMemberLevel as HubMemberLevelModel;
use yii\data\Pagination;


/**
 * HubMemberLevel represents the model behind the search form of `common\addons\diandi_hub\models\member\HubMemberLevel`.
 */
class HubMemberLevel extends HubMemberLevelModel
{
    public $memberUsername = '';
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id', 'member_id', 'member_pid', 'level_pid_num', 'level_num','is_store', 'end_time', 'create_time', 'update_time'], 'integer'],
            [['family','memberUsername'], 'safe'],
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
        $memberUsername = $this->memberUsername; 
        
        $query = HubMemberLevelModel::find()
                ->with(['level','levelParent','member','memberParent','wxappfans','wechatfans','store']);

        $query->joinWith('member as member');

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
            'is_store' => $this->is_store,
            'member.member_id' => $this->member_id,
            'member_pid' => $this->member_pid,
            'level_pid_num' => $this->level_pid_num,
            'level_num' => $this->level_num,
            'end_time' => $this->end_time,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'family', $this->family])
              ->andFilterWhere(['like','member.username',$this->memberUsername]);
        
        $count = $query->count();
        
        $pageSize   = Yii::$app->request->input('pageSize',10);
        $page       = \Yii::$app->request->input('page',1);
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
            'key'=>'id',
            'allModels' => $list,
            'totalCount' => isset($count) ? $count : 0,
            'total'=> isset($count) ? $count : 0,
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
