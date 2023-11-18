<?php

use yii\db\Migration;

class m231118_000434_diandi_mall_account_member extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_mall_account_member}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'member_id' => "int(11) NULL COMMENT '会员ID'",
            'self_money' => "decimal(11,2) NOT NULL COMMENT '个人奖金'",
            'self_withdraw' => "decimal(11,2) NOT NULL COMMENT '个人已提现'",
            'self_freeze' => "decimal(11,2) NOT NULL COMMENT '个人冻结'",
            'team_money' => "decimal(11,2) NOT NULL COMMENT '团队奖金'",
            'team_withdraw' => "decimal(11,2) NOT NULL COMMENT '团队奖金提现'",
            'team_freeze' => "decimal(11,2) NOT NULL COMMENT '团队奖金冻结'",
            'store_money' => "decimal(11,2) NOT NULL COMMENT '店铺收益'",
            'store_withdraw' => "decimal(11,2) NOT NULL COMMENT '店铺可提现'",
            'store_freeze' => "decimal(11,2) NOT NULL COMMENT '店铺收益冻结'",
            'agent_money' => "decimal(11,2) NOT NULL COMMENT '代理收益'",
            'agent_withdraw' => "decimal(11,2) NOT NULL COMMENT '代理可提现'",
            'agent_freeze' => "decimal(11,2) NOT NULL COMMENT '代理奖金冻结'",
            'water_money' => "decimal(11,2) NULL",
            'water_withdraw' => "decimal(11,2) NULL",
            'water_freeze' => "decimal(11,2) NULL",
            'create_time' => "int(11) NULL COMMENT '注册时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_mall_account_member}}','member_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'1','bloc_id'=>'13','store_id'=>'0','member_id'=>'2','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1657683327','update_time'=>'1657683327']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'2','bloc_id'=>'13','store_id'=>'0','member_id'=>'4','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1657789272','update_time'=>'1657789272']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'3','bloc_id'=>'13','store_id'=>'0','member_id'=>'3','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1657789292','update_time'=>'1657789292']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'4','bloc_id'=>'13','store_id'=>'0','member_id'=>'6','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1657792389','update_time'=>'1657792389']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'5','bloc_id'=>'13','store_id'=>'0','member_id'=>'7','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1657794130','update_time'=>'1657794130']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'6','bloc_id'=>'13','store_id'=>'0','member_id'=>'8','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1658114130','update_time'=>'1658114130']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'7','bloc_id'=>'13','store_id'=>'0','member_id'=>'9','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1658223372','update_time'=>'1658223372']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'8','bloc_id'=>'13','store_id'=>'0','member_id'=>'10','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1658224538','update_time'=>'1658224538']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'9','bloc_id'=>'13','store_id'=>'0','member_id'=>'11','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1658398856','update_time'=>'1658398856']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'10','bloc_id'=>'13','store_id'=>'0','member_id'=>'12','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1658401704','update_time'=>'1658401704']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'11','bloc_id'=>'13','store_id'=>'0','member_id'=>'14','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1658832719','update_time'=>'1658832719']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'12','bloc_id'=>'13','store_id'=>'0','member_id'=>'15','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1658844416','update_time'=>'1658844416']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'13','bloc_id'=>'13','store_id'=>'0','member_id'=>'16','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1658917582','update_time'=>'1658917582']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'14','bloc_id'=>'13','store_id'=>'0','member_id'=>'18','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1659449183','update_time'=>'1659449183']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'15','bloc_id'=>'13','store_id'=>'0','member_id'=>'20','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1659753782','update_time'=>'1659753782']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'16','bloc_id'=>'13','store_id'=>'0','member_id'=>'21','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1659753993','update_time'=>'1659753993']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'17','bloc_id'=>'13','store_id'=>'0','member_id'=>'22','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1659925582','update_time'=>'1659925582']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'18','bloc_id'=>'13','store_id'=>'0','member_id'=>'24','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1661417518','update_time'=>'1661417518']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'19','bloc_id'=>'13','store_id'=>'0','member_id'=>'26','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1661868500','update_time'=>'1661868500']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'20','bloc_id'=>'13','store_id'=>'0','member_id'=>'23','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1661936588','update_time'=>'1661936588']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'21','bloc_id'=>'13','store_id'=>'0','member_id'=>'27','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1662338569','update_time'=>'1662338569']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'22','bloc_id'=>'13','store_id'=>'0','member_id'=>'28','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1662546391','update_time'=>'1662546391']);
        $this->insert('{{%diandi_mall_account_member}}',['id'=>'23','bloc_id'=>'13','store_id'=>'0','member_id'=>'29','self_money'=>'0.00','self_withdraw'=>'0.00','self_freeze'=>'0.00','team_money'=>'0.00','team_withdraw'=>'0.00','team_freeze'=>'0.00','store_money'=>'0.00','store_withdraw'=>'0.00','store_freeze'=>'0.00','agent_money'=>'0.00','agent_withdraw'=>'0.00','agent_freeze'=>'0.00','water_money'=>NULL,'water_withdraw'=>NULL,'water_freeze'=>NULL,'create_time'=>'1666010914','update_time'=>'1666010914']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_mall_account_member}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

