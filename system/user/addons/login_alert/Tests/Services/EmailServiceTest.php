<?php
namespace Mithra62\LoginAlert\Tests\Services;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Services\EmailService;

class EmailServiceTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Services\EmailService'));
    }

    public function testTraitIsAttachedToService(): EmailService
    {
        $service = new EmailService(1, [], ee('login_alert:TemplateService'));
        $this->assertTrue(method_exists($service, 'logger'));
        return $service;
    }
}