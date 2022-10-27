<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-22 23:06:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-27 14:15:17
 */

namespace admin\models\searchs;

use admin\models\User;
use common\components\DataProvider\ArrayDataProvider;
use yii\base\Model;
use yii\data\Pagination;

/**
 * adminUser represents the model behind the search form of `admin\models\User`.
 */
class adminUser extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'store_id', 'bloc_id', 'status', 'created_at', 'updated_at', 'last_time', 'is_login'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'verification_token', 'avatar', 'last_login_ip'], 'safe'],
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
        $query = User::find();

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
            // 'bloc_id' => $this->bloc_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'last_time' => $this->last_time,
            'is_login' => $this->is_login,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'last_login_ip', $this->last_login_ip]);

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
