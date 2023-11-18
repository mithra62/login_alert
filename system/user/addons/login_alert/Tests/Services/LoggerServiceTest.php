<?php
namespace Mithra62\LoginAlert\Tests\Services;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Services\LoggerService;

class LoggerServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Services\LoggerService'));
    }

    /**
     * @return LoggerService
     */
    public function testLoggerPropertyExists(): LoggerService
    {
        $service = new LoggerService();
        $this->assertObjectHasAttribute('logger', $service);
        return $service;
    }

    /**
     * @depends testLoggerPropertyExists
     * @param LoggerService $service
     * @return LoggerService
     * @throws \Exception
     */
    public function testGetLoggerReturnInstance(LoggerService $service): LoggerService
    {
        $this->assertInstanceOf('ExpressionEngine\Service\Logger\File', $service->getLogger());
        return $service;
    }

    /**
     * @depends testGetLoggerReturnInstance
     * @param LoggerService $service
     * @return LoggerService
     */
    public function testFormatMethodOutput(LoggerService $service): LoggerService
    {
        $arr = ['foo' => 'bar', 'fiz' => 'buzz'];
        $test_str = '(debug)';
        $json = json_encode($arr);
        $this->assertTrue(strpos($service->format('debug','test'), $test_str) !== false );
        $this->assertTrue(strpos($service->format('debug','test'), 'Message: ') !== false );
        $this->assertTrue(strpos($service->format('debug','test', $arr), $json) !== false );
        return $service;
    }

    /**
     * @depends testFormatMethodOutput
     * @param LoggerService $service
     * @return LoggerService
     */
    public function testShouldLogReturnsFalseOnNoConfigSet(LoggerService $service): LoggerService
    {
        ee()->config->config['login_alert_log_levels'] = [];
        $this->assertFalse($service->shouldLog('debug'));
        return $service;
    }

    /**
     * @depends testShouldLogReturnsFalseOnNoConfigSet
     * @param LoggerService $service
     * @return LoggerService
     */
    public function testShouldLogReturnsTrueOnDebugConfigSet(LoggerService $service): LoggerService
    {
        ee()->config->config['login_alert_log_levels'] = ['debug'];
        $this->assertTrue($service->shouldLog('debug'));
        return $service;
    }

    /**
     * @depends testShouldLogReturnsTrueOnDebugConfigSet
     * @param LoggerService $service
     * @return LoggerService
     */
    public function testShouldLogReturnsTrueOnNoConfigSetDefaults(LoggerService $service): LoggerService
    {
        ee()->config->config['login_alert_log_levels'] = [];
        $this->assertTrue($service->shouldLog('error'));
        $this->assertTrue($service->shouldLog('notice'));
        $this->assertTrue($service->shouldLog('warning'));
        $this->assertTrue($service->shouldLog('emergency'));
        $this->assertTrue($service->shouldLog('alert'));
        $this->assertTrue($service->shouldLog('alert'));
        $this->assertTrue($service->shouldLog('critical'));
        return $service;
    }
}