<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 19:45:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-20 23:10:39
 */

namespace common\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dd_region".
 *
 * @public int         $id
 * @public int|null    $pid
 * @public string|null $shortname
 * @public string|null $name
 * @public string|null $merger_name
 * @public int|null    $level
 * @public string|null $pinyin
 * @public string|null $code
 * @public string|null $zip_code
 * @public string|null $first
 * @public string|null $lng
 * @public string|null $lat
 */
class DdRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'level'], 'integer'],
            [['shortname', 'name', 'pinyin', 'code', 'zip_code', 'lng', 'lat'], 'string', 'max' => 100],
            [['merger_name'], 'string', 'max' => 255],
            [['first'], 'string', 'max' => 50],
        ];
    }

    public static function getRegion($parentId = 0)
    {
        $result = static::find()->where(['pid' => $parentId])->asArray()->all();

        return ArrayHelper::map($result, 'id', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'shortname' => 'Shortname',
            'name' => 'Name',
            'merger_name' => '具体地址',
            'level' => 'Level',
            'pinyin' => 'Pinyin',
            'code' => 'Code',
            'zip_code' => 'Zip Code',
            'first' => 'First',
            'lng' => 'Lng',
            'lat' => 'Lat',
        ];
    }
}
