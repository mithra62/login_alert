<?php

use Mithra62\LoginAlert\Services\LoggerService;
use Mithra62\LoginAlert\Services\TemplateService;
use Mithra62\LoginAlert\Services\EmailService;
use Mithra62\LoginAlert\Services\AlertService;

if (!defined('LOGIN_ALERT_VERSION')) {
    define('LOGIN_ALERT_VERSION', '1.0.0');
}

return [
    'name'              => 'Login Alert',
    'description'       => 'Will send email upon login based on configuration',
    'version'           => LOGIN_ALERT_VERSION,
    'author'            => 'mithra62',
    'author_url'        => '',
    'namespace'         => 'Mithra62\LoginAlert',
    'settings_exist'    => true,
    'models' => [
        'Settings' => 'Model\MemberLoginAlert',
    ],
    'services' => [
        'LoggerService' => function ($addon) {
            return new LoggerService();
        },
        'TemplateService' => function ($addon) {
            return new TemplateService(ee()->config->item('site_id'));
        },
        'AlertService' => function ($addon) {
            return new AlertService(ee()->config->item('site_id'));
        },
    ],
    'services.singletons' => [
        'EmailService' => function ($addon) {
            return new EmailService(ee()->config->item('site_id'), [], ee('login_alert:TemplateService'));
        }
    ]
];
