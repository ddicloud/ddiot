<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-01 15:38:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-24 16:27:00
 */
 

namespace common\plugins\diandi_hub\models\store;

use admin\models\addons\models\Bloc;
use common\models\DdMember;
use common\models\DdUser;
use diandi\addons\models\BlocStore;
use Yii;

/**
 * This is the model class for table "dd_diandi_hub_store_user".
 *
 * @public int $id
 * @public int|null $member_id 会员ID
 * @public int|null $store_id 商户ID
 * @public int $bloc_id 公司ID
 * @public int|null $status 员工状态
 * @public string|null $name 员工姓名
 * @public string|null $mobile 手机号
 * @public int|null $create_time
 * @public int|null $update_time
 */
class HubStoreUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_hub_store_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['member_id', 'store_id', 'bloc_id', 'status', 'create_time', 'update_time'], 'integer'],
            [['bloc_id'], 'required'],
            [['name', 'mobile'], 'string', 'max' => 30],
        ];
    }

    /**
     * 行为.
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }

    public function getStore()
    {
        return $this->hasOne(BlocStore::class,['store_id'=>'store_id']); 
    }

    public function getBloc()
    {
        return $this->hasOne(Bloc::class,['bloc_id'=>'bloc_id']); 
    }

    public function getMember()
    {
        return $this->hasOne(DdUser::class,['id'=>'member_id']); 
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员ID',
            'store_id' => '商户ID',
            'bloc_id' => '公司ID',
            'status' => '员工状态',
            'name' => '员工姓名',
            'mobile' => '手机号',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
