<?php
namespace Mithra62\LoginAlert\Tests\ControlPanel\Routes;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\ControlPanel\Routes\Create;

class CreateTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\ControlPanel\Routes\Create'));
    }

    public function testInstanceOfAbstractTag(): Create
    {
        $this->assertInstanceOf('ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute', $route = new Create);
        return $route;
    }

    /**
     * @depends testInstanceOfAbstractTag
     * @param Create $route
     * @return Create
     */
    public function testProcessMethodReturnInstance(Create $route): Create
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\ControlPanel\Routes\Create', $route->process());
        return $route;
    }
}