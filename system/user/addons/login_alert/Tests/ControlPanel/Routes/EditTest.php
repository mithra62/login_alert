<?php
namespace Mithra62\LoginAlert\Tests\ControlPanel\Routes;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\ControlPanel\Routes\Edit;

class EditTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\ControlPanel\Routes\Edit'));
    }

    public function testInstanceOfAbstractTag(): Edit
    {
        $this->assertInstanceOf('ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute', $route = new Edit);
        return $route;
    }

    /**
     * @depends testInstanceOfAbstractTag
     * @param Edit $route
     * @return Edit
     */
    public function testProcessMethodReturnInstance(Edit $route): Edit
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\ControlPanel\Routes\Edit', $route->process(1));
        return $route;
    }
}