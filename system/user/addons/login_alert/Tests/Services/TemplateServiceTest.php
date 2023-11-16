<?php

use Mithra62\LoginAlert\Services\TemplateService;
use PHPUnit\Framework\TestCase;

class TemplateServiceTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Services\TemplateService'));
    }

    public function testTraitIsAttachedToService(): TemplateService
    {
        $service = new TemplateService(1);
        $this->assertTrue(method_exists($service, 'logger'));
        return $service;
    }
}