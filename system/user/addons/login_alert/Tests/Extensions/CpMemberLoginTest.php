<?php
namespace Mithra62\LoginAlert\Tests\Extensions;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Extensions\CpMemberLogin;

class CpMemberLoginTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Extensions\CpMemberLogin'));
    }

    public function testInstanceOfAbstractTag()
    {
        $this->assertInstanceOf('ExpressionEngine\Service\Addon\Controllers\Extension\AbstractRoute', new CpMemberLogin);
    }

    public function testProcessMethodExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Extensions\CpMemberLogin', 'process'));;
    }
}