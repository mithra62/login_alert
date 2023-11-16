<?php

use Mithra62\LoginAlert\Services\LoggerService;
use Mithra62\LoginAlert\Services\TemplateService;
use Mithra62\LoginAlert\Services\EmailService;

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
        'Settings' => 'Model\MemberLoginAlerts',
    ],
    'services' => [
        'LoggerService' => function ($addon) {
            return new LoggerService(ee()->config->item('site_id'));
        },
        'TemplateService' => function ($addon) {
            return new TemplateService(ee()->config->item('site_id'));
        },
    ],
    'services.singletons' => [
        'EmailService' => function ($addon) {
            $config = ee()->config->config['login_alert'] ?? [];
            return new EmailService(ee()->config->item('site_id'), $config, ee('login_alert:TemplateService'));
        }
    ]
];
