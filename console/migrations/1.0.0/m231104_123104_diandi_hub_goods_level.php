<?php

use yii\db\Migration;

class m231104_123104_diandi_hub_goods_level extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_hub_goods_level}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'bloc_id' => "int(11) NULL COMMENT '公司ID'",
            'store_id' => "int(11) NULL COMMENT '商户ID'",
            'goods_id' => "int(11) NULL COMMENT '商品ID'",
            'dis_id' => "int(11) NULL COMMENT '分销活动ID'",
            'level_num' => "smallint(6) NULL COMMENT '会员等级'",
            'team_num' => "smallint(6) NULL COMMENT '团队等级'",
            'dis_option' => "decimal(11,2) NULL COMMENT '分销参数'",
            'create_time' => "int(11) NULL COMMENT '创建时间'",
            'update_time' => "int(11) NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
        
        /* 索引设置 */
        $this->createIndex('member_id','{{%diandi_hub_goods_level}}','goods_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'1','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'1','level_num'=>'0','team_num'=>'1','dis_option'=>'1.00','create_time'=>'1645793363','update_time'=>'1645793363']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'2','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'1','level_num'=>'0','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793363','update_time'=>'1645793363']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'3','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'1','level_num'=>'1','team_num'=>'1','dis_option'=>'233.00','create_time'=>'1645793363','update_time'=>'1645793363']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'4','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'1','level_num'=>'1','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793363','update_time'=>'1645793363']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'5','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'1','level_num'=>'2','team_num'=>'1','dis_option'=>'33.00','create_time'=>'1645793363','update_time'=>'1645793363']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'6','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'1','level_num'=>'2','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793363','update_time'=>'1645793363']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'7','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'2','level_num'=>'0','team_num'=>'1','dis_option'=>'2.00','create_time'=>'1645793481','update_time'=>'1645793481']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'8','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'2','level_num'=>'0','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793481','update_time'=>'1645793481']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'9','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'2','level_num'=>'1','team_num'=>'1','dis_option'=>'4.00','create_time'=>'1645793481','update_time'=>'1645793481']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'10','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'2','level_num'=>'1','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793481','update_time'=>'1645793481']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'11','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'2','level_num'=>'2','team_num'=>'1','dis_option'=>'6.00','create_time'=>'1645793481','update_time'=>'1645793481']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'12','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'2','level_num'=>'2','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793481','update_time'=>'1645793481']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'13','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'4','level_num'=>'0','team_num'=>'1','dis_option'=>'1.00','create_time'=>'1645793702','update_time'=>'1645793702']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'14','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'4','level_num'=>'0','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793702','update_time'=>'1645793702']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'15','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'4','level_num'=>'1','team_num'=>'1','dis_option'=>'2.00','create_time'=>'1645793702','update_time'=>'1645793702']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'16','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'4','level_num'=>'1','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793702','update_time'=>'1645793702']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'17','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'4','level_num'=>'2','team_num'=>'1','dis_option'=>'3.00','create_time'=>'1645793702','update_time'=>'1645793702']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'18','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'4','level_num'=>'2','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793702','update_time'=>'1645793702']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'19','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'5','level_num'=>'0','team_num'=>'1','dis_option'=>'1.00','create_time'=>'1645793729','update_time'=>'1645793729']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'20','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'5','level_num'=>'0','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793729','update_time'=>'1645793729']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'21','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'5','level_num'=>'1','team_num'=>'1','dis_option'=>'2.00','create_time'=>'1645793729','update_time'=>'1645793729']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'22','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'5','level_num'=>'1','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793729','update_time'=>'1645793729']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'23','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'5','level_num'=>'2','team_num'=>'1','dis_option'=>'3.00','create_time'=>'1645793729','update_time'=>'1645793729']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'24','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'5','level_num'=>'2','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793729','update_time'=>'1645793729']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'25','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'6','level_num'=>'0','team_num'=>'1','dis_option'=>'1.00','create_time'=>'1645793910','update_time'=>'1645793910']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'26','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'6','level_num'=>'0','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793910','update_time'=>'1645793910']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'27','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'6','level_num'=>'1','team_num'=>'1','dis_option'=>'2.00','create_time'=>'1645793910','update_time'=>'1645793910']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'28','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'6','level_num'=>'1','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793910','update_time'=>'1645793910']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'29','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'6','level_num'=>'2','team_num'=>'1','dis_option'=>'3.00','create_time'=>'1645793910','update_time'=>'1645793910']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'30','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'6','level_num'=>'2','team_num'=>'2','dis_option'=>NULL,'create_time'=>'1645793910','update_time'=>'1645793910']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'31','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'7','level_num'=>'0','team_num'=>'1','dis_option'=>'1.00','create_time'=>'1645794177','update_time'=>'1645794177']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'32','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'7','level_num'=>'0','team_num'=>'2','dis_option'=>'1.00','create_time'=>'1645794177','update_time'=>'1645794177']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'33','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'7','level_num'=>'1','team_num'=>'1','dis_option'=>'2.00','create_time'=>'1645794177','update_time'=>'1645794177']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'34','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'7','level_num'=>'1','team_num'=>'2','dis_option'=>'2.00','create_time'=>'1645794177','update_time'=>'1645794177']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'35','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'7','level_num'=>'2','team_num'=>'1','dis_option'=>'3.00','create_time'=>'1645794177','update_time'=>'1645794177']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'36','bloc_id'=>'8','store_id'=>'61','goods_id'=>'0','dis_id'=>'7','level_num'=>'2','team_num'=>'2','dis_option'=>'3.00','create_time'=>'1645794177','update_time'=>'1645794177']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'37','bloc_id'=>'27','store_id'=>'75','goods_id'=>'0','dis_id'=>'8','level_num'=>'0','team_num'=>'1','dis_option'=>'12.00','create_time'=>'1645837968','update_time'=>'1645837968']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'38','bloc_id'=>'27','store_id'=>'75','goods_id'=>'0','dis_id'=>'8','level_num'=>'0','team_num'=>'2','dis_option'=>'12.00','create_time'=>'1645837968','update_time'=>'1645837968']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'39','bloc_id'=>'27','store_id'=>'75','goods_id'=>'0','dis_id'=>'8','level_num'=>'1','team_num'=>'1','dis_option'=>'12.00','create_time'=>'1645837968','update_time'=>'1645837968']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'40','bloc_id'=>'27','store_id'=>'75','goods_id'=>'0','dis_id'=>'8','level_num'=>'1','team_num'=>'2','dis_option'=>'12.00','create_time'=>'1645837968','update_time'=>'1645837968']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'41','bloc_id'=>'27','store_id'=>'75','goods_id'=>'0','dis_id'=>'8','level_num'=>'2','team_num'=>'1','dis_option'=>'1.00','create_time'=>'1645837968','update_time'=>'1645837968']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'42','bloc_id'=>'27','store_id'=>'75','goods_id'=>'0','dis_id'=>'8','level_num'=>'2','team_num'=>'2','dis_option'=>'1.00','create_time'=>'1645837968','update_time'=>'1645837968']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'55','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'11','level_num'=>'0','team_num'=>'1','dis_option'=>'1.00','create_time'=>'1645839015','update_time'=>'1645839015']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'56','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'11','level_num'=>'0','team_num'=>'2','dis_option'=>'1.00','create_time'=>'1645839015','update_time'=>'1645839015']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'57','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'11','level_num'=>'1','team_num'=>'1','dis_option'=>'2.00','create_time'=>'1645839015','update_time'=>'1645839015']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'58','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'11','level_num'=>'1','team_num'=>'2','dis_option'=>'2.00','create_time'=>'1645839015','update_time'=>'1645839015']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'59','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'11','level_num'=>'2','team_num'=>'1','dis_option'=>'3.00','create_time'=>'1645839015','update_time'=>'1645839015']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'60','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'11','level_num'=>'2','team_num'=>'2','dis_option'=>'3.00','create_time'=>'1645839015','update_time'=>'1645839015']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'61','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'12','level_num'=>'0','team_num'=>'1','dis_option'=>NULL,'create_time'=>'1645839425','update_time'=>'1645839425']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'62','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'12','level_num'=>'0','team_num'=>'2','dis_option'=>'2.00','create_time'=>'1645839425','update_time'=>'1645839425']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'63','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'12','level_num'=>'1','team_num'=>'1','dis_option'=>NULL,'create_time'=>'1645839425','update_time'=>'1645839425']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'64','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'12','level_num'=>'1','team_num'=>'2','dis_option'=>'32.00','create_time'=>'1645839425','update_time'=>'1645839425']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'65','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'12','level_num'=>'2','team_num'=>'1','dis_option'=>NULL,'create_time'=>'1645839425','update_time'=>'1645839425']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'66','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'12','level_num'=>'2','team_num'=>'2','dis_option'=>'45.00','create_time'=>'1645839425','update_time'=>'1645839425']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'67','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'13','level_num'=>'0','team_num'=>'1','dis_option'=>NULL,'create_time'=>'1645840623','update_time'=>'1645840623']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'68','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'13','level_num'=>'0','team_num'=>'2','dis_option'=>'1.00','create_time'=>'1645840623','update_time'=>'1645840623']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'69','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'13','level_num'=>'1','team_num'=>'1','dis_option'=>NULL,'create_time'=>'1645840623','update_time'=>'1645840623']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'70','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'13','level_num'=>'1','team_num'=>'2','dis_option'=>'2.00','create_time'=>'1645840623','update_time'=>'1645840623']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'71','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'13','level_num'=>'2','team_num'=>'1','dis_option'=>NULL,'create_time'=>'1645840623','update_time'=>'1645840623']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'72','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'13','level_num'=>'2','team_num'=>'2','dis_option'=>'3.00','create_time'=>'1645840623','update_time'=>'1645840623']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'73','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'14','level_num'=>'0','team_num'=>'1','dis_option'=>NULL,'create_time'=>'1645840724','update_time'=>'1645840724']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'74','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'14','level_num'=>'0','team_num'=>'2','dis_option'=>'1.00','create_time'=>'1645840724','update_time'=>'1645840724']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'75','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'14','level_num'=>'1','team_num'=>'1','dis_option'=>NULL,'create_time'=>'1645840724','update_time'=>'1645840724']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'76','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'14','level_num'=>'1','team_num'=>'2','dis_option'=>'2.00','create_time'=>'1645840724','update_time'=>'1645840724']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'77','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'14','level_num'=>'2','team_num'=>'1','dis_option'=>NULL,'create_time'=>'1645840724','update_time'=>'1645840724']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'78','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'14','level_num'=>'2','team_num'=>'2','dis_option'=>'3.00','create_time'=>'1645840724','update_time'=>'1645840724']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'79','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'15','level_num'=>'0','team_num'=>'1','dis_option'=>'1.00','create_time'=>'1645841629','update_time'=>'1645841629']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'80','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'15','level_num'=>'0','team_num'=>'2','dis_option'=>'1.00','create_time'=>'1645841629','update_time'=>'1645841629']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'81','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'15','level_num'=>'1','team_num'=>'1','dis_option'=>'2.00','create_time'=>'1645841629','update_time'=>'1645841629']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'82','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'15','level_num'=>'1','team_num'=>'2','dis_option'=>'2.00','create_time'=>'1645841629','update_time'=>'1645841629']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'83','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'15','level_num'=>'2','team_num'=>'1','dis_option'=>'3.00','create_time'=>'1645841629','update_time'=>'1645841629']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'84','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'15','level_num'=>'2','team_num'=>'2','dis_option'=>'3.00','create_time'=>'1645841629','update_time'=>'1645841629']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'85','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'16','level_num'=>'0','team_num'=>'1','dis_option'=>'1.00','create_time'=>'1645841893','update_time'=>'1645841893']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'86','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'16','level_num'=>'0','team_num'=>'2','dis_option'=>'1.00','create_time'=>'1645841893','update_time'=>'1645841893']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'87','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'16','level_num'=>'1','team_num'=>'1','dis_option'=>'2.00','create_time'=>'1645841893','update_time'=>'1645841893']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'88','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'16','level_num'=>'1','team_num'=>'2','dis_option'=>'2.00','create_time'=>'1645841893','update_time'=>'1645841893']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'89','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'16','level_num'=>'2','team_num'=>'1','dis_option'=>'3.00','create_time'=>'1645841893','update_time'=>'1645841893']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'90','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'16','level_num'=>'2','team_num'=>'2','dis_option'=>'3.00','create_time'=>'1645841893','update_time'=>'1645841893']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'91','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'17','level_num'=>'0','team_num'=>'1','dis_option'=>'1.00','create_time'=>'1645841899','update_time'=>'1645841899']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'92','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'17','level_num'=>'0','team_num'=>'2','dis_option'=>'1.00','create_time'=>'1645841899','update_time'=>'1645841899']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'93','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'17','level_num'=>'1','team_num'=>'1','dis_option'=>'2.00','create_time'=>'1645841899','update_time'=>'1645841899']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'94','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'17','level_num'=>'1','team_num'=>'2','dis_option'=>'2.00','create_time'=>'1645841899','update_time'=>'1645841899']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'95','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'17','level_num'=>'2','team_num'=>'1','dis_option'=>'3.00','create_time'=>'1645841899','update_time'=>'1645841899']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'96','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'17','level_num'=>'2','team_num'=>'2','dis_option'=>'3.00','create_time'=>'1645841899','update_time'=>'1645841899']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'97','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'18','level_num'=>'0','team_num'=>'1','dis_option'=>'775.00','create_time'=>'1645842385','update_time'=>'1645842385']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'98','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'18','level_num'=>'0','team_num'=>'2','dis_option'=>'77.00','create_time'=>'1645842385','update_time'=>'1645842385']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'99','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'18','level_num'=>'1','team_num'=>'1','dis_option'=>'66.00','create_time'=>'1645842385','update_time'=>'1645842385']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'100','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'18','level_num'=>'1','team_num'=>'2','dis_option'=>'66.00','create_time'=>'1645842385','update_time'=>'1645842385']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'101','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'18','level_num'=>'2','team_num'=>'1','dis_option'=>'3.00','create_time'=>'1645842385','update_time'=>'1645842385']);
        $this->insert('{{%diandi_hub_goods_level}}',['id'=>'102','bloc_id'=>'27','store_id'=>'75','goods_id'=>'5','dis_id'=>'18','level_num'=>'2','team_num'=>'2','dis_option'=>'45.00','create_time'=>'1645842385','update_time'=>'1645842385']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_hub_goods_level}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

