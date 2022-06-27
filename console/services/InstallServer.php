<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-30 22:09:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 11:23:00
 */

namespace console\services;

use admin\models\DdApiAccessToken;
use admin\models\User;
use common\services\admin\AccessTokenService;
use common\services\BaseService;
use console\models\AuthAssignmentGroup;
use console\models\AuthUserGroup;
use Yii;
use yii\helpers\Console;

class InstallServer extends BaseService
{
    public static function local_mysql_config()
    {
        $cfg = <<<EOF
<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-18 16:51:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-28 10:21:41
 */

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host={db-host};dbname={db-dbname};port={db-port}',
    'tablePrefix' => '{db-tablePrefix}',
    'username' => '{db-username}',
    'password' => '{db-password}',
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
];
EOF;

        return trim($cfg);
    }

    public static function local_sqlserver_config()
    {
        $cfg = <<<EOF
<?php
defined('IN_IA') or exit('Access Denied');

\$config = array();

\$config['db']['master']['host'] = '{db-server}';
\$config['db']['master']['username'] = '{db-username}';
\$config['db']['master']['password'] = '{db-password}';
\$config['db']['master']['port'] = '{db-port}';
\$config['db']['master']['database'] = '{db-name}';
\$config['db']['master']['charset'] = 'utf8';
\$config['db']['master']['pconnect'] = 0;
\$config['db']['master']['tablepre'] = '{db-tablepre}';

\$config['db']['slave_status'] = false;
\$config['db']['slave']['1']['host'] = '';
\$config['db']['slave']['1']['username'] = '';
\$config['db']['slave']['1']['password'] = '';
\$config['db']['slave']['1']['port'] = '3307';
\$config['db']['slave']['1']['database'] = '';
\$config['db']['slave']['1']['charset'] = 'utf8';
\$config['db']['slave']['1']['pconnect'] = 0;
\$config['db']['slave']['1']['tablepre'] = 'ims_';
\$config['db']['slave']['1']['weight'] = 0;

\$config['db']['common']['slave_except_table'] = array('core_sessions');

// --------------------------  CONFIG COOKIE  --------------------------- //
\$config['cookie']['pre'] = '{cookiepre}';
\$config['cookie']['domain'] = '';
\$config['cookie']['path'] = '/';

// --------------------------  CONFIG SETTING  --------------------------- //
\$config['setting']['charset'] = 'utf-8';
\$config['setting']['cache'] = 'mysql';
\$config['setting']['timezone'] = 'Asia/Shanghai';
\$config['setting']['memory_limit'] = '256M';
\$config['setting']['filemode'] = 0644;
\$config['setting']['authkey'] = '{authkey}';
\$config['setting']['founder'] = '1';
\$config['setting']['development'] = 0;
\$config['setting']['referrer'] = 0;
\$config['setting']['https'] = 0;

// --------------------------  CONFIG UPLOAD  --------------------------- //
\$config['upload']['image']['extentions'] = array('gif', 'jpg', 'pem', 'jpeg', 'png');
\$config['upload']['image']['limit'] = 5000;
\$config['upload']['attachdir'] = '{attachdir}';
\$config['upload']['audio']['extentions'] = array('mp3');
\$config['upload']['audio']['limit'] = 5000;

// --------------------------  CONFIG MEMCACHE  --------------------------- //
\$config['setting']['memcache']['server'] = '';
\$config['setting']['memcache']['port'] = 11211;
\$config['setting']['memcache']['pconnect'] = 1;
\$config['setting']['memcache']['timeout'] = 30;
\$config['setting']['memcache']['session'] = 1;

// --------------------------  CONFIG PROXY  --------------------------- //
\$config['setting']['proxy']['host'] = '';
\$config['setting']['proxy']['auth'] = '';

// --------------------------  CONFIG REDIS  --------------------------- //
\$config['setting']['redis']['server'] = '';
\$config['setting']['redis']['port'] = 6379;
\$config['setting']['redis']['pconnect'] = 0; 
\$config['setting']['redis']['requirepass'] = ''; 
\$config['setting']['redis']['timeout'] = 1;

EOF;

        return trim($cfg);
    }

    public static function local_redis_config()
    {
        $cfg = <<<EOF
<?php
defined('IN_IA') or exit('Access Denied');

\$config = array();

\$config['db']['master']['host'] = '{db-server}';
\$config['db']['master']['username'] = '{db-username}';
\$config['db']['master']['password'] = '{db-password}';
\$config['db']['master']['port'] = '{db-port}';
\$config['db']['master']['database'] = '{db-name}';
\$config['db']['master']['charset'] = 'utf8';
\$config['db']['master']['pconnect'] = 0;
\$config['db']['master']['tablepre'] = '{db-tablepre}';

\$config['db']['slave_status'] = false;
\$config['db']['slave']['1']['host'] = '';
\$config['db']['slave']['1']['username'] = '';
\$config['db']['slave']['1']['password'] = '';
\$config['db']['slave']['1']['port'] = '3307';
\$config['db']['slave']['1']['database'] = '';
\$config['db']['slave']['1']['charset'] = 'utf8';
\$config['db']['slave']['1']['pconnect'] = 0;
\$config['db']['slave']['1']['tablepre'] = 'ims_';
\$config['db']['slave']['1']['weight'] = 0;

\$config['db']['common']['slave_except_table'] = array('core_sessions');

// --------------------------  CONFIG COOKIE  --------------------------- //
\$config['cookie']['pre'] = '{cookiepre}';
\$config['cookie']['domain'] = '';
\$config['cookie']['path'] = '/';

// --------------------------  CONFIG SETTING  --------------------------- //
\$config['setting']['charset'] = 'utf-8';
\$config['setting']['cache'] = 'mysql';
\$config['setting']['timezone'] = 'Asia/Shanghai';
\$config['setting']['memory_limit'] = '256M';
\$config['setting']['filemode'] = 0644;
\$config['setting']['authkey'] = '{authkey}';
\$config['setting']['founder'] = '1';
\$config['setting']['development'] = 0;
\$config['setting']['referrer'] = 0;
\$config['setting']['https'] = 0;

// --------------------------  CONFIG UPLOAD  --------------------------- //
\$config['upload']['image']['extentions'] = array('gif', 'jpg', 'pem', 'jpeg', 'png');
\$config['upload']['image']['limit'] = 5000;
\$config['upload']['attachdir'] = '{attachdir}';
\$config['upload']['audio']['extentions'] = array('mp3');
\$config['upload']['audio']['limit'] = 5000;

// --------------------------  CONFIG MEMCACHE  --------------------------- //
\$config['setting']['memcache']['server'] = '';
\$config['setting']['memcache']['port'] = 11211;
\$config['setting']['memcache']['pconnect'] = 1;
\$config['setting']['memcache']['timeout'] = 30;
\$config['setting']['memcache']['session'] = 1;

// --------------------------  CONFIG PROXY  --------------------------- //
\$config['setting']['proxy']['host'] = '';
\$config['setting']['proxy']['auth'] = '';

// --------------------------  CONFIG REDIS  --------------------------- //
\$config['setting']['redis']['server'] = '';
\$config['setting']['redis']['port'] = 6379;
\$config['setting']['redis']['pconnect'] = 0; 
\$config['setting']['redis']['requirepass'] = ''; 
\$config['setting']['redis']['timeout'] = 1;

EOF;

        return trim($cfg);
    }

    public static function adminSignUp($username, $mobile, $email, $password)
    {
        $UserObj = new User();
        /* 查看用户名是否重复 */
        $userinfo = User::find()->where(['username' => $username])->select('id')->one();
        if (!empty($userinfo)) {
            Console::input('数据库初始成功，下一步注册管理员');
        }
        /* 查看手机号是否重复 */
        if ($mobile) {
            $userinfo = $UserObj->find()->where(['mobile' => $mobile])
                  ->andWhere(['<>', 'mobile', 0])->select('id')->one();
            if (!empty($userinfo)) {
                Console::input('手机号已被占用');
            }
        }
        /* 查看邮箱是否重复 */
        if ($email) {
            $userinfo = $UserObj->find()->where(['email' => $email])
                  ->andWhere(['<>', 'email', 0])->select('id')->one();
            if (!empty($userinfo)) {
                Console::input('邮箱已被占用');
            }
        }

        $UserObj->username = $username;
        $UserObj->email = $email;
        $UserObj->mobile = $mobile;
        $UserObj->status = 1; //命令行注册默认审核通过直接使用
        $UserObj->setPassword($password);
        $UserObj->generateAuthKey();
        $UserObj->generateEmailVerificationToken();
        $UserObj->generatePasswordResetToken();
        $UserObj->save();

        $AccessTokenService = new AccessTokenService();
        $AccessTokenService->getAccessToken($UserObj, 1);
        $group_id = 1;
        $model = self::findModel($UserObj->id, $group_id);

        $model->refresh_token = Yii::$app->security->generateRandomString().'_'.time();
        $model->access_token = Yii::$app->security->generateRandomString().'_'.time();
        $model->status = 1;
        $model->save();
        $user_id = $UserObj->id;
        // 查找权限
        $groups = AuthUserGroup::find()->where(['name' => '总管理员'])->asArray()->one();

        $data = [
            'group_id' => $groups['id'],
            'item_id' => $groups['item_id'],
            'item_name' => $groups['name'],
            'user_id' => $user_id,
        ];
        $AuthAssignmentGroup = new AuthAssignmentGroup();

        return  $AuthAssignmentGroup->load($data, '') && $AuthAssignmentGroup->save();
    }

    /**
     * 返回模型.
     *
     * @return array|AccessToken|ActiveRecord|null
     */
    public static function findModel($user_id, $group_id)
    {
        if (empty(($model = DdApiAccessToken::find()->where([
            'user_id' => $user_id,
            'group_id' => $group_id,
        ])->one()))) {
            $model = new DdApiAccessToken();

            return $model->loadDefaultValues();
        }

        return $model;
    }

    public static function getConf($key,$message)
    {
        $installConfPath = yii::getAlias('@console/config/install.php');
        
        if(file_exists($installConfPath)){
            $installConf = require $installConfPath;
        }

        if(!empty($installConf[$key])){
            return $installConf[$key];
        }

        return Console::input($message.':');
    }
}
