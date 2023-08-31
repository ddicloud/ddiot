<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:10:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-05-08 17:33:22
 */
 

namespace addons\diandi_ai;

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
     * @return mixed|void
     * @throws \yii\db\Exception
     */
    public function run($params)
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
