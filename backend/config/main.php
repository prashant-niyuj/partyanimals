<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name'=>'Party Animals',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
          'blog' => [
            'class' => 'funson86\blog\Module',
            'controllerNamespace' => 'funson86\blog\controllers\backend'
        ],
        
    ],
    'components' => [
        'user' => [
           // 'identityClass' => 'common\models\User',
           // 'enableAutoLogin' => true,
            'identityCookie' => 
             [
                    'name' => '_backendUser', // unique for backend
                    'path'=>'/backend/web'  // correct path for the backend app.
             ]
         
        ],
        'session' => [
    'name' => '_backendSessionId', // unique for backend
   // 'savePath' => __DIR__ . '/../runtime', // a temporary folder on backend
         ],
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
            'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false, //set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.sendgrid.net', //'smtp.gmail.com',
                'username' => 'prashant9792',
                'password' => 'Farkande@7',
                'port' => '587', //'587',
                'encryption' => 'tls',
            ],
        ],
    ],
    'params' => $params,
	'defaultRoute' => "dashboard/user-action",
];
