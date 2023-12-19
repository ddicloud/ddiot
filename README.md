
# 欢迎使用店滴 cms(ddiot)
![在这里插入图片描述](https://diandi-1255369109.cos.ap-nanjing.myqcloud.com/cms%2F479ed84d544cfcb0f5a7e7be2f5f60c.jpg)

店滴云，让经营场所，更智能。围绕茶室、酒店、健身房、公寓、出租房等经营性场所进行物联网改造。同时支持多种物联网通信协议，开放智能门锁，智能开关，智能手环的sdk供开发者使用。


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
- 多模块可安装，便于迅速扩展业务，支持横向纵向双向扩展业务需求
- 表单多样，除 yii 自身的表单组件，系统还对表单做了丰富，支持一句话配置万能表单
- gii代码自动生成，包括扩展模块，数据库模型，检索模型，控制器和接口都可以自动生成
- element-ui+uniapp+店滴cms，中后台，多端兼容，数据处理全部支持且开源

## 基于element-ui的后台：ddAdmin

```js
    git clone https://gitee.com/wayfirer/dd-admin.git
```


# 环境准备：

    Php>=8.1
    Redis 7.0.0
    MySQL 5.6.50


# 第一步：git 下载代码

```
git clone https://gitee.com/wayfirer/ddicms.git

```

# 第二步：composer 扩展安装

```
cd 你的项目根路径
php composer.phar install

```

# 注：第一步和第二步也可以合并，缺点是后续git更新不方便，优点是安装快捷

```
composer create-project ddicloud/ddicms

```

# 第三步：执行安装命令




```

    php ./yii install

说明：提醒输入数据库版本，请输入：1.0.0


```

# 第五步：Nginx 部署配置

首先解析网站到 frontend，然后配置 nginx 如下：

```
server {
        listen        80;
        server_name  www.ai.com;
        root   "ddicms/frontend";
        add_header Access-Control-Allow-Origin *;
        add_header Access-Control-Allow-Headers X-Requested-With,Authorization,Content-Type,access-token,bloc-id,store-id;
        add_header Access-Control-Allow-Methods GET,POST,OPTIONS,PUT,DELETE;
        location / {
            index index.php index.html error/index.html;
            error_page 400 /error/400.html;
            error_page 403 /error/403.html;
            error_page 404 /error/404.html;
            error_page 500 /error/500.html;
            error_page 501 /error/501.html;
            error_page 502 /error/502.html;
            error_page 503 /error/503.html;
            error_page 504 /error/504.html;
            error_page 505 /error/505.html;
            error_page 506 /error/506.html;
            error_page 507 /error/507.html;
            error_page 509 /error/509.html;
            error_page 510 /error/510.html;
            include D:/www/firetech/frontend/web/nginx.htaccess;
            autoindex  off;
        }
        location ~ \.php(.*)$ {
            fastcgi_pass   127.0.0.1:9001;
            fastcgi_index  index.php;
            fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            fastcgi_param  PATH_INFO  $fastcgi_path_info;
            fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
            include        fastcgi_params;
        }
        location /backend {
            index index.html  index.php;
            if (!-e $request_filename)
            {
                rewrite ^/backend/(.*)$ /backend/index.html last;
            }
        }
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
            if (!-f $request_filename){
                set $rule_0 1$rule_0;
            }
        }
        
         location /help {
            index index.php index.html;
            if (!-e $request_filename)
            {
                rewrite ^/help/(.*)$ /help/index.php last;
            }
            if (!-f $request_filename){
                set $rule_0 1$rule_0;
            }
        }
        
        gzip on;
      	gzip_comp_level 5;
      	gzip_min_length 256;
      	gzip_proxied any;
      	gzip_vary on;
}

```
# 特别鸣谢

感谢以下的项目，排名不分先后

- Yii：http://www.yiiframework.com

- EasyWechat：https://www.easywechat.com

- AdminLTE：https://adminlte.io

- Vue: https://vuejs.org/

- vue-ele-form: https://github.com/dream2023/vue-ele-form

- element-ui: https://element.eleme.cn/

- 百度ai:https://ai.baidu.com/