<?php
namespace Mithra62\LoginAlert\Tests\Services;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Model\MemberLoginAlerts;

class MemberLoginAlertsTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Model\MemberLoginAlerts'));
    }

    public function testPrimaryKeyPropertyExists()
    {
        $model = ee('Model')
            ->make('login_alert:Settings');
        $this->assertObjectHasAttribute('_primary_key', $model);
        return $model;
    }

    /**
     * @depends testPrimaryKeyPropertyExists
     * @param MemberLoginAlerts $model
     * @return MemberLoginAlerts
     */
    public function testPrimaryKeyPropertyMatches(MemberLoginAlerts $model): MemberLoginAlerts
    {
        $this->assertEquals('id', $model->getPrimaryKey());
        return $model;
    }

    /**
     * @depends testPrimaryKeyPropertyMatches
     * @param MemberLoginAlerts $model
     * @return MemberLoginAlerts
     */
    public function testTableNamePropertyExists(MemberLoginAlerts $model): MemberLoginAlerts
    {
        $this->assertObjectHasAttribute('_table_name', $model);
        return $model;
    }

    /**
     * @depends testTableNamePropertyExists
     * @param MemberLoginAlerts $model
     * @return MemberLoginAlerts
     */
    public function testNamePropertyExists(MemberLoginAlerts $model): MemberLoginAlerts
    {
        $this->assertObjectHasAttribute('name', $model);
        return $model;
    }

    /**
     * @depends testNamePropertyExists
     * @param MemberLoginAlerts $model
     * @return MemberLoginAlerts
     */
    public function testTemplatePropertyExists(MemberLoginAlerts $model): MemberLoginAlerts
    {
        $this->assertObjectHasAttribute('notify_template', $model);
        return $model;
    }

    /**
     * @depends testTemplatePropertyExists
     * @param MemberLoginAlerts $model
     * @return MemberLoginAlerts
     */
    public function testStatusPropertyExists(MemberLoginAlerts $model): MemberLoginAlerts
    {
        $this->assertObjectHasAttribute('status', $model);
        return $model;
    }

    /**
     * @depends testStatusPropertyExists
     * @param MemberLoginAlerts $model
     * @return MemberLoginAlerts
     */
    public function testSubjectPropertyExists(MemberLoginAlerts $model): MemberLoginAlerts
    {
        $this->assertObjectHasAttribute('notify_subject', $model);
        return $model;
    }

    /**
     * @depends testSubjectPropertyExists
     * @param MemberLoginAlerts $model
     * @return MemberLoginAlerts
     */
    public function testNotifyEmailsPropertyExists(MemberLoginAlerts $model): MemberLoginAlerts
    {
        $this->assertObjectHasAttribute('notify_emails', $model);
        return $model;
    }

    /**
     * @depends testNotifyEmailsPropertyExists
     * @param MemberLoginAlerts $model
     * @return MemberLoginAlerts
     */
    public function testCreatedDatePropertyExists(MemberLoginAlerts $model): MemberLoginAlerts
    {
        $this->assertObjectHasAttribute('created_date', $model);
        return $model;
    }

    /**
     * @depends testCreatedDatePropertyExists
     * @param MemberLoginAlerts $model
     * @return MemberLoginAlerts
     */
    public function testLastUpdatedPropertyExists(MemberLoginAlerts $model): MemberLoginAlerts
    {
        $this->assertObjectHasAttribute('last_updated', $model);
        return $model;
    }

    /**
     * @depends testLastUpdatedPropertyExists
     * @param MemberLoginAlerts $model
     * @return MemberLoginAlerts
     */
    public function testSiteIdPropertyExists(MemberLoginAlerts $model): MemberLoginAlerts
    {
        $this->assertObjectHasAttribute('site_id', $model);
        return $model;
    }
}