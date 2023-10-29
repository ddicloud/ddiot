<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-18 22:13:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-18 22:13:57
 */
 


namespace common\plugins\diandi_hub\models\advertising;

/**
 * This is the model class for table "dd_diandi_hub_index_menu".
 *
 * @public int         $id           id
 * @public string      $name         按钮名称
 * @public int         $url          链接地址
 * @public string|null $thumb        图片
 * @public string|null $displayorder 排序
 * @public int|null    $status       状态
 * @public int|null    $update_time  更新时间
 * @public int|null    $create_time  创建时间
 */
class DiandiHubIndexMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_hub_index_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['url'], 'required'],
            [[ 'status', 'update_time', 'create_time'], 'integer'],
            [['name','url', 'thumb', 'displayorder','query'], 'string', 'max' => 255],
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '按钮名称',
            'url' => '链接地址',
            'query' => '参数',
            'thumb' => '图标',
            'displayorder' => '排序',
            'status' => '是否启用',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }
}
