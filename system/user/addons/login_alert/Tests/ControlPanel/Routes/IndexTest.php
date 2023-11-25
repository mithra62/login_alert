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

    public function testInstanceOfAbstractTag(): Index
    {
        $this->assertInstanceOf('ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute', $route = new Index);
        return $route;
    }

    /**
     * @depends testInstanceOfAbstractTag
     * @param Index $route
     * @return Index
     */
    public function testProcessMethodReturnInstance(Index $route): Index
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\ControlPanel\Routes\Index', $route->process());
        return $route;
    }
}