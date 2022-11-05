<?php

use yii\db\Migration;

class m221105_101637_upload_file_used extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%upload_file_used}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'user_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '用户id'",
            'file_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件id'",
            'bloc_id' => "int(11) NULL DEFAULT '0' COMMENT '公司id'",
            'store_id' => "int(11) NULL DEFAULT '0' COMMENT '商户id'",
            'from_type' => "varchar(255) NULL",
            'from_id' => "int(11) NULL",
            'create_time' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'update_time' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('file_id','{{%upload_file_used}}','file_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%upload_file_used}}',['id'=>'6','user_id'=>'11','file_id'=>'19','bloc_id'=>NULL,'store_id'=>NULL,'from_type'=>NULL,'from_id'=>NULL,'create_time'=>'1639327885','update_time'=>'1639327885']);
        $this->insert('{{%upload_file_used}}',['id'=>'7','user_id'=>'11','file_id'=>'20','bloc_id'=>NULL,'store_id'=>NULL,'from_type'=>NULL,'from_id'=>NULL,'create_time'=>'1639327919','update_time'=>'1639327919']);
        $this->insert('{{%upload_file_used}}',['id'=>'253','user_id'=>'11','file_id'=>'13979','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1642787425','update_time'=>'1642787425']);
        $this->insert('{{%upload_file_used}}',['id'=>'255','user_id'=>'11','file_id'=>'13981','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1642787469','update_time'=>'1642787469']);
        $this->insert('{{%upload_file_used}}',['id'=>'275','user_id'=>'11','file_id'=>'14001','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1642793424','update_time'=>'1642793424']);
        $this->insert('{{%upload_file_used}}',['id'=>'529','user_id'=>'11','file_id'=>'14255','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645001227','update_time'=>'1645001227']);
        $this->insert('{{%upload_file_used}}',['id'=>'530','user_id'=>'11','file_id'=>'14256','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645001672','update_time'=>'1645001672']);
        $this->insert('{{%upload_file_used}}',['id'=>'531','user_id'=>'11','file_id'=>'14257','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645001806','update_time'=>'1645001806']);
        $this->insert('{{%upload_file_used}}',['id'=>'535','user_id'=>'11','file_id'=>'14261','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645516677','update_time'=>'1645516677']);
        $this->insert('{{%upload_file_used}}',['id'=>'536','user_id'=>'11','file_id'=>'14262','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645520214','update_time'=>'1645520214']);
        $this->insert('{{%upload_file_used}}',['id'=>'537','user_id'=>'11','file_id'=>'14263','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645520240','update_time'=>'1645520240']);
        $this->insert('{{%upload_file_used}}',['id'=>'538','user_id'=>'11','file_id'=>'14264','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645520472','update_time'=>'1645520472']);
        $this->insert('{{%upload_file_used}}',['id'=>'539','user_id'=>'11','file_id'=>'14265','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645579057','update_time'=>'1645579057']);
        $this->insert('{{%upload_file_used}}',['id'=>'540','user_id'=>'11','file_id'=>'14266','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645602144','update_time'=>'1645602144']);
        $this->insert('{{%upload_file_used}}',['id'=>'541','user_id'=>'11','file_id'=>'14267','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645602695','update_time'=>'1645602695']);
        $this->insert('{{%upload_file_used}}',['id'=>'542','user_id'=>'11','file_id'=>'14268','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645602764','update_time'=>'1645602764']);
        $this->insert('{{%upload_file_used}}',['id'=>'543','user_id'=>'11','file_id'=>'14269','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645603830','update_time'=>'1645603830']);
        $this->insert('{{%upload_file_used}}',['id'=>'544','user_id'=>'11','file_id'=>'14270','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645604061','update_time'=>'1645604061']);
        $this->insert('{{%upload_file_used}}',['id'=>'545','user_id'=>'11','file_id'=>'14271','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645604074','update_time'=>'1645604074']);
        $this->insert('{{%upload_file_used}}',['id'=>'546','user_id'=>'11','file_id'=>'14272','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645606025','update_time'=>'1645606025']);
        $this->insert('{{%upload_file_used}}',['id'=>'547','user_id'=>'11','file_id'=>'14273','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645606063','update_time'=>'1645606063']);
        $this->insert('{{%upload_file_used}}',['id'=>'548','user_id'=>'11','file_id'=>'14274','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645606079','update_time'=>'1645606079']);
        $this->insert('{{%upload_file_used}}',['id'=>'549','user_id'=>'11','file_id'=>'14275','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645607016','update_time'=>'1645607016']);
        $this->insert('{{%upload_file_used}}',['id'=>'550','user_id'=>'11','file_id'=>'14276','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645610416','update_time'=>'1645610416']);
        $this->insert('{{%upload_file_used}}',['id'=>'551','user_id'=>'11','file_id'=>'14277','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645666516','update_time'=>'1645666516']);
        $this->insert('{{%upload_file_used}}',['id'=>'552','user_id'=>'11','file_id'=>'14278','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645666519','update_time'=>'1645666519']);
        $this->insert('{{%upload_file_used}}',['id'=>'564','user_id'=>'11','file_id'=>'14290','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645792162','update_time'=>'1645792162']);
        $this->insert('{{%upload_file_used}}',['id'=>'565','user_id'=>'11','file_id'=>'14291','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645792640','update_time'=>'1645792640']);
        $this->insert('{{%upload_file_used}}',['id'=>'566','user_id'=>'11','file_id'=>'14292','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645792990','update_time'=>'1645792990']);
        $this->insert('{{%upload_file_used}}',['id'=>'567','user_id'=>'11','file_id'=>'14293','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645793136','update_time'=>'1645793136']);
        $this->insert('{{%upload_file_used}}',['id'=>'568','user_id'=>'11','file_id'=>'14294','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645793235','update_time'=>'1645793235']);
        $this->insert('{{%upload_file_used}}',['id'=>'569','user_id'=>'11','file_id'=>'14295','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645793356','update_time'=>'1645793356']);
        $this->insert('{{%upload_file_used}}',['id'=>'570','user_id'=>'11','file_id'=>'14296','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645793658','update_time'=>'1645793658']);
        $this->insert('{{%upload_file_used}}',['id'=>'571','user_id'=>'11','file_id'=>'14297','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645793906','update_time'=>'1645793906']);
        $this->insert('{{%upload_file_used}}',['id'=>'572','user_id'=>'11','file_id'=>'14298','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1645794010','update_time'=>'1645794010']);
        $this->insert('{{%upload_file_used}}',['id'=>'1384','user_id'=>'11','file_id'=>'15110','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654572502','update_time'=>'1654572502']);
        $this->insert('{{%upload_file_used}}',['id'=>'1385','user_id'=>'11','file_id'=>'15111','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654573225','update_time'=>'1654573225']);
        $this->insert('{{%upload_file_used}}',['id'=>'1386','user_id'=>'11','file_id'=>'15112','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654582849','update_time'=>'1654582849']);
        $this->insert('{{%upload_file_used}}',['id'=>'1387','user_id'=>'11','file_id'=>'15113','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654582854','update_time'=>'1654582854']);
        $this->insert('{{%upload_file_used}}',['id'=>'1388','user_id'=>'11','file_id'=>'15114','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654582856','update_time'=>'1654582856']);
        $this->insert('{{%upload_file_used}}',['id'=>'1389','user_id'=>'11','file_id'=>'15115','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654582858','update_time'=>'1654582858']);
        $this->insert('{{%upload_file_used}}',['id'=>'1390','user_id'=>'11','file_id'=>'15116','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654583017','update_time'=>'1654583017']);
        $this->insert('{{%upload_file_used}}',['id'=>'1391','user_id'=>'11','file_id'=>'15117','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654584876','update_time'=>'1654584876']);
        $this->insert('{{%upload_file_used}}',['id'=>'1392','user_id'=>'11','file_id'=>'15118','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654584987','update_time'=>'1654584987']);
        $this->insert('{{%upload_file_used}}',['id'=>'1393','user_id'=>'11','file_id'=>'15119','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654585112','update_time'=>'1654585112']);
        $this->insert('{{%upload_file_used}}',['id'=>'1394','user_id'=>'11','file_id'=>'15120','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654585526','update_time'=>'1654585526']);
        $this->insert('{{%upload_file_used}}',['id'=>'1395','user_id'=>'11','file_id'=>'15121','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654588941','update_time'=>'1654588941']);
        $this->insert('{{%upload_file_used}}',['id'=>'1396','user_id'=>'11','file_id'=>'15122','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654590618','update_time'=>'1654590618']);
        $this->insert('{{%upload_file_used}}',['id'=>'1397','user_id'=>'11','file_id'=>'15123','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654590621','update_time'=>'1654590621']);
        $this->insert('{{%upload_file_used}}',['id'=>'1398','user_id'=>'11','file_id'=>'15124','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654590623','update_time'=>'1654590623']);
        $this->insert('{{%upload_file_used}}',['id'=>'1399','user_id'=>'11','file_id'=>'15125','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654591390','update_time'=>'1654591390']);
        $this->insert('{{%upload_file_used}}',['id'=>'1400','user_id'=>'11','file_id'=>'15126','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654591393','update_time'=>'1654591393']);
        $this->insert('{{%upload_file_used}}',['id'=>'1401','user_id'=>'11','file_id'=>'15127','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654592595','update_time'=>'1654592595']);
        $this->insert('{{%upload_file_used}}',['id'=>'1402','user_id'=>'11','file_id'=>'15128','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654595763','update_time'=>'1654595763']);
        $this->insert('{{%upload_file_used}}',['id'=>'1403','user_id'=>'11','file_id'=>'15129','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654595765','update_time'=>'1654595765']);
        $this->insert('{{%upload_file_used}}',['id'=>'1404','user_id'=>'11','file_id'=>'15130','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654596298','update_time'=>'1654596298']);
        $this->insert('{{%upload_file_used}}',['id'=>'1405','user_id'=>'11','file_id'=>'15131','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654596309','update_time'=>'1654596309']);
        $this->insert('{{%upload_file_used}}',['id'=>'1407','user_id'=>'11','file_id'=>'15133','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1654675410','update_time'=>'1654675410']);
        $this->insert('{{%upload_file_used}}',['id'=>'1550','user_id'=>'11','file_id'=>'15276','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1655955273','update_time'=>'1655955273']);
        $this->insert('{{%upload_file_used}}',['id'=>'1551','user_id'=>'11','file_id'=>'15277','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1655955276','update_time'=>'1655955276']);
        $this->insert('{{%upload_file_used}}',['id'=>'1552','user_id'=>'11','file_id'=>'15278','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1655955826','update_time'=>'1655955826']);
        $this->insert('{{%upload_file_used}}',['id'=>'1553','user_id'=>'11','file_id'=>'15279','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1655955828','update_time'=>'1655955828']);
        $this->insert('{{%upload_file_used}}',['id'=>'1554','user_id'=>'11','file_id'=>'15280','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1655955861','update_time'=>'1655955861']);
        $this->insert('{{%upload_file_used}}',['id'=>'1555','user_id'=>'11','file_id'=>'15281','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1655955863','update_time'=>'1655955863']);
        $this->insert('{{%upload_file_used}}',['id'=>'1556','user_id'=>'11','file_id'=>'15282','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1655955881','update_time'=>'1655955881']);
        $this->insert('{{%upload_file_used}}',['id'=>'1557','user_id'=>'11','file_id'=>'15283','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1655955882','update_time'=>'1655955882']);
        $this->insert('{{%upload_file_used}}',['id'=>'1558','user_id'=>'11','file_id'=>'15284','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1655956408','update_time'=>'1655956408']);
        $this->insert('{{%upload_file_used}}',['id'=>'1559','user_id'=>'11','file_id'=>'15285','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1655965624','update_time'=>'1655965624']);
        $this->insert('{{%upload_file_used}}',['id'=>'1560','user_id'=>'11','file_id'=>'15286','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656040033','update_time'=>'1656040033']);
        $this->insert('{{%upload_file_used}}',['id'=>'1561','user_id'=>'11','file_id'=>'15287','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656051138','update_time'=>'1656051138']);
        $this->insert('{{%upload_file_used}}',['id'=>'1562','user_id'=>'11','file_id'=>'15288','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656053296','update_time'=>'1656053296']);
        $this->insert('{{%upload_file_used}}',['id'=>'1563','user_id'=>'11','file_id'=>'15289','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656053998','update_time'=>'1656053998']);
        $this->insert('{{%upload_file_used}}',['id'=>'1564','user_id'=>'11','file_id'=>'15290','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656054199','update_time'=>'1656054199']);
        $this->insert('{{%upload_file_used}}',['id'=>'1565','user_id'=>'11','file_id'=>'15291','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656054226','update_time'=>'1656054226']);
        $this->insert('{{%upload_file_used}}',['id'=>'1566','user_id'=>'11','file_id'=>'15292','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656054248','update_time'=>'1656054248']);
        $this->insert('{{%upload_file_used}}',['id'=>'1567','user_id'=>'11','file_id'=>'15293','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656054969','update_time'=>'1656054969']);
        $this->insert('{{%upload_file_used}}',['id'=>'1568','user_id'=>'11','file_id'=>'15294','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656055106','update_time'=>'1656055106']);
        $this->insert('{{%upload_file_used}}',['id'=>'1569','user_id'=>'11','file_id'=>'15295','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656055188','update_time'=>'1656055188']);
        $this->insert('{{%upload_file_used}}',['id'=>'1570','user_id'=>'11','file_id'=>'15296','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656055982','update_time'=>'1656055982']);
        $this->insert('{{%upload_file_used}}',['id'=>'1571','user_id'=>'11','file_id'=>'15297','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656056488','update_time'=>'1656056488']);
        $this->insert('{{%upload_file_used}}',['id'=>'1572','user_id'=>'11','file_id'=>'15298','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656056648','update_time'=>'1656056648']);
        $this->insert('{{%upload_file_used}}',['id'=>'1573','user_id'=>'11','file_id'=>'15299','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656056656','update_time'=>'1656056656']);
        $this->insert('{{%upload_file_used}}',['id'=>'1575','user_id'=>'11','file_id'=>'15301','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656057963','update_time'=>'1656057963']);
        $this->insert('{{%upload_file_used}}',['id'=>'1577','user_id'=>'11','file_id'=>'15303','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656061291','update_time'=>'1656061291']);
        $this->insert('{{%upload_file_used}}',['id'=>'1578','user_id'=>'11','file_id'=>'15304','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656061318','update_time'=>'1656061318']);
        $this->insert('{{%upload_file_used}}',['id'=>'1579','user_id'=>'11','file_id'=>'15305','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656061356','update_time'=>'1656061356']);
        $this->insert('{{%upload_file_used}}',['id'=>'1580','user_id'=>'11','file_id'=>'15306','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656063633','update_time'=>'1656063633']);
        $this->insert('{{%upload_file_used}}',['id'=>'1581','user_id'=>'11','file_id'=>'15307','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656063665','update_time'=>'1656063665']);
        $this->insert('{{%upload_file_used}}',['id'=>'1586','user_id'=>'11','file_id'=>'15312','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656728602','update_time'=>'1656728602']);
        $this->insert('{{%upload_file_used}}',['id'=>'1587','user_id'=>'11','file_id'=>'15313','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656728628','update_time'=>'1656728628']);
        $this->insert('{{%upload_file_used}}',['id'=>'1588','user_id'=>'11','file_id'=>'15314','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656728855','update_time'=>'1656728855']);
        $this->insert('{{%upload_file_used}}',['id'=>'1589','user_id'=>'11','file_id'=>'15315','bloc_id'=>'8','store_id'=>'61','from_type'=>'local','from_id'=>'0','create_time'=>'1656728889','update_time'=>'1656728889']);
        $this->insert('{{%upload_file_used}}',['id'=>'1590','user_id'=>'11','file_id'=>'15316','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1656728981','update_time'=>'1656728981']);
        $this->insert('{{%upload_file_used}}',['id'=>'1591','user_id'=>'11','file_id'=>'15317','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1656729414','update_time'=>'1656729414']);
        $this->insert('{{%upload_file_used}}',['id'=>'1592','user_id'=>'11','file_id'=>'15318','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1656729514','update_time'=>'1656729514']);
        $this->insert('{{%upload_file_used}}',['id'=>'1593','user_id'=>'11','file_id'=>'15319','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1656729518','update_time'=>'1656729518']);
        $this->insert('{{%upload_file_used}}',['id'=>'1594','user_id'=>'11','file_id'=>'15320','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1656729530','update_time'=>'1656729530']);
        $this->insert('{{%upload_file_used}}',['id'=>'1595','user_id'=>'11','file_id'=>'15321','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1656729534','update_time'=>'1656729534']);
        $this->insert('{{%upload_file_used}}',['id'=>'1596','user_id'=>'11','file_id'=>'15322','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1656729551','update_time'=>'1656729551']);
        $this->insert('{{%upload_file_used}}',['id'=>'1597','user_id'=>'11','file_id'=>'15323','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1656729554','update_time'=>'1656729554']);
        $this->insert('{{%upload_file_used}}',['id'=>'1598','user_id'=>'11','file_id'=>'15324','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1656729563','update_time'=>'1656729563']);
        $this->insert('{{%upload_file_used}}',['id'=>'1599','user_id'=>'11','file_id'=>'15325','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1656729566','update_time'=>'1656729566']);
        $this->insert('{{%upload_file_used}}',['id'=>'1609','user_id'=>'11','file_id'=>'15335','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657070104','update_time'=>'1657070104']);
        $this->insert('{{%upload_file_used}}',['id'=>'1644','user_id'=>'11','file_id'=>'15370','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185274','update_time'=>'1657185274']);
        $this->insert('{{%upload_file_used}}',['id'=>'1645','user_id'=>'11','file_id'=>'15371','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185295','update_time'=>'1657185295']);
        $this->insert('{{%upload_file_used}}',['id'=>'1646','user_id'=>'11','file_id'=>'15372','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185318','update_time'=>'1657185318']);
        $this->insert('{{%upload_file_used}}',['id'=>'1647','user_id'=>'11','file_id'=>'15373','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185385','update_time'=>'1657185385']);
        $this->insert('{{%upload_file_used}}',['id'=>'1648','user_id'=>'11','file_id'=>'15374','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185404','update_time'=>'1657185404']);
        $this->insert('{{%upload_file_used}}',['id'=>'1649','user_id'=>'11','file_id'=>'15375','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185419','update_time'=>'1657185419']);
        $this->insert('{{%upload_file_used}}',['id'=>'1650','user_id'=>'11','file_id'=>'15376','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185462','update_time'=>'1657185462']);
        $this->insert('{{%upload_file_used}}',['id'=>'1651','user_id'=>'11','file_id'=>'15377','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185476','update_time'=>'1657185476']);
        $this->insert('{{%upload_file_used}}',['id'=>'1652','user_id'=>'11','file_id'=>'15378','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185489','update_time'=>'1657185489']);
        $this->insert('{{%upload_file_used}}',['id'=>'1653','user_id'=>'11','file_id'=>'15379','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185543','update_time'=>'1657185543']);
        $this->insert('{{%upload_file_used}}',['id'=>'1654','user_id'=>'11','file_id'=>'15380','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185561','update_time'=>'1657185561']);
        $this->insert('{{%upload_file_used}}',['id'=>'1655','user_id'=>'11','file_id'=>'15381','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185576','update_time'=>'1657185576']);
        $this->insert('{{%upload_file_used}}',['id'=>'1656','user_id'=>'11','file_id'=>'15382','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185612','update_time'=>'1657185612']);
        $this->insert('{{%upload_file_used}}',['id'=>'1657','user_id'=>'11','file_id'=>'15383','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185737','update_time'=>'1657185737']);
        $this->insert('{{%upload_file_used}}',['id'=>'1658','user_id'=>'11','file_id'=>'15384','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657185755','update_time'=>'1657185755']);
        $this->insert('{{%upload_file_used}}',['id'=>'1659','user_id'=>'11','file_id'=>'15385','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657187135','update_time'=>'1657187135']);
        $this->insert('{{%upload_file_used}}',['id'=>'1705','user_id'=>'11','file_id'=>'15431','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657256807','update_time'=>'1657256807']);
        $this->insert('{{%upload_file_used}}',['id'=>'1706','user_id'=>'11','file_id'=>'15432','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657256826','update_time'=>'1657256826']);
        $this->insert('{{%upload_file_used}}',['id'=>'1707','user_id'=>'11','file_id'=>'15433','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657256840','update_time'=>'1657256840']);
        $this->insert('{{%upload_file_used}}',['id'=>'1708','user_id'=>'11','file_id'=>'15434','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657262261','update_time'=>'1657262261']);
        $this->insert('{{%upload_file_used}}',['id'=>'1709','user_id'=>'11','file_id'=>'15435','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657268448','update_time'=>'1657268448']);
        $this->insert('{{%upload_file_used}}',['id'=>'1710','user_id'=>'11','file_id'=>'15436','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657269144','update_time'=>'1657269144']);
        $this->insert('{{%upload_file_used}}',['id'=>'1711','user_id'=>'11','file_id'=>'15437','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657269903','update_time'=>'1657269903']);
        $this->insert('{{%upload_file_used}}',['id'=>'1712','user_id'=>'11','file_id'=>'15438','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657275187','update_time'=>'1657275187']);
        $this->insert('{{%upload_file_used}}',['id'=>'1713','user_id'=>'11','file_id'=>'15439','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657275197','update_time'=>'1657275197']);
        $this->insert('{{%upload_file_used}}',['id'=>'1714','user_id'=>'11','file_id'=>'15440','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657505004','update_time'=>'1657505004']);
        $this->insert('{{%upload_file_used}}',['id'=>'1715','user_id'=>'11','file_id'=>'15441','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657507338','update_time'=>'1657507338']);
        $this->insert('{{%upload_file_used}}',['id'=>'1716','user_id'=>'11','file_id'=>'15442','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657507744','update_time'=>'1657507744']);
        $this->insert('{{%upload_file_used}}',['id'=>'1717','user_id'=>'11','file_id'=>'15443','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657509967','update_time'=>'1657509967']);
        $this->insert('{{%upload_file_used}}',['id'=>'1718','user_id'=>'11','file_id'=>'15444','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520178','update_time'=>'1657520178']);
        $this->insert('{{%upload_file_used}}',['id'=>'1719','user_id'=>'11','file_id'=>'15445','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520184','update_time'=>'1657520184']);
        $this->insert('{{%upload_file_used}}',['id'=>'1720','user_id'=>'11','file_id'=>'15446','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520293','update_time'=>'1657520293']);
        $this->insert('{{%upload_file_used}}',['id'=>'1721','user_id'=>'11','file_id'=>'15447','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520297','update_time'=>'1657520297']);
        $this->insert('{{%upload_file_used}}',['id'=>'1722','user_id'=>'11','file_id'=>'15448','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520639','update_time'=>'1657520639']);
        $this->insert('{{%upload_file_used}}',['id'=>'1723','user_id'=>'11','file_id'=>'15449','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520642','update_time'=>'1657520642']);
        $this->insert('{{%upload_file_used}}',['id'=>'1724','user_id'=>'11','file_id'=>'15450','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520734','update_time'=>'1657520734']);
        $this->insert('{{%upload_file_used}}',['id'=>'1725','user_id'=>'11','file_id'=>'15451','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520737','update_time'=>'1657520737']);
        $this->insert('{{%upload_file_used}}',['id'=>'1726','user_id'=>'11','file_id'=>'15452','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520828','update_time'=>'1657520828']);
        $this->insert('{{%upload_file_used}}',['id'=>'1727','user_id'=>'11','file_id'=>'15453','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520830','update_time'=>'1657520830']);
        $this->insert('{{%upload_file_used}}',['id'=>'1728','user_id'=>'11','file_id'=>'15454','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520900','update_time'=>'1657520900']);
        $this->insert('{{%upload_file_used}}',['id'=>'1729','user_id'=>'11','file_id'=>'15455','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520903','update_time'=>'1657520903']);
        $this->insert('{{%upload_file_used}}',['id'=>'1730','user_id'=>'11','file_id'=>'15456','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520982','update_time'=>'1657520982']);
        $this->insert('{{%upload_file_used}}',['id'=>'1731','user_id'=>'11','file_id'=>'15457','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657520985','update_time'=>'1657520985']);
        $this->insert('{{%upload_file_used}}',['id'=>'1732','user_id'=>'11','file_id'=>'15458','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657521054','update_time'=>'1657521054']);
        $this->insert('{{%upload_file_used}}',['id'=>'1733','user_id'=>'11','file_id'=>'15459','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657521058','update_time'=>'1657521058']);
        $this->insert('{{%upload_file_used}}',['id'=>'1734','user_id'=>'11','file_id'=>'15460','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657522557','update_time'=>'1657522557']);
        $this->insert('{{%upload_file_used}}',['id'=>'1735','user_id'=>'11','file_id'=>'15461','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657522568','update_time'=>'1657522568']);
        $this->insert('{{%upload_file_used}}',['id'=>'1736','user_id'=>'11','file_id'=>'15462','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657522596','update_time'=>'1657522596']);
        $this->insert('{{%upload_file_used}}',['id'=>'1737','user_id'=>'11','file_id'=>'15463','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657522611','update_time'=>'1657522611']);
        $this->insert('{{%upload_file_used}}',['id'=>'1742','user_id'=>'11','file_id'=>'15468','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657524333','update_time'=>'1657524333']);
        $this->insert('{{%upload_file_used}}',['id'=>'1743','user_id'=>'11','file_id'=>'15469','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657524401','update_time'=>'1657524401']);
        $this->insert('{{%upload_file_used}}',['id'=>'1744','user_id'=>'11','file_id'=>'15470','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657526634','update_time'=>'1657526634']);
        $this->insert('{{%upload_file_used}}',['id'=>'1745','user_id'=>'11','file_id'=>'15471','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657526755','update_time'=>'1657526755']);
        $this->insert('{{%upload_file_used}}',['id'=>'1746','user_id'=>'11','file_id'=>'15472','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657527533','update_time'=>'1657527533']);
        $this->insert('{{%upload_file_used}}',['id'=>'1747','user_id'=>'11','file_id'=>'15473','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657527731','update_time'=>'1657527731']);
        $this->insert('{{%upload_file_used}}',['id'=>'1767','user_id'=>'11','file_id'=>'15493','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657707445','update_time'=>'1657707445']);
        $this->insert('{{%upload_file_used}}',['id'=>'1768','user_id'=>'11','file_id'=>'15494','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657707464','update_time'=>'1657707464']);
        $this->insert('{{%upload_file_used}}',['id'=>'1769','user_id'=>'11','file_id'=>'15495','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657707476','update_time'=>'1657707476']);
        $this->insert('{{%upload_file_used}}',['id'=>'1770','user_id'=>'11','file_id'=>'15496','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657707493','update_time'=>'1657707493']);
        $this->insert('{{%upload_file_used}}',['id'=>'1771','user_id'=>'11','file_id'=>'15497','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657708607','update_time'=>'1657708607']);
        $this->insert('{{%upload_file_used}}',['id'=>'1772','user_id'=>'11','file_id'=>'15498','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657708678','update_time'=>'1657708678']);
        $this->insert('{{%upload_file_used}}',['id'=>'1773','user_id'=>'11','file_id'=>'15499','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657710011','update_time'=>'1657710011']);
        $this->insert('{{%upload_file_used}}',['id'=>'1774','user_id'=>'11','file_id'=>'15500','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657770430','update_time'=>'1657770430']);
        $this->insert('{{%upload_file_used}}',['id'=>'1775','user_id'=>'11','file_id'=>'15501','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657770554','update_time'=>'1657770554']);
        $this->insert('{{%upload_file_used}}',['id'=>'1776','user_id'=>'11','file_id'=>'15502','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657770759','update_time'=>'1657770759']);
        $this->insert('{{%upload_file_used}}',['id'=>'1777','user_id'=>'11','file_id'=>'15503','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657773504','update_time'=>'1657773504']);
        $this->insert('{{%upload_file_used}}',['id'=>'1778','user_id'=>'11','file_id'=>'15504','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657773515','update_time'=>'1657773515']);
        $this->insert('{{%upload_file_used}}',['id'=>'1779','user_id'=>'11','file_id'=>'15505','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657773531','update_time'=>'1657773531']);
        $this->insert('{{%upload_file_used}}',['id'=>'1780','user_id'=>'11','file_id'=>'15506','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657773544','update_time'=>'1657773544']);
        $this->insert('{{%upload_file_used}}',['id'=>'1781','user_id'=>'11','file_id'=>'15507','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657773662','update_time'=>'1657773662']);
        $this->insert('{{%upload_file_used}}',['id'=>'1782','user_id'=>'11','file_id'=>'15508','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657774003','update_time'=>'1657774003']);
        $this->insert('{{%upload_file_used}}',['id'=>'1783','user_id'=>'11','file_id'=>'15509','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657774056','update_time'=>'1657774056']);
        $this->insert('{{%upload_file_used}}',['id'=>'1784','user_id'=>'11','file_id'=>'15510','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657774599','update_time'=>'1657774599']);
        $this->insert('{{%upload_file_used}}',['id'=>'1787','user_id'=>'11','file_id'=>'15513','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781142','update_time'=>'1657781142']);
        $this->insert('{{%upload_file_used}}',['id'=>'1788','user_id'=>'11','file_id'=>'15514','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781146','update_time'=>'1657781146']);
        $this->insert('{{%upload_file_used}}',['id'=>'1789','user_id'=>'11','file_id'=>'15515','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781156','update_time'=>'1657781156']);
        $this->insert('{{%upload_file_used}}',['id'=>'1790','user_id'=>'11','file_id'=>'15516','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781158','update_time'=>'1657781158']);
        $this->insert('{{%upload_file_used}}',['id'=>'1791','user_id'=>'11','file_id'=>'15517','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781166','update_time'=>'1657781166']);
        $this->insert('{{%upload_file_used}}',['id'=>'1792','user_id'=>'11','file_id'=>'15518','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781170','update_time'=>'1657781170']);
        $this->insert('{{%upload_file_used}}',['id'=>'1793','user_id'=>'11','file_id'=>'15519','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781207','update_time'=>'1657781207']);
        $this->insert('{{%upload_file_used}}',['id'=>'1794','user_id'=>'11','file_id'=>'15520','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781212','update_time'=>'1657781212']);
        $this->insert('{{%upload_file_used}}',['id'=>'1795','user_id'=>'11','file_id'=>'15521','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781917','update_time'=>'1657781917']);
        $this->insert('{{%upload_file_used}}',['id'=>'1796','user_id'=>'11','file_id'=>'15522','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781942','update_time'=>'1657781942']);
        $this->insert('{{%upload_file_used}}',['id'=>'1797','user_id'=>'11','file_id'=>'15523','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781950','update_time'=>'1657781950']);
        $this->insert('{{%upload_file_used}}',['id'=>'1798','user_id'=>'11','file_id'=>'15524','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781953','update_time'=>'1657781953']);
        $this->insert('{{%upload_file_used}}',['id'=>'1799','user_id'=>'11','file_id'=>'15525','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781962','update_time'=>'1657781962']);
        $this->insert('{{%upload_file_used}}',['id'=>'1800','user_id'=>'11','file_id'=>'15526','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657781966','update_time'=>'1657781966']);
        $this->insert('{{%upload_file_used}}',['id'=>'1801','user_id'=>'11','file_id'=>'15527','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657782006','update_time'=>'1657782006']);
        $this->insert('{{%upload_file_used}}',['id'=>'1802','user_id'=>'11','file_id'=>'15528','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657782009','update_time'=>'1657782009']);
        $this->insert('{{%upload_file_used}}',['id'=>'1803','user_id'=>'11','file_id'=>'15529','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657782571','update_time'=>'1657782571']);
        $this->insert('{{%upload_file_used}}',['id'=>'1804','user_id'=>'11','file_id'=>'15530','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657783383','update_time'=>'1657783383']);
        $this->insert('{{%upload_file_used}}',['id'=>'1805','user_id'=>'11','file_id'=>'15531','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657783389','update_time'=>'1657783389']);
        $this->insert('{{%upload_file_used}}',['id'=>'1806','user_id'=>'11','file_id'=>'15532','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657783400','update_time'=>'1657783400']);
        $this->insert('{{%upload_file_used}}',['id'=>'1807','user_id'=>'11','file_id'=>'15533','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657784050','update_time'=>'1657784050']);
        $this->insert('{{%upload_file_used}}',['id'=>'1808','user_id'=>'11','file_id'=>'15534','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657794892','update_time'=>'1657794892']);
        $this->insert('{{%upload_file_used}}',['id'=>'1809','user_id'=>'11','file_id'=>'15535','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657848936','update_time'=>'1657848936']);
        $this->insert('{{%upload_file_used}}',['id'=>'1810','user_id'=>'11','file_id'=>'15536','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657849548','update_time'=>'1657849548']);
        $this->insert('{{%upload_file_used}}',['id'=>'1811','user_id'=>'11','file_id'=>'15537','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657865138','update_time'=>'1657865138']);
        $this->insert('{{%upload_file_used}}',['id'=>'1812','user_id'=>'11','file_id'=>'15538','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657865148','update_time'=>'1657865148']);
        $this->insert('{{%upload_file_used}}',['id'=>'1813','user_id'=>'11','file_id'=>'15539','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657865159','update_time'=>'1657865159']);
        $this->insert('{{%upload_file_used}}',['id'=>'1814','user_id'=>'11','file_id'=>'15540','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657865168','update_time'=>'1657865168']);
        $this->insert('{{%upload_file_used}}',['id'=>'1815','user_id'=>'11','file_id'=>'15541','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657865178','update_time'=>'1657865178']);
        $this->insert('{{%upload_file_used}}',['id'=>'1816','user_id'=>'11','file_id'=>'15542','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657865188','update_time'=>'1657865188']);
        $this->insert('{{%upload_file_used}}',['id'=>'1817','user_id'=>'11','file_id'=>'15543','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657865199','update_time'=>'1657865199']);
        $this->insert('{{%upload_file_used}}',['id'=>'1818','user_id'=>'11','file_id'=>'15544','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657865235','update_time'=>'1657865235']);
        $this->insert('{{%upload_file_used}}',['id'=>'1819','user_id'=>'11','file_id'=>'15545','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657867916','update_time'=>'1657867916']);
        $this->insert('{{%upload_file_used}}',['id'=>'1820','user_id'=>'11','file_id'=>'15546','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657867994','update_time'=>'1657867994']);
        $this->insert('{{%upload_file_used}}',['id'=>'1821','user_id'=>'11','file_id'=>'15547','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1657868035','update_time'=>'1657868035']);
        $this->insert('{{%upload_file_used}}',['id'=>'1822','user_id'=>'11','file_id'=>'15548','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659339754','update_time'=>'1659339754']);
        $this->insert('{{%upload_file_used}}',['id'=>'1823','user_id'=>'11','file_id'=>'15549','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659339766','update_time'=>'1659339766']);
        $this->insert('{{%upload_file_used}}',['id'=>'1824','user_id'=>'11','file_id'=>'15550','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659339773','update_time'=>'1659339773']);
        $this->insert('{{%upload_file_used}}',['id'=>'1825','user_id'=>'11','file_id'=>'15551','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659339788','update_time'=>'1659339788']);
        $this->insert('{{%upload_file_used}}',['id'=>'1826','user_id'=>'11','file_id'=>'15552','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659422901','update_time'=>'1659422901']);
        $this->insert('{{%upload_file_used}}',['id'=>'1827','user_id'=>'11','file_id'=>'15553','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659422911','update_time'=>'1659422911']);
        $this->insert('{{%upload_file_used}}',['id'=>'1828','user_id'=>'11','file_id'=>'15554','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659422917','update_time'=>'1659422917']);
        $this->insert('{{%upload_file_used}}',['id'=>'1829','user_id'=>'11','file_id'=>'15555','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659422922','update_time'=>'1659422922']);
        $this->insert('{{%upload_file_used}}',['id'=>'1830','user_id'=>'11','file_id'=>'15556','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659422927','update_time'=>'1659422927']);
        $this->insert('{{%upload_file_used}}',['id'=>'1831','user_id'=>'11','file_id'=>'15557','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659422933','update_time'=>'1659422933']);
        $this->insert('{{%upload_file_used}}',['id'=>'1832','user_id'=>'11','file_id'=>'15558','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659422938','update_time'=>'1659422938']);
        $this->insert('{{%upload_file_used}}',['id'=>'1833','user_id'=>'11','file_id'=>'15559','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659508480','update_time'=>'1659508480']);
        $this->insert('{{%upload_file_used}}',['id'=>'1834','user_id'=>'11','file_id'=>'15560','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1659508484','update_time'=>'1659508484']);
        $this->insert('{{%upload_file_used}}',['id'=>'1835','user_id'=>'11','file_id'=>'15561','bloc_id'=>'0','store_id'=>'0','from_type'=>'local','from_id'=>'0','create_time'=>'1659814431','update_time'=>'1659814431']);
        $this->insert('{{%upload_file_used}}',['id'=>'1836','user_id'=>'11','file_id'=>'15562','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1661399182','update_time'=>'1661399182']);
        $this->insert('{{%upload_file_used}}',['id'=>'1837','user_id'=>'11','file_id'=>'15563','bloc_id'=>'0','store_id'=>'0','from_type'=>'local','from_id'=>'0','create_time'=>'1661772422','update_time'=>'1661772422']);
        $this->insert('{{%upload_file_used}}',['id'=>'1838','user_id'=>'11','file_id'=>'15564','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1664416690','update_time'=>'1664416690']);
        $this->insert('{{%upload_file_used}}',['id'=>'1839','user_id'=>'11','file_id'=>'15565','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1665281168','update_time'=>'1665281168']);
        $this->insert('{{%upload_file_used}}',['id'=>'1840','user_id'=>'11','file_id'=>'15566','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1665281355','update_time'=>'1665281355']);
        $this->insert('{{%upload_file_used}}',['id'=>'1841','user_id'=>'48','file_id'=>'15567','bloc_id'=>'13','store_id'=>'64','from_type'=>'local','from_id'=>'0','create_time'=>'1666344883','update_time'=>'1666344883']);
        $this->insert('{{%upload_file_used}}',['id'=>'1842','user_id'=>'49','file_id'=>'15568','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1666420086','update_time'=>'1666420086']);
        $this->insert('{{%upload_file_used}}',['id'=>'1843','user_id'=>'11','file_id'=>'15569','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1666422149','update_time'=>'1666422149']);
        $this->insert('{{%upload_file_used}}',['id'=>'1844','user_id'=>'48','file_id'=>'15570','bloc_id'=>'16','store_id'=>'65','from_type'=>'local','from_id'=>'0','create_time'=>'1666459869','update_time'=>'1666459869']);
        $this->insert('{{%upload_file_used}}',['id'=>'1845','user_id'=>'11','file_id'=>'15571','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1666595388','update_time'=>'1666595388']);
        $this->insert('{{%upload_file_used}}',['id'=>'1846','user_id'=>'11','file_id'=>'15572','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1666595394','update_time'=>'1666595394']);
        $this->insert('{{%upload_file_used}}',['id'=>'1847','user_id'=>'11','file_id'=>'15573','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1666595442','update_time'=>'1666595442']);
        $this->insert('{{%upload_file_used}}',['id'=>'1848','user_id'=>'11','file_id'=>'15574','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1666595455','update_time'=>'1666595455']);
        $this->insert('{{%upload_file_used}}',['id'=>'1849','user_id'=>'11','file_id'=>'15575','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1666595464','update_time'=>'1666595464']);
        $this->insert('{{%upload_file_used}}',['id'=>'1850','user_id'=>'49','file_id'=>'15576','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1666599815','update_time'=>'1666599815']);
        $this->insert('{{%upload_file_used}}',['id'=>'1851','user_id'=>'45','file_id'=>'15577','bloc_id'=>'31','store_id'=>'66','from_type'=>'local','from_id'=>'0','create_time'=>'1666682278','update_time'=>'1666682278']);
        $this->insert('{{%upload_file_used}}',['id'=>'1852','user_id'=>'11','file_id'=>'15578','bloc_id'=>'28','store_id'=>'71','from_type'=>'local','from_id'=>'0','create_time'=>'1666770463','update_time'=>'1666770463']);
        $this->insert('{{%upload_file_used}}',['id'=>'1853','user_id'=>'11','file_id'=>'15579','bloc_id'=>'28','store_id'=>'71','from_type'=>'local','from_id'=>'0','create_time'=>'1666772732','update_time'=>'1666772732']);
        $this->insert('{{%upload_file_used}}',['id'=>'1854','user_id'=>'47','file_id'=>'15580','bloc_id'=>'16','store_id'=>'65','from_type'=>'local','from_id'=>'0','create_time'=>'1666775553','update_time'=>'1666775553']);
        $this->insert('{{%upload_file_used}}',['id'=>'1855','user_id'=>'53','file_id'=>'15581','bloc_id'=>'28','store_id'=>'71','from_type'=>'local','from_id'=>'0','create_time'=>'1666783199','update_time'=>'1666783199']);
        $this->insert('{{%upload_file_used}}',['id'=>'1856','user_id'=>'11','file_id'=>'15582','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1667211289','update_time'=>'1667211289']);
        $this->insert('{{%upload_file_used}}',['id'=>'1857','user_id'=>'11','file_id'=>'15583','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1667211523','update_time'=>'1667211523']);
        $this->insert('{{%upload_file_used}}',['id'=>'1858','user_id'=>'11','file_id'=>'15584','bloc_id'=>'8','store_id'=>'61','from_type'=>'alioss','from_id'=>'0','create_time'=>'1667211643','update_time'=>'1667211643']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%upload_file_used}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

