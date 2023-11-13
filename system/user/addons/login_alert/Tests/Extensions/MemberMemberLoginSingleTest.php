<?php
namespace Mithra62\LoginAlert\Tests\Extensions;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Extensions\MemberMemberLoginSingle;

class MemberMemberLoginSingleTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Extensions\MemberMemberLoginSingle'));
    }

    public function testInstanceOfAbstractTag()
    {
        $this->assertInstanceOf('ExpressionEngine\Service\Addon\Controllers\Extension\AbstractRoute', new MemberMemberLoginSingle);
    }

    public function testProcessMethodExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Extensions\MemberMemberLoginSingle', 'process'));;
    }
}