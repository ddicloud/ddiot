<?php

use yii\db\Migration;

class m220613_090925_diandi_tea_set_meal extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_set_meal}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '包间套餐id'",
            'bloc_id' => "int(11) NOT NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NOT NULL",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'title' => "varchar(100) NULL COMMENT '套餐名'",
            'duration' => "float(6,1) NULL COMMENT '套餐时长'",
            'price' => "decimal(10,2) NULL COMMENT '套餐价格'",
            'renew_price' => "decimal(10,2) NULL COMMENT '每半小时续费单价'",
            'type' => "smallint(2) NULL COMMENT '套餐类型：1.小时套餐  2.计时套餐'",
            'details' => "text NULL COMMENT '套餐介绍'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='套餐表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'3','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-03-31 14:09:37','update_time'=>'2022-06-13 10:46:26','title'=>'【单价58】2小时4人间套餐','duration'=>'2','price'=>'96.00','renew_price'=>'29.00','type'=>'1','details'=>'【单价58】2小时4人间套餐']);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'4','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-04-07 13:00:00','update_time'=>'2022-06-13 10:46:32','title'=>'【单价58】4小时4人间套餐','duration'=>'4','price'=>'174.00','renew_price'=>'29.00','type'=>'1','details'=>'【单价58】4小时4人间套餐']);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'5','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-05-27 15:22:10','update_time'=>'2022-06-13 10:47:32','title'=>'【单价58】4个人计时套餐','duration'=>'1','price'=>'58.00','renew_price'=>'29.00','type'=>'2','details'=>'【单价58】4个人计时套餐']);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'6','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-05-28 17:47:47','update_time'=>'2022-06-13 10:47:38','title'=>'【单价88】2小时6人间套餐','duration'=>'2','price'=>'156.00','renew_price'=>'44.00','type'=>'1','details'=>'【单价88】2小时6人间套餐']);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'7','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-05-28 17:48:27','update_time'=>'2022-06-08 11:27:04','title'=>'【单价108】2小时12人间套餐','duration'=>'2','price'=>'196.00','renew_price'=>'54.00','type'=>'1','details'=>NULL]);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'8','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-05-28 17:52:13','update_time'=>'2022-06-13 10:47:44','title'=>'【单价88】4小时6人间套餐','duration'=>'4','price'=>'264.00','renew_price'=>'44.00','type'=>'1','details'=>'【单价88】4小时6人间套餐']);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'9','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-05-28 17:53:26','update_time'=>'2022-06-13 10:47:49','title'=>'【单价108】4小时12人间套餐','duration'=>'4','price'=>'324.00','renew_price'=>'54.00','type'=>'1','details'=>'【单价108】4小时12人间套餐']);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'10','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-05-28 17:54:59','update_time'=>'2022-06-08 11:25:46','title'=>'【单价88】6个人计时套餐','duration'=>'1','price'=>'88.00','renew_price'=>'44.00','type'=>'2','details'=>NULL]);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'11','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-05-28 17:55:17','update_time'=>'2022-06-13 10:48:10','title'=>'【单价108】12个人计时套餐','duration'=>'1','price'=>'108.00','renew_price'=>'54.00','type'=>'2','details'=>'【单价108】12个人计时套餐']);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'13','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-08 11:22:42','update_time'=>'2022-06-13 10:48:05','title'=>'【单价68】2小时4人间套餐','duration'=>'2','price'=>'116.00','renew_price'=>'34.00','type'=>'1','details'=>'【单价68】2小时4人间套餐']);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'14','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-08 11:23:08','update_time'=>'2022-06-13 10:48:00','title'=>'【单价68】4小时4人间套餐','duration'=>'4','price'=>'204.00','renew_price'=>'34.00','type'=>'1','details'=>'【单价68】4小时4人间套餐']);
        $this->insert('{{%diandi_tea_set_meal}}',['id'=>'15','bloc_id'=>'30','store_id'=>'79','create_time'=>'2022-06-08 11:23:46','update_time'=>'2022-06-13 10:47:55','title'=>'【单价68】4个人计时套餐','duration'=>'1','price'=>'68.00','renew_price'=>'34.00','type'=>'2','details'=>'【单价68】4个人计时套餐']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_set_meal}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

