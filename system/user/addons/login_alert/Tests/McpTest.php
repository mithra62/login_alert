<?php

namespace Mithra62\LoginAlert\Tests;

use PHPUnit\Framework\TestCase;

class McpTest extends TestCase
{
    public function testMcpFileExists()
    {
        $file_name = realpath(PATH_THIRD.'/login_alert/mcp.login_alert.php');
        $this->assertNotNull($file_name);
        require_once $file_name;
    }

    public function testMcpObjectExists()
    {
        $this->assertTrue(class_exists('\Login_alert_mcp'));
    }
}