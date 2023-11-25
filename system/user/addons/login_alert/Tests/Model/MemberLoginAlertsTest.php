<?php
namespace Mithra62\LoginAlert\Tests\Services;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Model\MemberLoginAlert;

class MemberLoginAlertsTest extends TestCase
{
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Model\MemberLoginAlert'));
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
     * @param MemberLoginAlert $model
     * @return MemberLoginAlert
     */
    public function testPrimaryKeyPropertyMatches(MemberLoginAlert $model): MemberLoginAlert
    {
        $this->assertEquals('id', $model->getPrimaryKey());
        return $model;
    }

    /**
     * @depends testPrimaryKeyPropertyMatches
     * @param MemberLoginAlert $model
     * @return MemberLoginAlert
     */
    public function testTableNamePropertyExists(MemberLoginAlert $model): MemberLoginAlert
    {
        $this->assertObjectHasAttribute('_table_name', $model);
        return $model;
    }

    /**
     * @depends testTableNamePropertyExists
     * @param MemberLoginAlert $model
     * @return MemberLoginAlert
     */
    public function testNamePropertyExists(MemberLoginAlert $model): MemberLoginAlert
    {
        $this->assertObjectHasAttribute('name', $model);
        return $model;
    }

    /**
     * @depends testNamePropertyExists
     * @param MemberLoginAlert $model
     * @return MemberLoginAlert
     */
    public function testTemplatePropertyExists(MemberLoginAlert $model): MemberLoginAlert
    {
        $this->assertObjectHasAttribute('notify_template', $model);
        return $model;
    }

    /**
     * @depends testTemplatePropertyExists
     * @param MemberLoginAlert $model
     * @return MemberLoginAlert
     */
    public function testStatusPropertyExists(MemberLoginAlert $model): MemberLoginAlert
    {
        $this->assertObjectHasAttribute('status', $model);
        return $model;
    }

    /**
     * @depends testStatusPropertyExists
     * @param MemberLoginAlert $model
     * @return MemberLoginAlert
     */
    public function testSubjectPropertyExists(MemberLoginAlert $model): MemberLoginAlert
    {
        $this->assertObjectHasAttribute('notify_subject', $model);
        return $model;
    }

    /**
     * @depends testSubjectPropertyExists
     * @param MemberLoginAlert $model
     * @return MemberLoginAlert
     */
    public function testNotifyEmailsPropertyExists(MemberLoginAlert $model): MemberLoginAlert
    {
        $this->assertObjectHasAttribute('notify_emails', $model);
        return $model;
    }

    /**
     * @depends testNotifyEmailsPropertyExists
     * @param MemberLoginAlert $model
     * @return MemberLoginAlert
     */
    public function testCreatedDatePropertyExists(MemberLoginAlert $model): MemberLoginAlert
    {
        $this->assertObjectHasAttribute('created_date', $model);
        return $model;
    }

    /**
     * @depends testCreatedDatePropertyExists
     * @param MemberLoginAlert $model
     * @return MemberLoginAlert
     */
    public function testLastUpdatedPropertyExists(MemberLoginAlert $model): MemberLoginAlert
    {
        $this->assertObjectHasAttribute('last_updated', $model);
        return $model;
    }

    /**
     * @depends testLastUpdatedPropertyExists
     * @param MemberLoginAlert $model
     * @return MemberLoginAlert
     */
    public function testSiteIdPropertyExists(MemberLoginAlert $model): MemberLoginAlert
    {
        $this->assertObjectHasAttribute('site_id', $model);
        return $model;
    }
}