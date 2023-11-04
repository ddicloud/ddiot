<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-16 10:30:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-13 17:16:09
 */

namespace addons\diandi_tea;

use common\interfaces\AddonWidget;
use yii\db\Migration;

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
     * @param $params
     *
     * @return void
     *
     */
    public function run($params): void
    {
        switch ($params->version) {
            case '1.0.1':
                // 增加测试 - 冗余的字段
                // $this->addColumn('{{%addon_example_curd}}', 'field1', 'varchar(48)');
                break;
            case '1.0.2':
                // 删除测试 - 冗余的字段
                // $this->dropColumn('{{%addon_example_curd}}', 'field2');
                break;
        }
    }
}
