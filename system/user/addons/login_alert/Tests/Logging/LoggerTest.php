<?php
namespace Mithra62\LoginAlert\Tests\Logging;

use ExpressionEngine\Service\Database\Log;
use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Logging\Logger;

class LoggerTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Logging\Logger'));
    }

    /**
     * @return Logger
     */
    public function testInstanceofLoggerInterface(): Logger
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Logging\LoggerInterface', $logger = new Logger);
        return $logger;
    }
}