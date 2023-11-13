<?php
namespace Mithra62\LoginAlert\Tests\Logging;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Logging\LogLevel;

class LogLevelTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Logging\LogLevel'));
    }

    public function testEmergencyConstValue(): LogLevel
    {
        $level = new LogLevel;
        $this->assertEquals('emergency', $level::EMERGENCY);
        return $level;
    }

    /**
     * @depends testEmergencyConstValue
     * @param LogLevel $level
     * @return LogLevel
     */
    public function testAlertConstValue(LogLevel $level): LogLevel
    {
        $this->assertEquals('alert', $level::ALERT);
        return $level;
    }

    /**
     * @depends testAlertConstValue
     * @param LogLevel $level
     * @return LogLevel
     */
    public function testCriticalConstValue(LogLevel $level): LogLevel
    {
        $this->assertEquals('critical', $level::CRITICAL);
        return $level;
    }

    /**
     * @depends testCriticalConstValue
     * @param LogLevel $level
     * @return LogLevel
     */
    public function testErrorConstValue(LogLevel $level): LogLevel
    {
        $this->assertEquals('error', $level::ERROR);
        return $level;
    }

    /**
     * @depends testErrorConstValue
     * @param LogLevel $level
     * @return LogLevel
     */
    public function testWarningConstValue(LogLevel $level): LogLevel
    {
        $this->assertEquals('warning', $level::WARNING);
        return $level;
    }

    /**
     * @depends testWarningConstValue
     * @param LogLevel $level
     * @return LogLevel
     */
    public function testNoticeConstValue(LogLevel $level): LogLevel
    {
        $this->assertEquals('notice', $level::NOTICE);
        return $level;
    }

    /**
     * @depends testNoticeConstValue
     * @param LogLevel $level
     * @return LogLevel
     */
    public function testInfoConstValue(LogLevel $level): LogLevel
    {
        $this->assertEquals('info', $level::INFO);
        return $level;
    }

    /**
     * @depends testInfoConstValue
     * @param LogLevel $level
     * @return LogLevel
     */
    public function testDebugConstValue(LogLevel $level): LogLevel
    {
        $this->assertEquals('debug', $level::DEBUG);
        return $level;
    }
}