
# 欢迎使用店滴 cms(ddicms)
![在这里插入图片描述](https://diandi-1255369109.cos.ap-nanjing.myqcloud.com/cms%2F479ed84d544cfcb0f5a7e7be2f5f60c.jpg)

店滴云是针对多商户业务开发的一套管理cms，支持多运营主体，单运营主体运营开发。基于世界上最好的语言php和yii开发，深度集成swoole,满足需要http/tcp/mqtt等多种协议的业务场景，官方提供智能门锁，智能开关成熟的解决方案。采用最新的vue开发技术作为中后台管理，多终端开发框架uniapp打造，旨在让开发更有趣味和成就感，希望可以助力更多的中小企业实现业绩增长，技术创新和持续发展。官方依赖于店滴云先后开发了疫情大数据监测，企业外呼，im客服，多商户分销，外卖点餐，政企党建等系统。


## 官方地址
[店滴云官网](https://www.dandicloud.com/)
[官方开源库](https://toscode.gitee.com/wayfirer)
[cms源码](https://toscode.gitee.com/wayfirer/ddicms)
#### 开发者参与   

## qq群

：823429313，点击可直接加入：[开发者交流群](https://jq.qq.com/?_wv=1027&k=4d2Rl2lc)

## 微信公众号
![在这里插入图片描述](https://diandi-1255369109.cos.ap-nanjing.myqcloud.com/cms%2F8edc20c70e46975e7520a8961414295.jpg)
# 特性
- 使用稳定的 YII 框架，优化处理开发过程，开发体验如 tp 一样顺滑。
- 支持多层权限管控，路由权限，数据权限，菜单权限，集团权限，商户权限，扩展功能权限随意搭配调度
- 基于 swoole 协程化，定时任务调度，im 聊天环境支持，系统接口支持协程,应对高并发
- 开源百度 ai 接口对接，完成人脸库维护，人脸库创建，人脸库在线识别，人脸会员建立
- 多模块可安装，便于迅速扩展业务，支持横向纵向双向扩展业务需求
- 后台支持多种开发模式，php 混合开发，element-ui 的 vue 开发模式，纯 html 的传统开发都支持
- 表单多样，除 yii 自身的表单组件，系统还对表单做了丰富，支持一句话配置万能表单
- gii代码自动生成，包括扩展模块，数据库模型，检索模型，控制器和接口都可以自动生成
- element-ui+uniapp+店滴cms，中后台，多端兼容，数据处理全部支持且开源

# 环境准备：

    php>=7.3
    redis
    git 工具下载：https://git-scm.com/downloads
    composer https://www.phpcomposer.com/
    composer建议使用阿里镜像 https://developer.aliyun.com/composer

# 第一步：git 下载代码

```
git clone https://toscode.gitee.com/wayfirer/ddicms.git

```

# 第二步：更新 composer 扩展

```
cd 你的文件路径
composer update

```

# 第三步：建立数据库并完成配置

```
cd common\config

vim common\config\main-local.php

```

```
<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 20:12:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-09 18:25:50
 */

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=netos',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'attributes'  => [
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES  => false,
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
    'language' => 'zh-CN',

];


```

# Nginx 部署配置

首先解析网站到 frontend\web，然后配置 nginx 如下：

```
server {
        listen        80;
        server_name  www.ai.com;
        root   "*/firetech/frontend/web";
       add_header Access-Control-Allow-Origin *;
    add_header Access-Control-Allow-Headers X-Requested-With,Authorization,Content-Type,access-token,bloc-id,store-id;
    add_header Access-Control-Allow-Methods GET,POST,OPTIONS,DELETE,PUT;

        location /api {
            index index.php index.html;
            if (!-e $request_filename)
            {
                rewrite ^/api/(.*)$ /api/index.php last;
            }
            if (!-f $request_filename){
                set $rule_0 1$rule_0;
            }
        }

        location /admin {
            index index.php index.html;
            if (!-e $request_filename)
            {
                rewrite ^/admin/(.*)$ /admin/index.php last;
            }
        }
}


```
# 特别鸣谢

感谢以下的项目，排名不分先后

- Yii：http://www.yiiframework.com

- EasyWechat：https://www.easywechat.com

- Bootstrap：http://getbootstrap.com

- AdminLTE：https://adminlte.io

- Vue: https://vuejs.org/

- vue-ele-form: https://github.com/dream2023/vue-ele-form

- element-ui: https://element.eleme.cn/

- 百度ai:https://ai.baidu.com/