<?php
namespace Mithra62\LoginAlert\Tests;

use PHPUnit\Framework\TestCase;
use Login_alert_ext;

class ExtTest extends TestCase
{
    public function testMcpFileExists()
    {
        $file_name = realpath(PATH_THIRD.'/login_alert/ext.login_alert.php');
        $this->assertNotNull($file_name);
        require_once $file_name;
    }

    public function testMcpObjectExists()
    {
        $this->assertTrue(class_exists('\Login_alert_ext'));
    }

    public function testSetSiteIdReturnInstance()
    {
        $this->assertInstanceOf('ExpressionEngine\Service\Addon\Extension', $service = new Login_alert_ext);
        return $service;
    }

    /**
     * @depends testSetSiteIdReturnInstance
     * @return Login_alert_ext
     */
    public function testHasCpBackendPropertyExists(Login_alert_ext $service): Login_alert_ext
    {
        $this->assertObjectHasAttribute('addon_name', $service);
        return $service;
    }
}