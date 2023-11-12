<?php

use Mithra\LoginAlert\Services\LoggerService;
use Mithra\LoginAlert\Services\TemplateService;
use Mithra\LoginAlert\Services\EmailService;

return [
    'name'              => 'login_alert',
    'description'       => 'login_alert description',
    'version'           => '1.0.0',
    'author'            => 'mithra62',
    'author_url'        => 'fdsa',
    'namespace'         => 'Mithra\LoginAlert',
    'settings_exist'    => true,
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
