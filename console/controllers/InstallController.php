<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-02 12:49:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-01 23:32:37
 */

namespace console\controllers;

use console\services\InstallServer;
use PDOException;
use Yii;
use yii\console\widgets\Table;
use yii\db\Exception;
use yii\db\mssql\PDO;
use yii\helpers\Console;
use admin\models\User;

// 使用示例： ./yii addons -addons=diandi_lottery -bloc_id=1 -store_id=3   job ninini

class InstallController extends \yii\console\Controller
{
    public function actionIndex()
    {
        // 第一步配置数据库
        // $sqlType = Console::select("数据库类型：",['mysql'=>'mysql','sqlserver'=>'sqlserver']);
        // $sqlTypeVal = Console::ansiFormat($sqlType,[Console::FG_YELLOW]);
        Console::output('感谢使用店滴云CMS，小滴帮您配置mysql');

        $is_connect = false;
        do {
            $host = Console::input('请输入host：');
            // $formatName = Console::ansiFormat($host, [Console::FG_YELLOW]);
            // Console::output("你的host是：{$formatName}");
            $port = Console::input('请输入数据库端口port：');
            $dbname = Console::input('请输入dbname：');
            $tablePrefix = Console::input('请输入数据库前缀tablePrefix：');
            $username = Console::input('请输入数据库username：');
            $password = Console::input('请输入数据库password：');
            $confTable = Table::widget([
                'headers' => ['host', 'port', 'dbname', 'tablePrefix', 'username', 'password'],
                'rows' => [
                    [$host, $port, $dbname, $tablePrefix, $username, $password],
                ],
            ]);

            Console::output('你的数据库配置汇总：'.PHP_EOL."{$confTable}");

            $config = InstallServer::local_mysql_config();

            $config = str_replace([
                '{db-host}', '{db-port}', '{db-dbname}', '{db-tablePrefix}', '{db-username}', '{db-password}',
            ], [
                $host, $port, $dbname, $tablePrefix, $username, $password,
            ], $config);

            $error = '';
            try {
                $link = new PDO("mysql:host={$host};port={$port}", $username, $password); 	// dns可以没有dbname
                $link->exec('SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary');
                $link->exec("SET sql_mode=''");
                if ($link->errorCode() != '00000') {
                    $errorInfo = $link->errorInfo();
                    $error = $errorInfo[2];
                } else {
                    $statement = $link->query("SHOW DATABASES LIKE '{$dbname}';");
                    $fetch = $statement->fetch();
                    if (empty($fetch)) {
                        if (substr($link->getAttribute(PDO::ATTR_SERVER_VERSION), 0, 3) > '4.1') {
                            $link->query("CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8");
                        } else {
                            $link->query("CREATE DATABASE IF NOT EXISTS `{$dbname}`");
                        }
                    }
                    $statement = $link->query("SHOW DATABASES LIKE '{$dbname}';");
                    $fetch = $statement->fetch();
                    if (empty($fetch)) {
                        $error .= '数据库不存在且创建数据库失败. <br />';
                    } else {
                        $is_connect = true;
                    }
                    if ($link->errorCode() != '00000') {
                        $errorInfo = $link->errorInfo();
                        $error .= $errorInfo[2];
                    }
                }
            } catch (Exception $e) {
                $errorMsg = $e->getMessage();
                $is_connect = false;
                Console::output("Exception:{$errorMsg}");
            } catch (PDOException $e) {
                $error = $e->getMessage();
                if (strpos($error, 'Access denied for user') !== false) {
                    $error = '您的数据库访问用户名或是密码错误. <br />';
                } else {
                    $error = iconv('gbk', 'utf8', $error);
                }
                Console::output("PDOException:{$error}");
            }

            if ($is_connect) {
                file_put_contents(yii::getAlias('@common/config/db.php'), $config);
                Console::input('数据库配置成功，下一步初始化数据库');
            } else {
                Console::input('数据库无法连接，请回车后重新配置');
            }
        } while (!$is_connect);

        // 初始数据库
        $version = Console::input('请输入数据库脚本版本号：');

        $bashPath = dirname(Yii::getAlias('@console'));
        $oldAPP =  Yii::$app;
        Yii::$app = new \yii\console\Application([
            'id' => 'install-console',
            'basePath' => $bashPath,
            'components' => [
                'service' => [
                    'class' => 'common\services\BaseService',
                ],
                'cache' => [
                    'class' => 'yii\caching\FileCache', 
                    'cachePath' => '@runtime/cache2', 
                ],
                'user' => [
                    'class' => 'yii\web\User',
                    'identityClass' => 'admin\models\DdApiAccessToken',
                    'enableAutoLogin' => false,
                    'enableSession' => false,
                    'loginUrl' => '/',
                    'identityCookie' => ['name' => '_identity-admin', 'httpOnly' => true],
                ],
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => "mysql:host={$host};dbname={$dbname};port={$port}",
                    'tablePrefix' => "{$tablePrefix}",
                    'username' => "{$username}",
                    'password' => "{$password}",
                    'charset' => 'utf8',
                    'attributes' => [
                        PDO::ATTR_STRINGIFY_FETCHES => false,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ],
                    'enableSchemaCache' => true,
                    // Duration of schema cache.
                    'schemaCacheDuration' => 3600,

                    // Name of the cache component used to store schema information
                    'schemaCache' => 'cache',
                ],
            ],
        ]);
        $runResult = Yii::$app->runAction('migrate/up', ['migrationPath' => '@console/migrations/'.$version, 'interactive' => false]);
        // $post_log = ob_get_clean();
        // Yii::info($post_log, 'fecshop_debug');
        Console::input('数据库初始成功，下一步注册管理员');
        ob_start();
        ob_implicit_flush(false);
        $username = Console::input('请输入管理员名称(字母不含特殊字符)：');
        
        $mobile = Console::input('请输入手机号：');
        $email = Console::input('请输入邮箱：');
        $password = Console::input('请输入密码：');
        $repassword = Console::input('再次输入密码：');
        
        if($password === $repassword){
            $res = InstallServer::adminSignUp($username, $mobile, $email, $password);     
            if($res){
                 Console::input('管理员注册成功，下一步初始系统文件权限');
            }       
        }

        // 设置文件权限

        // nginx配置
        $baseDir = dirname(__FILE__).'/../../';

        $dirs = ['api/runtime/', 'backend/assets/', 'backend/runtime/', 'frontend/runtime/', 'frontend/web/assets/', 'frontend/web/backend/assets', 'frontend/web/attachment', 'console/swoole/runtime/', 'admin/runtime/'];

        foreach ($dirs as $key => $value) {
            if (is_dir($baseDir.$value)) {
                chmod($baseDir.$value, 0777);
            } else {
                mkdir($baseDir.$value, 0777);
                chmod($baseDir.$value, 0777);
            }
            echo '目录'.$value.'权限设置成功'.PHP_EOL;
            sleep(1);
        }
    }

    public function actionSignUp()
    {
        // $post_log = ob_get_clean();
        // Yii::info($post_log, 'fecshop_debug');
        Console::input('数据库初始成功，下一步注册管理员');
        
        $username = Console::input('请输入管理员名称(字母不含特殊字符)：');
        
        $mobile = Console::input('请输入手机号：');
        $email = Console::input('请输入邮箱：');
        $password = Console::input('请输入密码：');
        $repassword = Console::input('再次输入密码：');
        
        if($password === $repassword){
            $res = InstallServer::adminSignUp($username, $mobile, $email, $password);     
            if($res){
                 Console::input('管理员注册成功，下一步初始系统文件权限');
            }       
        }

    }

    public function actionIndexs()
    {
        /* 普通输出 */
        Console::output('hello world!');

        /* 前景色，背景色输出 */
        $fg = Console::ansiFormat('前景色', [Console::FG_GREEN]);
        $bg = Console::ansiFormat('背景色', [Console::BG_RED]);
        Console::output("{$fg}{$bg}");

        /* 同一变量设置前景色，背景色 */
        /**
         * 前景色 FG_BLACK / FG_RED / FG_GREEN / FG_YELLOW / FG_BLUE / FG_PURPLE / FG_CYAN / FG_GREY
         * 背景色 BG_BLACK / BG_RED / BG_GREEN / BG_YELLOW / BG_BLUE / BG_PURPLE / BG_CYAN / BG_GREY.
         */
        $hello = Console::ansiFormat('Hello，Beijing!', [Console::FG_YELLOW, Console::BG_BLUE]);
        Console::output($hello);

        /* 变量输出字体正常，加粗，斜体，下划线，底色 */
        Console::output(Console::ansiFormat('normal（正常）', [Console::NORMAL]));
        Console::output(Console::ansiFormat('bold（加粗）', [Console::BOLD]));
        Console::output(Console::ansiFormat('italic（斜体）', [Console::ITALIC]));
        Console::output(Console::ansiFormat('underline（下划线）', [Console::UNDERLINE]));
        Console::output(Console::ansiFormat('negative（底色）', [Console::NEGATIVE]));

        /* 用户输入 */
        $name = Console::input('请输入你的名字：');
        $formatName = Console::ansiFormat($name, [Console::FG_YELLOW]);
        Console::output("你的名字是：{$formatName}");

        /* 用户选择1（select） */
        $sex = Console::select('性别：', [1 => '男', 2 => '女']);
        $formatSex = Console::ansiFormat($sex, [Console::FG_YELLOW]);
        Console::output("你的性别是：{$formatSex}");

        /* 用户选择2（yes or no） */
        if (Console::confirm('Are you sure?')) {
            Console::output('user input yes');
        } else {
            Console::output('user input no');
        }

        /* 用户输入3（验证） */
        /*
         *required 真假，是否必须填写
         *default 默认值
         *pattern 正则匹配
         *validator 自定义验证函数
         *error 错误信息
         */
        Console::prompt('请输入你的姓名:', ['required' => true, 'error' => '===>姓名必须输入']);

        /* 进度条 */
        Console::startProgress(0, 1000);
        for ($n = 1; $n <= 1000; ++$n) {
            usleep(1000);
            Console::updateProgress($n, 1000);
        }
        Console::endProgress();
    }
}
