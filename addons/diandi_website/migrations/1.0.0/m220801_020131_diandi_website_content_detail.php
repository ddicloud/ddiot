<?php

use yii\db\Migration;

class m220801_020131_diandi_website_content_detail extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%diandi_website_content_detail}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            'content_id' => "int(11) NOT NULL",
            'detail' => "text NOT NULL",
            'params' => "varchar(1000) NOT NULL DEFAULT ''",
            'file_url' => "varchar(255) NOT NULL DEFAULT ''",
            'created_at' => "int(11) NULL",
            'updated_at' => "int(11) NULL",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
        
        /* 索引设置 */
        $this->createIndex('i-content','{{%diandi_website_content_detail}}','content_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'1','content_id'=>'1','detail'=>'测试detail,123232,45454545','params'=>'','file_url'=>'','created_at'=>'1481264096','updated_at'=>'1481269292']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'3','content_id'=>'7','detail'=>'测试测试','params'=>'','file_url'=>'','created_at'=>'1481264976','updated_at'=>'1481379895']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'4','content_id'=>'9','detail'=>'dsfdsfdsfdsfdsdfsdfds','params'=>'','file_url'=>'','created_at'=>'1481265228','updated_at'=>'1481265228']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'5','content_id'=>'10','detail'=>'打算vdsvdsdsfadf是打发第三方打发第三方','params'=>'','file_url'=>'','created_at'=>'1481265362','updated_at'=>'1481265362']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'6','content_id'=>'11','detail'=>'是的撒FDSAD','params'=>'','file_url'=>'','created_at'=>'1481265454','updated_at'=>'1481265454']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'7','content_id'=>'13','detail'=>'dfadsfda','params'=>'','file_url'=>'','created_at'=>'1481265650','updated_at'=>'1481265650']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'8','content_id'=>'14','detail'=>'dsfdsfdsfdsfds','params'=>'','file_url'=>'','created_at'=>'1481268136','updated_at'=>'1481268136']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'9','content_id'=>'15','detail'=>'电风扇的范德萨发生的','params'=>'','file_url'=>'','created_at'=>'1481268506','updated_at'=>'1481268506']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'10','content_id'=>'16','detail'=>'大多数是范德萨','params'=>'','file_url'=>'','created_at'=>'1481268645','updated_at'=>'1481268645']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'11','content_id'=>'17','detail'=>'<p><img src=\"/uploads/redactor-img/1/892f7f6043-9c1ab2f5-f848-4e09-bb3e-9b10c2938520.png\" alt=\"892f7f6043-9c1ab2f5-f848-4e09-bb3e-9b10c2938520.png\"/>测试测试</p>','params'=>'','file_url'=>'','created_at'=>'1481294417','updated_at'=>'1482486244']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'12','content_id'=>'18','detail'=>'测试测试测试','params'=>'','file_url'=>'','created_at'=>'1481294436','updated_at'=>'1481294436']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'13','content_id'=>'19','detail'=>'<p>水电费的所得税法</p><p><img src=\"/uploads/redactor-img/1/892f7f6043-9c1ab2f5-f848-4e09-bb3e-9b10c2938520.png\"></p><p><br></p><p><img></p>','params'=>'','file_url'=>'','created_at'=>'1481294458','updated_at'=>'1482120320']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'14','content_id'=>'20','detail'=>'<p><img></p><p><img src=\"/uploads/redactor-img/1/3c779817e7-9c1ab2f5-f848-4e09-bb3e-9b10c2938520.png\"></p><p><img></p><p><img></p><p>发货相关问题</p><p>SEND ABOUT</p><p>购买来源：本店所有商品均为海外购，所有海外购商品均从（美国、欧洲、香港）正品专柜、官网、百货公司购买，正品保证，请放心选购。</p><p>邮寄方式：本店商品均为海外直发，欧洲商家一般经由我们香港仓、澳门仓等中转再转发国内快递发往您；美国商家一般采用美国直邮方式到国内自动转为EMS直接发往您。</p><p>物流显示：因淘宝物流显示问题，本店商品到达国内才会转为发货状态并显示国内物流单号。一般商品到货时间为2-4周。因而当您的订单淘宝未显示发货，请不要心急，商品都在正常国际运输中，我们全程为您监控物流进程，如有异常会及时通知您。如有疑问，可以咨询在线客服，请勿催单哦！</p><p>特别提醒：以上发货及运送时间均为理论时效，但偶有意外如恶劣天气、清关延误、节假日等国际物流的不确定因素请理性看待。</p><p>退换货政策详解</p><p>RETURN POLICY</p><p>商品签收： 确认签收前，请务必 本人签收 ，并当场拍照验货。如遇 严重质量问题或商品错发 请保留商品问题照片及物流签收有效凭证联系 在线客服处理。 如签收后发现严重质量问题请在签收时间起 48小时内 联系处理， 过后恕不负责，且需保持商品完好无损 （产品包装、吊牌、配件保持原样情况下）。 本店不接受任何形式的拒收 ，如因拒收产生一切后果由收件人负责。</p><p>退换说明： 本店不支持退换货，除严重商品质量问题和商品错发外。</p><p>码数、型号、颜色、款式、均由顾客自行决定，客服建议只供参考，不对此负责，不作为退换货理由。</p><p>所有主观原因(但不限于)：面料与想象有差距，例如厚薄或透明度、手感软硬等。不适合自己、穿上不好看、没想象中漂亮。个人认为做工不好等。细微瑕疵、线头、不明显或可去除的画粉痕迹、极好处理的小脱线，存在于鞋底的污迹或刮痕，不明显处的走线不直、偶尔有烫钻装饰的脱落、细微的印花脱落开裂、羽毛制品轻量掉毛，因运输造成的不平整或皱折、不同显示器解析度和颜色质量造成的网上图片与实物颜色存在一定色差、主观认为不是正品等，均不属于质量问题，不支持退换货。</p><p>退货地址：由于我公司为海外公司，商品均为海外直发， 退货需退回指定的海外物流仓库，详情请咨询在线客服。若因寄到非指定的退货地址，造成商品退换货失败，客户需自行承担后果。</p><p>差价问题：关于打折商品购买之后再度打折，或原来价格商品购买之后打折的情况，本店不退差价。</p><p>关税问题：  如遇海关查验，按照海关规定，收件人为办理清关和交纳税金的责任人。 税金产生后无法办理退货退款 。 为保证清关的顺利， 请填写收件人姓名的时候务必使用真实姓名 ，如使用假名将无法正常完成清关，导致扣件等情况，一切后果将由收件人承担。</p><p>如协商一致退货，请务必遵守如下规则：</p><p>本店不接受未经沟通自主邮寄包裹的退换货，如自行邮寄一律拒收。</p><p>本店不接受任何到付件，寄送包裹需要亲先行垫付邮费。</p><p>请务必保持退货商品的标签吊牌包装等的商品完整性。</p><p>寄出包裹后，请联系客服告知物流公司和运单号码，方便客服查询。</p>','params'=>'','file_url'=>'','created_at'=>'1481455753','updated_at'=>'1482071209']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'15','content_id'=>'21','detail'=>'sadsadsadasdas122333333','params'=>'','file_url'=>'','created_at'=>'1481463544','updated_at'=>'1481552670']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'16','content_id'=>'22','detail'=>'测试测试测试','params'=>'','file_url'=>'','created_at'=>'1481463619','updated_at'=>'1481463619']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'17','content_id'=>'23','detail'=>'测试测试测试','params'=>'','file_url'=>'','created_at'=>'1481465189','updated_at'=>'1481465189']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'18','content_id'=>'24','detail'=>'<p>sdsadsadasdsaasdsadcas</p><p><img src=\"/uploads/redactor-img/1/99ebc906c2-a165a89a-83d3-4882-948c-a551be1bb769.jpg\"></p>','params'=>'','file_url'=>'','created_at'=>'1481465708','updated_at'=>'1482120751']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'19','content_id'=>'25','detail'=>'商品由美国百货公司发货，下单即采购。约1~2周到货。
商品货号：s1569032116
商品说明：
重度磨损和猫须褶皱为这款褪色 MOTHER 牛仔裤带来做旧效果。5 口袋设计。钮扣和拉链门襟。

面料: 弹性牛仔布。
98% 棉 / 2% 弹性纤维。
冷水洗涤。
美国制造。
进口面料。

尺寸
裆高: 9.75 英寸 / 25 厘米
裤子内长: 28.75 英寸 / 73 厘米
裤脚口: 11.75 英寸 / 30 厘米
所列尺寸以 27 号为标准 2010 年，受到突破传统牛仔裤的启发，业内专家 Lela Tillem (Citizens of Humanity) 和 Tim Kaeding (7 For All Mankind) 推出了 MOTHER 牛仔服饰：精致裁剪、超软织物的奢华牛仔裤系列。MOTHER 牛仔裤将显长腿部的外型、创新的水洗工艺、完美的修身效果和令人难以置信的舒适感融入到高度演变的奢华牛仔系列中。这款高级牛仔裤适合并修饰各种体型。 查看所有 MOTHER 的评论
售后服务：香港仓库收到日期计起30天可以申请退换货,final sale不退不换,商家运费$35
最后更新：2016-10-27 22:03','params'=>'','file_url'=>'','created_at'=>'1481552501','updated_at'=>'1481552688']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'20','content_id'=>'26','detail'=>'<p>关于公司考勤制度</p>','params'=>'','file_url'=>'/uploads/downloads/yiicms5857e77c7167d.zip','created_at'=>'1482155706','updated_at'=>'1482157422']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'21','content_id'=>'27','detail'=>'<p>测试测试<span class=\"redactor-invisible-space\">测试<span class=\"redactor-invisible-space\">测试<span class=\"redactor-invisible-space\">测试<span class=\"redactor-invisible-space\">测试<span class=\"redactor-invisible-space\"></span></span></span></span></span></p>','params'=>'','file_url'=>'/uploads/downloads/yiicms585893d4e19c8.zip','created_at'=>'1482200020','updated_at'=>'1482202904']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'22','content_id'=>'28','detail'=>'<p>继承测试</p>','params'=>'','file_url'=>'','created_at'=>'1482291369','updated_at'=>'1482291661']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'23','content_id'=>'29','detail'=>'<p>产品继承</p>','params'=>'<p>产品继承</p>','file_url'=>'','created_at'=>NULL,'updated_at'=>'1482325074']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'24','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585e2a68b0fe2.jpg','created_at'=>'1482566248','updated_at'=>'1482566248']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'25','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585e2abda64a2.jpg','created_at'=>'1482566333','updated_at'=>'1482566333']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'26','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585f60a17b4fa.jpg','created_at'=>'1482645665','updated_at'=>'1482645665']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'27','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585f60a888c8a.jpg','created_at'=>'1482645672','updated_at'=>'1482645672']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'28','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585f60bbb3340.jpg','created_at'=>'1482645691','updated_at'=>'1482645691']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'29','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585f73b9d439b.jpg','created_at'=>'1482650553','updated_at'=>'1482650553']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'30','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585f7414e39c8.jpg','created_at'=>'1482650644','updated_at'=>'1482650644']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'31','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585f7a31d66e1.jpg','created_at'=>'1482652209','updated_at'=>'1482652209']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'32','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585f7a84578d6.jpg','created_at'=>'1482652292','updated_at'=>'1482652292']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'33','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585f7afeb8410.jpg','created_at'=>'1482652414','updated_at'=>'1482652414']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'34','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585f7c8f432bd.png','created_at'=>'1482652815','updated_at'=>'1482652815']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'35','content_id'=>'30','detail'=>'','params'=>'','file_url'=>'/uploads/photos/30/img_585f7cabe31fd.jpg','created_at'=>'1482652843','updated_at'=>'1482652843']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'36','content_id'=>'31','detail'=>'ceshi','params'=>'','file_url'=>'/uploads/photos/31/img_585f8410249c6.jpg','created_at'=>'1482654736','updated_at'=>'1482913682']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'37','content_id'=>'31','detail'=>'测试2','params'=>'','file_url'=>'/uploads/photos/31/img_585f84183ea3b.jpg','created_at'=>'1482654744','updated_at'=>'1482822674']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'38','content_id'=>'31','detail'=>'ceshi34','params'=>'','file_url'=>'/uploads/photos/31/img_585f8410249c6.jpg','created_at'=>'1482655165','updated_at'=>'1482913687']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'39','content_id'=>'32','detail'=>'<p>ssss</p>','params'=>'','file_url'=>'/uploads/downloads/yiicms58cb8007d61e7.rar','created_at'=>'1489731591','updated_at'=>'1489731591']);
        $this->insert('{{%diandi_website_content_detail}}',['id'=>'40','content_id'=>'33','detail'=>'<p>是打发第三方</p>','params'=>'<p>胜多负少订单上</p>','file_url'=>'','created_at'=>'1494325122','updated_at'=>'1494325122']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%diandi_website_content_detail}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

