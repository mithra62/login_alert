<?php

namespace Mithra62\LoginAlert\Tests;

use PHPUnit\Framework\TestCase;
use ExpressionEngine\Service\Addon\Installer;
use Login_alert_upd;

class UpdTest extends TestCase
{
    public function testUpdFileExists()
    {
        $file_name = realpath(PATH_THIRD.'/login_alert/upd.login_alert.php');
        $this->assertNotNull($file_name);
        require_once $file_name;
    }

    public function testUpdObjectExists(): void
    {
        $this->assertTrue(class_exists('\Login_alert_upd'));
    }

    /**
     * @return Login_alert_upd
     */
    public function testHasCpBackendPropertyExists(): Login_alert_upd
    {
        $cp = new \Login_alert_upd();
        $this->assertObjectHasAttribute('has_cp_backend', $cp);
        return $cp;
    }

    /**
     * @depends testHasCpBackendPropertyExists
     * @param Login_alert_upd $cp
     * @return Login_alert_upd
     */
    public function testCpBackendPropertyValue(Login_alert_upd $cp): Login_alert_upd
    {
        $this->assertEquals('y', $cp->has_cp_backend);
        return $cp;
    }

    /**
     * @depends testCpBackendPropertyValue
     * @return Login_alert_upd
     */
    public function testPublishFieldsPropertyExists(Login_alert_upd $cp): Login_alert_upd
    {
        $this->assertObjectHasAttribute('has_publish_fields', $cp);
        return $cp;
    }

    /**
     * @depends testPublishFieldsPropertyExists
     * @param Login_alert_upd $cp
     * @return Login_alert_upd
     */
    public function testPublishFieldsPropertyValue(Login_alert_upd $cp): Login_alert_upd
    {
        $this->assertEquals('n', $cp->has_publish_fields);
        return $cp;
    }

    /**
     * @depends testPublishFieldsPropertyValue
     * @param Login_alert_upd $cp
     * @return Login_alert_upd
     */
    public function testInstance(Login_alert_upd $cp): Login_alert_upd
    {
        $this->assertInstanceOf('ExpressionEngine\Service\Addon\Installer', new Login_alert_upd);
        return $cp;
    }

    /**
     * @depends testInstance
     * @param Login_alert_upd $cp
     * @return Login_alert_upd
     */
    public function testInstallMethodExists(Login_alert_upd $cp): Login_alert_upd
    {
        $this->assertTrue(method_exists($cp, 'install'));
        return $cp;
    }

    /**
     * @depends testInstallMethodExists
     * @param Login_alert_upd $cp
     * @return Login_alert_upd
     */
    public function testUninstallMethodExists(Login_alert_upd $cp): Login_alert_upd
    {
        $this->assertTrue(method_exists($cp, 'uninstall'));
        return $cp;
    }

    /**
     * @depends testUninstallMethodExists
     * @param Login_alert_upd $cp
     * @return Login_alert_upd
     */
    public function testUpdateMethodExists(Login_alert_upd $cp): Login_alert_upd
    {
        $this->assertTrue(method_exists($cp, 'update'));
        return $cp;
    }
}