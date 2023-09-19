<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-03-07 11:15:09
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-07 11:26:18
 */
 

namespace common\services\common;

use Yii;
use yii\base\InvalidConfigException;
use common\queues\MailerJob;
use common\services\BaseService;

class EmailService extends BaseService
{
    /**
     * 消息队列
     *
     * @var bool
     */
    public $queueSwitch = false;

    /**
     * @var array
     */
    protected $config = [];

    

    /**
     * 发送邮件
     *
     * ```php
     *        Yii::$App->service->commonEmailService->send($user, $email, $subject, $template)
     * ```
     * @param object $user 用户信息
     * @param string $email 邮箱
     * @param string $subject 标题
     * @param string $template 对应邮件模板
     * @throws \yii\base\InvalidConfigException
     */
    public function send($user, $email, $subject, $template,$options=[])
    {   
     
        $this->setConfig();
     
        if ($this->queueSwitch == true) {
            $messageId = Yii::$app->queue->push(new MailerJob([
                'user' => $user,
                'email' => $email,
                'subject' => $subject,
                'template' => $template,
            ]));

            return $messageId;
        }
        return $this->realSend($user, $email, $subject, $template,$options);
    }

    /**
     * 发送
     *
     * @param $user
     * @param $email
     * @param $subject
     * @param $template
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function realSend($user, $email, $subject, $template,$options)
    {   
        $Email = $this->config;
        $params = array_merge(['user' => $user],$options);
        try {
            $result=Yii::$app
                ->mailer
                ->compose(
                    $template,
                    $params
                )
                ->setFrom([$Email['username'] => $Email['title']])
                ->setTo($email)
                ->setSubject($subject)
                ->send();

            Yii::info($result);
            return $result;
        } catch (InvalidConfigException $e) {
            Yii::error($e->getMessage());
        }

        return false;
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    protected function setConfig()
    {
        $Email = Yii::$app->settings->getAllBySection('Email');
        $this->config = $Email;  
        $config['components']['mailer'] = [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' =>trim($Email['host']),
                'port' => trim($Email['port']),
                'encryption' => trim($Email['encryption']),
                'username' => trim($Email['username']),
                'password' => trim($Email['password']),
            ]
        ];
        Yii::configure(\Yii::$app, $config);
    }
}