<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-07 09:22:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-22 09:07:05
 */

namespace common\plugins\diandi_cloud\models;

/**
 * This is the model class for table "{{%diandi_cloud_addons}}".
 *
 * @public int         $id          模块id
 * @public int|null    $is_nav      是否导航
 * @public string      $identifie   英文标识
 * @public string|null $type        模块类型
 * @public string      $title       名称
 * @public string      $version     版本
 * @public string      $ability     简介
 * @public string      $description 描述
 * @public string      $author      作者
 * @public string      $url         社区地址
 * @public int         $settings    配置
 * @public string      $logo        logo
 * @public string|null $versions    适应的软件版本
 * @public int|null    $is_install
 * @public string|null $parent_mids
 * @public int         $cate_id     分类ID
 * @public string      $applets     小程序二维码
 */
class CloudAddons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_cloud_addons}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['is_nav', 'settings', 'is_install', 'cate_id', 'mid'], 'integer'],
            [['identifie', 'title', 'version', 'ability', 'description', 'author', 'url', 'logo', 'cate_id'], 'required'],
            [['identifie', 'title'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 30],
            [['version'], 'string', 'max' => 15],
            [['ability'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 1000],
            [['author', 'versions'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 255],
            [['logo', 'parent_mids'], 'string', 'max' => 250],
            [['applets'], 'string', 'max' => 180],
            ['cate_id', 'exist', 'targetClass' => 'addons\diandi_cloud\models\CloudAddonsCate', 'targetAttribute' => 'id', 'message' => '所选分类不存在'],
            ['mid', 'exist', 'targetClass' => 'diandi\addons\models\DdAddons', 'targetAttribute' => 'mid', 'message' => '所选系统模块不存在'],
        ];
    }

    public function getCate()
    {
        return $this->hasMany(CloudAddonsCate::class, ['id' => 'cate_id']);
    }

    public function getDdAddons()
    {
        return $this->hasMany(\diandi\addons\models\DdAddons::class, ['mid' => 'mid']);
    }

    /**
     * 行为.
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '模块id',
            'mid' => '系统模块ID',
            'is_nav' => '是否导航',
            'identifie' => '英文标识',
            'type' => '模块类型',
            'title' => '名称',
            'version' => '版本',
            'ability' => '简介',
            'description' => '描述',
            'author' => '作者',
            'url' => '社区地址',
            'settings' => '配置',
            'logo' => 'logo',
            'versions' => '适应的软件版本',
            'is_install' => 'Is Install',
            'parent_mids' => 'Parent Mids',
            'cate_id' => '分类ID',
            'applets' => '小程序二维码',
        ];
    }
}
