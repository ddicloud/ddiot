<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 08:06:39
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-26 08:06:39
 */

namespace addons\diandi_integral;


use Yii;
use yii\db\Migration;
use common\interfaces\AddonWidget;

/**
 * 升级数据库
 *
 * Class Upgrade
 * @package addons\Merchants
 */
class Upgrade extends Migration implements AddonWidget
{
    /**
     * @var array
     */
    public array $versions = [
        '1.0.0', // 默认版本
        '1.0.1',
        '1.0.2',
    ];

    /**
     * @param $params
     * @return void
     */
    public function run($params): void
    {
        switch ($params->version) {
            case '1.0.1':
                // 增加测试 - 冗余的字段
                // $this->addColumn('{{%addon_example_curd}}', 'redundancy_field', 'varchar(48)');
                break;
            case '1.0.2':
                // 删除测试 - 冗余的字段
                // $this->dropColumn('{{%addon_example_curd}}', 'redundancy_field');
                break;
        }
    }
}
