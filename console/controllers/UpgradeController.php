<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:14:43
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-05-03 00:17:35
 */
 

namespace console\controllers;
 

use Yii;
use yii\db\Migration;
use common\interfaces\AddonWidget;
use yii\console\controllers\MigrateController;

/**
 * 升级数据库
 *
 * Class Upgrade
 * @package addons\Merchants
 */
class UpgradeController extends \yii\console\Controller
{

    /**
     * @return void
     */
    public function actionIndex(): void
    {
        $Migration = new Migration();
        
        $version = Yii::$app->version;
        
        switch ($version) {
            case '1.0.0':
                // 增加测试 - 冗余的字段
                $Migration->addColumn('{{%ceshi}}', 'field1', 'varchar(48)');
                break;
            case '1.0.1':
                // 删除测试 - 冗余的字段
                $Migration->update('{{%auth_route}}', ['module_name'=>'system'], ['module_name'=>'sys']);
                $Migration->update('{{%auth_menu}}', ['module_name'=>'system'], ['module_name'=>'sys']);
                // $this->dropColumn('{{%addon_example_curd}}', 'field2');
                break;
                
        }
    }
   
}
