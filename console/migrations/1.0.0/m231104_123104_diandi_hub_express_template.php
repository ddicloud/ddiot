<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_express_template extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_express_template}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'title' => "varchar(255) NULL COMMENT '模板名称'",
            'express_id' => "int(11) NULL COMMENT '快递id'",
            'bynum_snum' => "int(11) NULL COMMENT '首件'",
            'bynum_sprice' => "int(11) NULL DEFAULT '0' COMMENT '首件运费'",
            'bynum_xnum' => "int(11) NULL COMMENT '续件'",
            'bynum_xprice' => "int(11) NULL COMMENT '续件费用'",
            'bynum_is_use' => "int(11) NULL COMMENT '是否计件收费'",
            'weight_snum' => "int(11) NULL COMMENT '首重'",
            'weight_sprice' => "int(11) NULL COMMENT '首重费用'",
            'weight_xnum' => "int(11) NULL COMMENT '续重'",
            'weight_xprice' => "int(11) NULL COMMENT '续重费用'",
            'weight_is_use' => "int(11) NULL COMMENT '是否计重收费'",
            'volume_snum' => "int(11) NULL COMMENT '首体积量'",
            'volume_sprice' => "int(11) NULL COMMENT '首体积运费'",
            'volume_xnum' => "int(11) NULL COMMENT '续体积'",
            'volume_xprice' => "int(11) NULL COMMENT '续体积运费'",
            'volume_is_use' => "int(11) NULL COMMENT '是否计体积收费'",
            'is_default' => "int(11) NULL COMMENT '是否默认'",
            'is_nationwide' => "int(11) NULL DEFAULT '0' COMMENT '是否全国'",
            'create_time' => "int(11) NULL",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_express_template}}',['id'=>'17','title'=>'模板1','express_id'=>'3','bynum_snum'=>'10','bynum_sprice'=>'10','bynum_xnum'=>'10','bynum_xprice'=>'10','bynum_is_use'=>NULL,'weight_snum'=>'10','weight_sprice'=>'10','weight_xnum'=>'10','weight_xprice'=>'10','weight_is_use'=>NULL,'volume_snum'=>'10','volume_sprice'=>'10','volume_xnum'=>'10','volume_xprice'=>'10','volume_is_use'=>NULL,'is_default'=>'1','is_nationwide'=>'0','create_time'=>'1655346651','update_time'=>'1655372380']);
        $this->insert('{{%diandi_hub_express_template}}',['id'=>'19','title'=>'顺丰模板','express_id'=>'1','bynum_snum'=>'10','bynum_sprice'=>'10','bynum_xnum'=>'10','bynum_xprice'=>'10','bynum_is_use'=>NULL,'weight_snum'=>'10','weight_sprice'=>'10','weight_xnum'=>'10','weight_xprice'=>'10','weight_is_use'=>NULL,'volume_snum'=>'10','volume_sprice'=>'10','volume_xnum'=>'10','volume_xprice'=>'10','volume_is_use'=>NULL,'is_default'=>'1','is_nationwide'=>'0','create_time'=>'1655371560','update_time'=>'1655371560']);
        $this->insert('{{%diandi_hub_express_template}}',['id'=>'20','title'=>'测试模板','express_id'=>'2','bynum_snum'=>'10','bynum_sprice'=>'10','bynum_xnum'=>'10','bynum_xprice'=>'10','bynum_is_use'=>NULL,'weight_snum'=>'10','weight_sprice'=>'10','weight_xnum'=>'1010','weight_xprice'=>'10','weight_is_use'=>NULL,'volume_snum'=>'10','volume_sprice'=>'10','volume_xnum'=>'10','volume_xprice'=>'10','volume_is_use'=>NULL,'is_default'=>'1','is_nationwide'=>'0','create_time'=>'1655371628','update_time'=>'1655372390']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_express_template}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

