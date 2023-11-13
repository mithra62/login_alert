<?php
namespace Mithra62\LoginAlert\Tests\ControlPanel\Routes;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\ControlPanel\Routes\Index;

class IndexTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\ControlPanel\Routes\Index'));
    }

    public function testInstanceOfAbstractTag()
    {
        $this->assertInstanceOf('ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute', new Index);
    }

    public function testProcessMethodExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\ControlPanel\Routes\Index', 'process'));;
    }
}