<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    
    'name'=>'Party Animals',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
           // 'confirmWithin' => 21600,
            'enableConfirmation'=>false,
            "enableGeneratingPassword"=>true,
            'rememberFor'=>1209600,
            'cost' => 12,
            'admins' => ['admin'],
            'controllerMap' => [
               'admin' => 'app\controllers\user\AdminController',
              //  'settings' => 'backend\controllers\user\SettingsController',
                //'user' => 'backend\controllers\user\Controller',
                'profile' => 'backend\controllers\user\ProfileController',
                'registration' => 'backend\controllers\user\RegistrationController',
                'security' => 'backend\controllers\user\SecurityController',
               // 'recovery' => 'backend\controllers\user\RecoveryController'
            ],
            'modelMap' => [
              'User' => 'backend\models\User',
              'Profile' => 'backend\models\Profile',
              'UserSearch' => 'backend\models\UserSearch',               
              'RegistrationForm' => 'app\models\RegistrationForm',
            ],
        // you will configure your module inside this file
        // or if need different configuration for frontend and backend you may
        // configure in needed configs
        //'as frontend' => 'dektrium\user\filters\FrontendFilter',
        //'as backend' => 'dektrium\user\filters\BackendFilter',
        ],
    ],
    'components' => [
        
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false, //set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',//'172.24.16.71', //'smtp.gmail.com',
                'username' => 'babar.yogesh@gmail.com', //'mitali.mokashi@niyuj.com',
                'password' => 'Winforplay', //'mit4118936',
                'port' => '587', //'587',
                'encryption' => 'tls',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
    ],
];