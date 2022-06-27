<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-02 12:49:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 11:04:32
 */

namespace console\controllers;

use common\helpers\FileHelper;
use console\services\InstallServer;
use PDOException;
use Yii;
use yii\console\widgets\Table;
use yii\db\Exception;
use yii\db\mssql\PDO;
use yii\helpers\Console;

// 使用示例： ./yii addons -addons=diandi_lottery -bloc_id=1 -store_id=3   job ninini

class InstallController extends \yii\console\Controller
{
    public function actionIndex()
    {
        if (file_exists(yii::getAlias('@console/data/install.lock'))) {
            Console::output('系统已安装，需要重新安装请删除文件：'.yii::getAlias('@common/install.lock'));
        }

        // 第一步配置数据库
        // $sqlType = Console::select("数据库类型：",['mysql'=>'mysql','sqlserver'=>'sqlserver']);
        // $sqlTypeVal = Console::ansiFormat($sqlType,[Console::FG_YELLOW]);
        Console::output('感谢使用店滴云CMS，小滴帮您配置mysql');

        $is_connect = false;
        do {
            $host = InstallServer::getConf('host','请输入host');
            // $formatName = Console::ansiFormat($host, [Console::FG_YELLOW]);
            // Console::output("你的host是：{$formatName}");
            $port = InstallServer::getConf('port','请输入数据库端口port');
            $dbname = InstallServer::getConf('dbname','请输入dbname');
            $tablePrefix = InstallServer::getConf('tablePrefix','请输入数据库前缀tablePrefix');
            $dbusername = InstallServer::getConf('dbusername','请输入数据库dbusername');
            $dbpassword = InstallServer::getConf('dbpassword','请输入数据库dbpassword');
            $confTable = Table::widget([
                'headers' => ['host', 'port', 'dbname', 'tablePrefix', 'username', 'password'],
                'rows' => [
                    [$host, $port, $dbname, $tablePrefix, $dbusername, $dbpassword],
                ],
            ]);

            Console::output('你的数据库配置汇总：'.PHP_EOL."{$confTable}");

            $config = InstallServer::local_mysql_config();

            $config = str_replace([
                '{db-host}', '{db-port}', '{db-dbname}', '{db-tablePrefix}', '{db-username}', '{db-password}',
            ], [
                $host, $port, $dbname, $tablePrefix, $dbusername, $dbpassword,
            ], $config);

            $error = '';
            try {
                $link = new PDO("mysql:host={$host};port={$port}", $dbusername, $dbpassword); 	// dns可以没有dbname
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
                Console::input('数据库无法连接，请重新配置');
            }
        } while (!$is_connect);

        // 初始数据库
        $version = InstallServer::getConf('version','请输入数据库脚本版本号');

        $bashPath = dirname(Yii::getAlias('@console'));
        $oldAPP = Yii::$app;
        Yii::$app = new \yii\console\Application([
            'id' => 'install-console',
            'basePath' => $bashPath,
            'components' => [
                'service' => [
                    'class' => 'common\services\BaseService',
                ],
                'cache' => [
                    'class' => 'yii\caching\FileCache',
                    'cachePath' => '@console/runtime/cache',
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
                    'username' => "{$dbusername}",
                    'password' => "{$dbpassword}",
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
        $username = InstallServer::getConf('username','请输入管理员名称(字母不含特殊字符)：');

        $mobile = InstallServer::getConf('mobile','请输入手机号：');
        $email = InstallServer::getConf('email','请输入邮箱：');
        $userpassword = InstallServer::getConf('userpassword','请输入密码');

        $res = InstallServer::adminSignUp($username, $mobile, $email, $userpassword);
        if ($res) {
            InstallServer::getConf('host','管理员注册成功，下一步初始系统文件权限');
        }
        // 设置文件权限

        // nginx配置
        $baseDir = dirname(__FILE__).'/../../';

        $dirs = ['api/runtime/', 'frontend/runtime/', 'frontend/web/assets/', 'frontend/web/attachment', 'console/swoole/runtime/', 'admin/runtime/'];

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
        
        $lockDir = yii::getAlias('@console/data');
        if(!is_dir($lockDir)){
            FileHelper::mkdirs($lockDir);
        }

        touch(yii::getAlias('@console/data/install.lock'));

        $installConfPath = yii::getAlias('@console/config/install.php');
        if(file_exists($installConfPath)){
            FileHelper::file_delete($installConfPath);
        }
        Console::input('系统安装成功，配置你的nginx就可以访问了');
    }
}
