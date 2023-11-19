<?php

use Mithra62\LoginAlert\Services\TemplateService;
use PHPUnit\Framework\TestCase;

class TemplateServiceTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Services\TemplateService'));
    }

    /**
     * @return void
     */
    public function testAbstractServiceInstanceInstance()
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\AbstractService', new TemplateService);
    }

    /**
     * @return TemplateService
     */
    public function testCustomDelimPropertyExists(): TemplateService
    {
        $service = new TemplateService;
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