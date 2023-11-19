<?php
namespace Mithra62\LoginAlert\Tests\Services;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Services\AbstractService;

class __abstract_service_stub extends AbstractService
{

}

class AbstractServiceTest extends TestCase
{
    /**
     * @return AbstractService
     */
    public function testLogTraitIsAttachedToService(): AbstractService
    {
        $service = new __abstract_service_stub();
        $this->assertTrue(method_exists($service, 'logger'));
        return $service;
    }

    /**
     * @depends testLogTraitIsAttachedToService
     * @param AbstractService $service
     * @return AbstractService
     */
    public function testSiteIdPropertyExists(AbstractService $service): AbstractService
    {
        $this->assertObjectHasAttribute('site_id', $service);
        return $service;
    }

    /**
     * @depends testSiteIdPropertyExists
     * @param AbstractService $service
     * @return AbstractService
     */
    public function testSiteIdDefaultValue(AbstractService $service): AbstractService
    {
        $this->assertEquals(1, $service->getSiteId());
        return $service;
    }

    /**
     * @depends testSiteIdDefaultValue
     * @param AbstractService $service
     * @return AbstractService
     */
    public function testSetSiteIdReturnInstance(AbstractService $service): AbstractService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\AbstractService', $service->setSiteId(12));
        return $service;
    }

    /**
     * @depends testSetSiteIdReturnInstance
     * @param AbstractService $service
     * @return AbstractService
     */
    public function testGetSiteIdHasProperValue(AbstractService $service): AbstractService
    {
        $this->assertEquals(12, $service->getSiteId());
        return $service;
    }
}