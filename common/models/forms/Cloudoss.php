<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-11-29 18:27:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-10 21:18:17
 */

/***
 * @开源软件: 店滴AI-基于AI的软硬件开源解决方案
 * @官方地址: http://www.wayfirer.com/
 * @版本: 1.0
 * @邮箱: 2192138785@qq.com
 * @作者: Wang Chunsheng
 * @Date: 2020-02-28 22:38:40
 * @LastEditTime: 2020-04-25 18:05:07
 */

namespace common\models\forms;

use yii\base\Model;

class Cloudoss extends Model
{
    public $Access_Key_ID;
    public $Access_Key_Secret;
    public $is_intranet;
    public $domain;

    public function rules(): array
    {
        return [
            [['Access_Key_ID', 'Access_Key_Secret', 'is_intranet', 'domain'], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'Access_Key_ID' => 'Access Key ID',
            'Access_Key_Secret' => 'Access Key Secret',
            'is_intranet' => '内网上传',
            'domain' => '自定义URL',
        ];
    }
}
