<?php
namespace Mithra62\LoginAlert\Tests\Services;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Services\AlertService;

class AlertServiceTest extends TestCase
{
    /**
     * @return AlertService
     */
    public function testSetSiteIdReturnInstance(): AlertService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\AbstractService', $service = new AlertService);
        return $service;
    }
}