<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],*/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authClientCollection' => [
        'class'   => \yii\authclient\Collection::className(),
        'clients' => [
            'facebook' => [
                'class'        => 'dektrium\user\clients\Facebook',
                'clientId'     => '1003374699749278',
                'clientSecret' => '5d8ad2422f0a7763369c3210c142be6c',
            ],
            'twitter' => [
            'class'          => 'dektrium\user\clients\Twitter',
            'consumerKey'    => 'vZRXoYUKttBYK3cabHFYCmTWM',
            'consumerSecret' => 'bxxUy1PPm6gC9ofFmgfvfvZEFCnO5jMEfha3twGwJIfixNa5kr',
            ],
           
        ],
    ],
      'mailer' => [
    'class' => 'yii\swiftmailer\Mailer',
    'viewPath' => '@common/mail',
    'useFileTransport' => false, //set this property to false to send mails to real email addresses
    //comment the following array to send mail using php's mail function
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.zoho.com', //'smtp.gmail.com',
        'username' => 'support@partyanimals.in', //'mitali.mokashi@niyuj.com',
        'password' => 'support123', //'mit4118936',
        'port' => '587',
        'encryption' => 'tls',
    ],
    ],
    ],
    'params' => $params,
];
