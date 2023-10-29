<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-23 15:45:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-01 02:30:30
 */

namespace common\plugins\diandi_hub;

use yii\db\Migration;
use common\interfaces\AddonWidget;

/**
 * 升级数据库.
 *
 * Class Upgrade
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
     * @param $config
     * @return void
     *
     */
    public function run($config): void
    {
        switch ($config->version) {
            case '1.0.1':
                // 增加测试 - 冗余的字段
                 $this->addColumn('{{%addon_example_curd}}', 'redundancy_field', 'varchar(48)');
                break;
            case '1.0.2':
                // 删除测试 - 冗余的字段
                // $this->dropColumn('{{%addon_example_curd}}', 'redundancy_field');
                break;
        }
    }
}
