<?php

use yii\db\Migration;

class m220630_075752_diandi_integral_spec_value extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_integral_spec_value}}', [
            'spec_value_id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'store_id' => "int(11) NULL",
            'bloc_id' => "int(11) NULL",
            'spec_value' => "varchar(255) NOT NULL",
            'spec_id' => "int(11) NOT NULL",
            'create_time' => "int(11) NOT NULL",
            'PRIMARY KEY (`spec_value_id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'5','store_id'=>'48','bloc_id'=>'8','spec_value'=>'红色','spec_id'=>'185','create_time'=>'1578336600']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'6','store_id'=>'48','bloc_id'=>'8','spec_value'=>'绿色','spec_id'=>'185','create_time'=>'1578336600']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'7','store_id'=>'48','bloc_id'=>'8','spec_value'=>'xxl','spec_id'=>'186','create_time'=>'1578336600']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'8','store_id'=>'48','bloc_id'=>'8','spec_value'=>'xl','spec_id'=>'186','create_time'=>'1578336600']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'9','store_id'=>'48','bloc_id'=>'8','spec_value'=>'蓝色','spec_id'=>'185','create_time'=>'1578341347']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'10','store_id'=>'48','bloc_id'=>'8','spec_value'=>'木头','spec_id'=>'187','create_time'=>'1578341609']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'11','store_id'=>'48','bloc_id'=>'8','spec_value'=>'熟料','spec_id'=>'187','create_time'=>'1578341609']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'12','store_id'=>'48','bloc_id'=>'8','spec_value'=>'你','spec_id'=>'186','create_time'=>'1578414324']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'13','store_id'=>'48','bloc_id'=>'8','spec_value'=>'xxl','spec_id'=>'189','create_time'=>'1578638143']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'14','store_id'=>'48','bloc_id'=>'8','spec_value'=>'aaa','spec_id'=>'190','create_time'=>'1578638524']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'15','store_id'=>'48','bloc_id'=>'8','spec_value'=>'bbb','spec_id'=>'190','create_time'=>'1578638524']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'16','store_id'=>'48','bloc_id'=>'8','spec_value'=>'剥离力','spec_id'=>'187','create_time'=>'1578638778']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'17','store_id'=>'48','bloc_id'=>'8','spec_value'=>'aaa','spec_id'=>'191','create_time'=>'1578639354']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'18','store_id'=>'48','bloc_id'=>'8','spec_value'=>'mm','spec_id'=>'186','create_time'=>'1578639524']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'19','store_id'=>'48','bloc_id'=>'8','spec_value'=>'绿色额','spec_id'=>'185','create_time'=>'1578642091']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'20','store_id'=>'48','bloc_id'=>'8','spec_value'=>'紫色','spec_id'=>'185','create_time'=>'1578642219']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'21','store_id'=>'48','bloc_id'=>'8','spec_value'=>'白色','spec_id'=>'185','create_time'=>'1583177389']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'22','store_id'=>'48','bloc_id'=>'8','spec_value'=>'xxl,','spec_id'=>'186','create_time'=>'1583177389']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'23','store_id'=>'48','bloc_id'=>'8','spec_value'=>'西安','spec_id'=>'192','create_time'=>'1583222493']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'24','store_id'=>'48','bloc_id'=>'8','spec_value'=>'北京','spec_id'=>'192','create_time'=>'1583222493']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'25','store_id'=>'48','bloc_id'=>'8','spec_value'=>'好的','spec_id'=>'185','create_time'=>'1583222493']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'26','store_id'=>'48','bloc_id'=>'8','spec_value'=>'ok','spec_id'=>'185','create_time'=>'1583222493']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'27','store_id'=>'48','bloc_id'=>'8','spec_value'=>'xxls','spec_id'=>'186','create_time'=>'1583235818']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'28','store_id'=>'48','bloc_id'=>'8','spec_value'=>'一年','spec_id'=>'193','create_time'=>'1583237534']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'29','store_id'=>'48','bloc_id'=>'8','spec_value'=>'熟','spec_id'=>'194','create_time'=>'1585821036']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'30','store_id'=>'48','bloc_id'=>'8','spec_value'=>'生','spec_id'=>'195','create_time'=>'1585821093']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'31','store_id'=>'48','bloc_id'=>'8','spec_value'=>'大的','spec_id'=>'196','create_time'=>'1586334033']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'32','store_id'=>'48','bloc_id'=>'8','spec_value'=>'小的','spec_id'=>'196','create_time'=>'1586334033']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'33','store_id'=>'48','bloc_id'=>'8','spec_value'=>'基础版','spec_id'=>'197','create_time'=>'1586427299']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'34','store_id'=>'48','bloc_id'=>'8','spec_value'=>'商务版','spec_id'=>'197','create_time'=>'1586427299']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'35','store_id'=>'48','bloc_id'=>'8','spec_value'=>'基础服务','spec_id'=>'198','create_time'=>'1586427299']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'36','store_id'=>'48','bloc_id'=>'8','spec_value'=>'至尊服务','spec_id'=>'198','create_time'=>'1586427299']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'37','store_id'=>'48','bloc_id'=>'8','spec_value'=>'石头','spec_id'=>'187','create_time'=>'1591515873']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'38','store_id'=>'48','bloc_id'=>'8','spec_value'=>'1号','spec_id'=>'186','create_time'=>'1591516845']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'39','store_id'=>'48','bloc_id'=>'8','spec_value'=>'2号','spec_id'=>'186','create_time'=>'1591516845']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'40','store_id'=>'48','bloc_id'=>'8','spec_value'=>'红黑','spec_id'=>'185','create_time'=>'1591516846']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'41','store_id'=>'48','bloc_id'=>'8','spec_value'=>'紫黄','spec_id'=>'185','create_time'=>'1591516846']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'42','store_id'=>'48','bloc_id'=>'8','spec_value'=>'m','spec_id'=>'186','create_time'=>'1592643940']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'43','store_id'=>'48','bloc_id'=>'8','spec_value'=>'黑色','spec_id'=>'185','create_time'=>'1594607079']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'44','store_id'=>'48','bloc_id'=>'8','spec_value'=>'国家宝藏四件套2.3m*2.5m','spec_id'=>'199','create_time'=>'1608018311']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'45','store_id'=>'48','bloc_id'=>'8','spec_value'=>'三件套','spec_id'=>'199','create_time'=>'1608020401']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'46','store_id'=>'48','bloc_id'=>'8','spec_value'=>'七件套','spec_id'=>'199','create_time'=>'1608022012']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'47','store_id'=>'48','bloc_id'=>'8','spec_value'=>'保温壶2.0L ','spec_id'=>'199','create_time'=>'1608023061']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'48','store_id'=>'48','bloc_id'=>'8','spec_value'=>' 一体式净水器','spec_id'=>'199','create_time'=>'1608025056']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'49','store_id'=>'48','bloc_id'=>'8','spec_value'=>'5件套','spec_id'=>'199','create_time'=>'1608026637']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'50','store_id'=>'48','bloc_id'=>'8','spec_value'=>'KZ-GT23 白色','spec_id'=>'199','create_time'=>'1608103175']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'51','store_id'=>'48','bloc_id'=>'8','spec_value'=>'天蓝色','spec_id'=>'185','create_time'=>'1608104459']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'52','store_id'=>'48','bloc_id'=>'8','spec_value'=>'粉色','spec_id'=>'185','create_time'=>'1608104459']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'53','store_id'=>'48','bloc_id'=>'8','spec_value'=>'冰河蓝','spec_id'=>'185','create_time'=>'1608105620']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'54','store_id'=>'48','bloc_id'=>'8','spec_value'=>'电动牙刷MX213 白色','spec_id'=>'199','create_time'=>'1608106736']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'55','store_id'=>'48','bloc_id'=>'8','spec_value'=>'RCK-08','spec_id'=>'199','create_time'=>'1608178995']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'56','store_id'=>'48','bloc_id'=>'8','spec_value'=>'白色','spec_id'=>'199','create_time'=>'1608194802']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'57','store_id'=>'48','bloc_id'=>'8','spec_value'=>'ALY-XC120W1','spec_id'=>'199','create_time'=>'1608262621']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'58','store_id'=>'48','bloc_id'=>'8','spec_value'=>'景芝私藏','spec_id'=>'199','create_time'=>'1608266435']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'59','store_id'=>'48','bloc_id'=>'8','spec_value'=>'茅台醇浆','spec_id'=>'199','create_time'=>'1608266935']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'60','store_id'=>'48','bloc_id'=>'8','spec_value'=>'美肤仪BO022','spec_id'=>'199','create_time'=>'1608274019']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'61','store_id'=>'48','bloc_id'=>'8','spec_value'=>'瘦脸仪BO013','spec_id'=>'199','create_time'=>'1608275533']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'62','store_id'=>'48','bloc_id'=>'8','spec_value'=>'膜朵女神四件套','spec_id'=>'199','create_time'=>'1608276989']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'63','store_id'=>'48','bloc_id'=>'8','spec_value'=>'4件套','spec_id'=>'199','create_time'=>'1608277506']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'64','store_id'=>'48','bloc_id'=>'8','spec_value'=>'四件套（吊坠 耳钉 戒指  手链）','spec_id'=>'199','create_time'=>'1608369801']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'65','store_id'=>'48','bloc_id'=>'8','spec_value'=>'车载充气泵','spec_id'=>'199','create_time'=>'1608630542']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'66','store_id'=>'48','bloc_id'=>'8','spec_value'=>'空气净化器XJ-002','spec_id'=>'199','create_time'=>'1608637242']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'67','store_id'=>'48','bloc_id'=>'8','spec_value'=>'玫瑰金','spec_id'=>'185','create_time'=>'1608640073']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'68','store_id'=>'48','bloc_id'=>'8','spec_value'=>'亮光蓝','spec_id'=>'185','create_time'=>'1608640073']);
        $this->insert('{{%diandi_integral_spec_value}}',['spec_value_id'=>'69','store_id'=>'48','bloc_id'=>'8','spec_value'=>'灰色','spec_id'=>'185','create_time'=>'1608640073']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_integral_spec_value}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

