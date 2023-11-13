<?php

namespace Mithra62\LoginAlert\Tests;

use PHPUnit\Framework\TestCase;
use \Login_alert;

class ModTest extends TestCase
{
    public function testModuleFileExists()
    {
        $file_name = realpath(PATH_THIRD.'/login_alert/mod.login_alert.php');
        $this->assertNotNull($file_name);
        require_once $file_name;
    }

    public function testModuleObjectExists()
    {
        $this->assertTrue(class_exists('\Login_alert'));
    }

    public function testModInstance()
    {
        $this->assertInstanceOf('ExpressionEngine\Service\Addon\Module', new Login_alert);
    }
}