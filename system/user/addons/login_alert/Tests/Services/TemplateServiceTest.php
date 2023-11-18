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

    /**
     * @depends testTraitIsAttachedToService
     * @param TemplateService $service
     * @return TemplateService
     */
    public function testSiteIdPropertyExists(TemplateService $service): TemplateService
    {
        $this->assertObjectHasAttribute('site_id', $service);
        return $service;
    }

    /**
     * @depends testSiteIdPropertyExists
     * @param TemplateService $service
     * @return TemplateService
     */
    public function testSiteIdDefaultValue(TemplateService $service): TemplateService
    {
        $this->assertEquals(1, $service->getSiteId());
        return $service;
    }

    /**
     * @depends testSiteIdDefaultValue
     * @param TemplateService $service
     * @return TemplateService
     */
    public function testSetSiteIdReturnInstance(TemplateService $service): TemplateService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\TemplateService', $service->setSiteId(12));
        return $service;
    }

    /**
     * @depends testSetSiteIdReturnInstance
     * @param TemplateService $service
     * @return TemplateService
     */
    public function testGetSiteIdHasProperValue(TemplateService $service): TemplateService
    {
        $this->assertEquals(12, $service->getSiteId());
        return $service;
    }

    /**
     * @depends testSiteIdPropertyExists
     * @param TemplateService $service
     * @return TemplateService
     */
    public function testCustomDelimPropertyExists(TemplateService $service): TemplateService
    {
        $this->assertObjectHasAttribute('custom_delim', $service);
        return $service;
    }

    /**
     * @depends testCustomDelimPropertyExists
     * @param TemplateService $service
     * @return TemplateService
     */
    public function testCustomDelimDefaultValue(TemplateService $service): TemplateService
    {
        $this->assertEquals('%', $service->getCustomDelim());
        return $service;
    }

    /**
     * @depends testCustomDelimDefaultValue
     * @param TemplateService $service
     * @return TemplateService
     */
    public function testSetCustomDelimReturnInstance(TemplateService $service): TemplateService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\TemplateService', $service->setCustomDelim('%%'));
        return $service;
    }

    /**
     * @depends testSetCustomDelimReturnInstance
     * @param TemplateService $service
     * @return TemplateService
     */
    public function testGetCustomDelimHasProperValue(TemplateService $service): TemplateService
    {
        $this->assertEquals('%%', $service->getCustomDelim());
        return $service;
    }

    /**
     * @depends testGetCustomDelimHasProperValue
     * @param TemplateService $service
     * @return TemplateService
     */
    public function testParseStrParsesCustomVariables(TemplateService $service): TemplateService
    {
        $str = 'Here is my test string with %%foo%% and %%fiz%%';
        $expected = 'Here is my test string with bar and buzz';
        $string = $service->parseStr($str, [], ['foo' => 'bar', 'fiz' => 'buzz']);
        $this->assertEquals($expected, $string);
        return $service;
    }

    /**
     * @depends testGetCustomDelimHasProperValue
     * @param TemplateService $service
     * @return TemplateService
     */
    public function testParseStrParsesTplVariables(TemplateService $service): TemplateService
    {
        $str = 'Here is my test string with {foo} and {fiz}';
        $expected = 'Here is my test string with bar and buzz';
        $string = $service->parseStr($str, ['foo' => 'bar', 'fiz' => 'buzz'], []);
        $this->assertEquals($expected, $string);
        return $service;
    }
}