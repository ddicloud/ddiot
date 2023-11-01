<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-21 10:15:36
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:23:38
 */


namespace common\plugins\diandi_hub\models\Searchs\level;

use common\plugins\diandi_hub\models\level\DiandiHubLevelCondition as LevelDiandiHubLevelCondition;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\Pagination;

/**
 * DiandiHubLevelCondition represents the model behind the search form of `common\addons\diandi_hub\models\level\DiandiHubLevelCondition`.
 */
class DiandiHubLevelCondition extends LevelDiandiHubLevelCondition
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'levelnum', 'levelcnum', 'levelc_num', 'levelc_saletotal', 'condition', 'create_time', 'update_time'], 'integer'],
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
        $query = LevelDiandiHubLevelCondition::find();
        $levelnum = intval(Yii::$app->request->input('levelnum'));
        if($levelnum){
            $this->levelnum =$levelnum;
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return false;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'levelnum' => $this->levelnum,
            'levelcnum' => $this->levelcnum,
            'levelc_num' => $this->levelc_num,
            'levelc_saletotal' => $this->levelc_saletotal,
            'condition' => $this->condition,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

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
            ],
        ]);

        return $provider;
    }
}
