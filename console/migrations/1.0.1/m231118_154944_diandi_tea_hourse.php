<?php

use yii\db\Migration;

class m231118_154944_diandi_tea_hourse extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_tea_hourse}}', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '包间id'",
            'bloc_id' => "int(11) NULL COMMENT '人脸库组id'",
            'store_id' => "int(11) NULL COMMENT '店铺id'",
            'create_time' => "datetime NULL",
            'update_time' => "datetime NULL",
            'name' => "varchar(100) NOT NULL COMMENT '包间名'",
            'picture' => "varchar(255) NULL COMMENT '包间图片'",
            'introduce' => "text NULL COMMENT '包间介绍'",
            'max_num' => "int(11) NULL COMMENT '可容纳人数'",
            'tip' => "text NULL COMMENT '包间说明'",
            'status' => "smallint(6) NULL COMMENT '包间状态：1.空闲中 2.待打扫 3.待客中'",
            'set_meal_ids' => "varchar(100) NULL COMMENT '包间套餐列表'",
            'fit_num' => "varchar(100) NULL COMMENT '包间适合人数'",
            'price' => "decimal(10,2) NULL",
            'slide' => "text NULL COMMENT '包间幻灯片'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='包间表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%diandi_tea_hourse}}',['id'=>'5','bloc_id'=>'91','store_id'=>'153','create_time'=>'0000-00-00 00:00:00','update_time'=>'2023-10-31 16:32:01','name'=>'鸿儒堂','picture'=>'202310/31/af5f08af-ce50-3a06-b125-dd5e574de5b9.jpg','introduce'=>'1.WiFi账号:点到为止茶室,密码:diandaoweizhi888;
2.本茶室禁止从事黄赌毒行为;
3.茶室配有自助售货机,茶叶及茶点可至售货机自行购买;
4.本茶室全程自助,每套茶具都经过消毒,请放心使用;
5.本茶室配套茶具及摆件均可免费使用,如有损坏,按市场价赔偿。 
6.本茶室需要用微信小程序预约进入，到店需下单者在小程序点击“开锁”，方可进入。
7.本茶室到时自动断电，会提前10分钟提醒续费，若您需要延时，可提前在微信小程序点击“续费”按钮选择时间后付费即可。
8.快速预约，可扫描右方小程序码进入“点到为止”小程序下单预约','max_num'=>'12','tip'=>'会议房','status'=>'1','set_meal_ids'=>'11,9,7,11,9,7','fit_num'=>'','price'=>'108.00','slide'=>'[\"202310\\/31\\/a347ad11-8433-3922-88f5-8b7a4b52bbef.jpg\",\"202310\\/31\\/4b67fd83-a365-384e-90ea-7be62fc0ba15.jpg\"]']);
        $this->insert('{{%diandi_tea_hourse}}',['id'=>'7','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-17 10:09:35','update_time'=>'2023-10-31 16:32:20','name'=>'闲野舍','picture'=>'202310/31/7126b179-09c9-3526-95d7-3b91eaa41bbe.jpg','introduce'=>'1.WiFi账号:点到为止茶室,密码:diandaoweizhi888;
2.本茶室禁止从事黄赌毒行为;
3.茶室配有自助售货机,茶叶及茶点可至售货机自行购买;
4.本茶室全程自助,每套茶具都经过消毒,请放心使用;
5.本茶室配套茶具及摆件均可免费使用,如有损坏,按市场价赔偿。 
6.本茶室需要用微信小程序预约进入，到店需下单者在小程序点击“开锁”，方可进入。
7.本茶室到时自动断电，会提前10分钟提醒续费，若您需要延时，可提前在微信小程序点击“续费”按钮选择时间后付费即可。
8.快速预约，可扫描右方小程序码进入“点到为止”小程序下单预约','max_num'=>'4','tip'=>'麻将房','status'=>'1','set_meal_ids'=>'3,4,5','fit_num'=>'','price'=>'58.00','slide'=>'[\"202310\\/31\\/ad2c4e22-6448-366e-8567-1f8feeed5744.jpg\",\"202310\\/31\\/e2fac5d7-890c-3189-afea-f02f5f7c29cc.jpg\"]']);
        $this->insert('{{%diandi_tea_hourse}}',['id'=>'8','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-31 14:15:48','update_time'=>'2023-10-31 16:32:30','name'=>'千帆境','picture'=>'202310/31/c249b38d-6c1a-31b1-b146-17b364760a37.jpg','introduce'=>'1.WiFi账号:点到为止茶室,密码:diandaoweizhi888;
2.本茶室禁止从事黄赌毒行为;
3.茶室配有自助售货机,茶叶及茶点可至售货机自行购买;
4.本茶室全程自助,每套茶具都经过消毒,请放心使用;
5.本茶室配套茶具及摆件均可免费使用,如有损坏,按市场价赔偿。 
6.本茶室需要用微信小程序预约进入，到店需下单者在小程序点击“开锁”，方可进入。
7.本茶室到时自动断电，会提前10分钟提醒续费，若您需要延时，可提前在微信小程序点击“续费”按钮选择时间后付费即可。
8.快速预约，可扫描右方小程序码进入“点到为止”小程序下单预约','max_num'=>'6','tip'=>'商务房','status'=>'1','set_meal_ids'=>'6,8,10','fit_num'=>'','price'=>'88.00','slide'=>'[\"202310\\/31\\/ea2a3458-c091-332e-ba9f-e69c5e6d568d.jpg\",\"202310\\/31\\/b326f9b8-ecc6-3438-9284-89b46165f9c7.jpg\"]']);
        $this->insert('{{%diandi_tea_hourse}}',['id'=>'9','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-03-31 14:47:09','update_time'=>'2023-10-31 16:32:42','name'=>'泊云居','picture'=>'202310/31/9037b695-03f0-3644-b2f9-904921a01d3d.jpg','introduce'=>'1.WiFi账号:点到为止茶室,密码:diandaoweizhi888;
2.本茶室禁止从事黄赌毒行为;
3.茶室配有自助售货机,茶叶及茶点可至售货机自行购买;
4.本茶室全程自助,每套茶具都经过消毒,请放心使用;
5.本茶室配套茶具及摆件均可免费使用,如有损坏,按市场价赔偿。 
6.本茶室需要用微信小程序预约进入，到店需下单者在小程序点击“开锁”，方可进入。
7.本茶室到时自动断电，会提前10分钟提醒续费，若您需要延时，可提前在微信小程序点击“续费”按钮选择时间后付费即可。
8.快速预约，可扫描右方小程序码进入“点到为止”小程序下单预约','max_num'=>'6','tip'=>'私密房','status'=>'1','set_meal_ids'=>'6,8,10','fit_num'=>'','price'=>'88.00','slide'=>'[\"202310\\/31\\/e540f3cc-1967-30c4-aa0a-70a1b1e29d7e.jpg\",\"202310\\/31\\/5647a298-ed97-3f09-a71d-2442c4a63996.jpg\"]']);
        $this->insert('{{%diandi_tea_hourse}}',['id'=>'10','bloc_id'=>'91','store_id'=>'153','create_time'=>'2022-05-10 17:46:30','update_time'=>'2023-10-31 16:32:51','name'=>'君弈轩','picture'=>'202310/31/b3f1f8f2-a02b-356b-a76d-486d0352fa7a.jpg','introduce'=>'1.WiFi账号:点到为止茶室,密码:diandaoweizhi888;
2.本茶室禁止从事黄赌毒行为;
3.茶室配有自助售货机,茶叶及茶点可至售货机自行购买;
4.本茶室全程自助,每套茶具都经过消毒,请放心使用;
5.本茶室配套茶具及摆件均可免费使用,如有损坏,按市场价赔偿。 
6.本茶室需要用微信小程序预约进入，到店需下单者在小程序点击“开锁”，方可进入。
7.本茶室到时自动断电，会提前10分钟提醒续费，若您需要延时，可提前在微信小程序点击“续费”按钮选择时间后付费即可。
8.快速预约，可扫描右方小程序码进入“点到为止”小程序下单预约','max_num'=>'4','tip'=>'棋牌房','status'=>'1','set_meal_ids'=>'15,13,14','fit_num'=>'','price'=>'68.00','slide'=>'[\"202310\\/31\\/9e96b90a-51a9-36a6-bb3f-4c553b87655f.jpg\",\"202310\\/31\\/2da61f77-f4b9-3a63-91e8-e1f2b2ad3708.jpg\"]']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_tea_hourse}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

