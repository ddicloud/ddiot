<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-28 18:52:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 19:54:23
 */

use yii\db\Migration;

class m220628_105254_website_article_category extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');

        /* 创建表 */
        $this->createTable('{{%website_article_category}}', [
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'bloc_id' => 'int(11) NULL',
            'store_id' => 'int(11) NULL',
            'title' => "varchar(30) NOT NULL COMMENT '名称'",
            'displayorder' => "tinyint(3) unsigned NOT NULL COMMENT '排序'",
            'pcate' => "int(11) NULL DEFAULT '0' COMMENT '父级'",
            'type' => "varchar(15) NOT NULL COMMENT '英文标识'",
            'create_time' => 'int(11) NULL',
            'update_time' => 'int(11) NULL',
            'PRIMARY KEY (`id`)',
        ], "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章分类'");

        /* 索引设置 */
        $this->createIndex('type', '{{%website_article_category}}', 'type', 0);

        /* 表数据 */
        $this->insert('{{%website_article_category}}', ['id' => '14', 'bloc_id' => null, 'store_id' => null, 'title' => '关于我们', 'displayorder' => '1', 'pcate' => '10', 'type' => 'about', 'create_time' => null, 'update_time' => null]);
        $this->insert('{{%website_article_category}}', ['id' => '8', 'bloc_id' => null, 'store_id' => null, 'title' => '智能设备', 'displayorder' => '1', 'pcate' => '10', 'type' => 'facility', 'create_time' => null, 'update_time' => null]);
        $this->insert('{{%website_article_category}}', ['id' => '9', 'bloc_id' => null, 'store_id' => null, 'title' => '应用场景', 'displayorder' => '1', 'pcate' => '10', 'type' => 'scene', 'create_time' => null, 'update_time' => null]);
        $this->insert('{{%website_article_category}}', ['id' => '10', 'bloc_id' => null, 'store_id' => null, 'title' => '网站内容', 'displayorder' => '1', 'pcate' => '0', 'type' => 'website', 'create_time' => null, 'update_time' => null]);
        $this->insert('{{%website_article_category}}', ['id' => '11', 'bloc_id' => null, 'store_id' => null, 'title' => '特色优势', 'displayorder' => '1', 'pcate' => '10', 'type' => 'superiority', 'create_time' => null, 'update_time' => null]);
        $this->insert('{{%website_article_category}}', ['id' => '12', 'bloc_id' => null, 'store_id' => null, 'title' => '开源内容', 'displayorder' => '1', 'pcate' => '10', 'type' => 'open', 'create_time' => null, 'update_time' => null]);
        $this->insert('{{%website_article_category}}', ['id' => '13', 'bloc_id' => null, 'store_id' => null, 'title' => '方案介绍', 'displayorder' => '1', 'pcate' => '10', 'type' => 'website1', 'create_time' => null, 'update_time' => null]);

        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%website_article_category}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
