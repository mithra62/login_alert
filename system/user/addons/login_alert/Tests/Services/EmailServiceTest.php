<?php
namespace Mithra62\LoginAlert\Tests\Services;

use PHPUnit\Framework\TestCase;
use Mithra62\LoginAlert\Services\EmailService;

class _email_service_test_sub extends EmailService
{
    public function _test_validate()
    {
        return $this->validate();
    }
}

class EmailServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Mithra62\LoginAlert\Services\EmailService'));
    }

    /**
     * @depends testClassExists
     * @return void
     */
    public function testValidateThrowsExceptionOnBadDefaults()
    {
        $class = new _email_service_test_sub();
        $this->expectException('Mithra62\LoginAlert\Exceptions\Services\EmailServiceException');
        $class->_test_validate();
    }

    /**
     * @depends testValidateThrowsExceptionOnBadDefaults
     * @return void
     */
    public function testValidateDoesntThrowOnGoodConfig()
    {
        $this->expectNotToPerformAssertions();
        $config = [
            'to' => 'test@test.com',
            'reply_to_email' => 'test@test.com',
            'reply_to_name' => 'Reply To Name',
            'subject' => 'My Email Subject',
            'from_name' => 'From Name',
            'from_email' => 'from@email.com',
            'template' => 'my/template',
            'template_vars' => []
        ];

        $class = new _email_service_test_sub(null, $config);
        $class->_test_validate();
    }

    /**
     * @depends testValidateDoesntThrowOnGoodConfig
     * @return EmailService
     */
    public function testLogTraitIsAttachedToService(): EmailService
    {
        $service = new EmailService();
        $this->assertTrue(method_exists($service, 'logger'));
        return $service;
    }

    /**
     * @depends testLogTraitIsAttachedToService
     * @param EmailService $service
     * @return EmailService
     */
    public function testSiteIdPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('site_id', $service);
        return $service;
    }

    /**
     * @depends testSiteIdPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testSiteIdDefaultValue(EmailService $service): EmailService
    {
        $this->assertEquals(1, $service->getSiteId());
        return $service;
    }

    /**
     * @depends testSiteIdDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetSiteIdReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setSiteId(12));
        return $service;
    }

    /**
     * @depends testSetSiteIdReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetSiteIdHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals(12, $service->getSiteId());
        return $service;
    }

    /**
     * @depends testGetSiteIdHasProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testConfigPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('config', $service);
        return $service;
    }

    /**
     * @depends testConfigPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testConfigDefaultValue(EmailService $service): EmailService
    {
        $this->assertEquals([], $service->getConfig());
        return $service;
    }

    /**
     * @depends testConfigDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetConfigReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setConfig(['test' => 'value']));
        return $service;
    }

    /**
     * @depends testSetConfigReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetConfigHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals(['test' => 'value'], $service->getConfig());
        return $service;
    }

    /**
     * @depends testGetConfigHasProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testToPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('to', $service);
        return $service;
    }

    /**
     * @depends testToPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testToDefaultValue(EmailService $service): EmailService
    {
        $this->assertNull($service->getTo());
        return $service;
    }

    /**
     * @depends testToDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetToReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setTo('test@test.com'));
        return $service;
    }

    /**
     * @depends testSetToReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetToHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals('test@test.com', $service->getTo());
        return $service;
    }

    /**
     * @depends testGetToHasProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testCcPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('cc', $service);
        return $service;
    }

    /**
     * @depends testCcPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testCcDefaultValue(EmailService $service): EmailService
    {
        $this->assertEquals([], $service->getCc());
        return $service;
    }

    /**
     * @depends testCcDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetCcReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setCc(['test@test.com']));
        return $service;
    }

    /**
     * @depends testSetCcReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetCcHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals(['test@test.com'], $service->getCc());
        return $service;
    }

    /**
     * @depends testGetCcHasProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testAddCcReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->addCc('foo@bar.com'));
        return $service;
    }

    /**
     * @depends testAddCcReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testAddCcProperValue(EmailService $service): EmailService
    {
        $this->assertEquals(['test@test.com', 'foo@bar.com'], $service->getCc());
        return $service;
    }

    /**
     * @depends testAddCcProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testBccPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('bcc', $service);
        return $service;
    }

    /**
     * @depends testBccPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testBccDefaultValue(EmailService $service): EmailService
    {
        $this->assertEquals([], $service->getBcc());
        return $service;
    }

    /**
     * @depends testBccDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetBccReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setBcc(['testbcc@test.com']));
        return $service;
    }

    /**
     * @depends testSetBccReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetBccHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals(['testbcc@test.com'], $service->getBcc());
        return $service;
    }

    /**
     * @depends testGetCcHasProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testAddBccReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->addBcc('foo@bar.com'));
        return $service;
    }

    /**
     * @depends testAddCcReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testAddBccProperValue(EmailService $service): EmailService
    {
        $this->assertEquals(['testbcc@test.com', 'foo@bar.com'], $service->getBcc());
        return $service;
    }

    /**
     * @depends testAddBccProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testTemplatePropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('template', $service);
        return $service;
    }

    /**
     * @depends testTemplatePropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testTemplateDefaultValue(EmailService $service): EmailService
    {
        $this->assertNull($service->getTemplate());
        return $service;
    }

    /**
     * @depends testTemplateDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetTemplateReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setTemplate('my/template'));
        return $service;
    }

    /**
     * @depends testSetTemplateReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetTemplateHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals('my/template', $service->getTemplate());
        return $service;
    }

    /**
     * @depends testGetTemplateHasProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testTemplateVarsPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('template_vars', $service);
        return $service;
    }

    /**
     * @depends testTemplateVarsPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testTemplateVarsDefaultValue(EmailService $service): EmailService
    {
        $this->assertEquals([], $service->getTemplateVars());
        return $service;
    }

    /**
     * @depends testTemplateVarsDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetTemplateVarsReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setTemplateVars(['foo' => 'bar']));
        return $service;
    }

    /**
     * @depends testSetTemplateVarsReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetTemplateVarsHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals(['foo' => 'bar'], $service->getTemplateVars());
        return $service;
    }

    /**
     * @depends testGetTemplateVarsHasProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSubjectPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('subject', $service);
        return $service;
    }

    /**
     * @depends testSubjectPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testSubjectDefaultValue(EmailService $service): EmailService
    {
        $this->assertNull($service->getSubject());
        return $service;
    }

    /**
     * @depends testSubjectDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetSubjectReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setSubject('test subject'));
        return $service;
    }

    /**
     * @depends testSetSubjectReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetSubjectHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals('test subject', $service->getSubject());
        return $service;
    }

    /**
     * @depends testGetSubjectHasProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testCustomVarsPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('custom_vars', $service);
        return $service;
    }

    /**
     * @depends testCustomVarsPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testCustomVarsDefaultValue(EmailService $service): EmailService
    {
        $this->assertEquals([], $service->getCustomVars());
        return $service;
    }

    /**
     * @depends testCustomVarsDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetCustomVarsReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setCustomVars(['foo' => 'bar']));
        return $service;
    }

    /**
     * @depends testSetCustomVarsReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetCustomVarsHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals(['foo' => 'bar'], $service->getCustomVars());
        return $service;
    }

    /**
     * @depends testGetCustomVarsHasProperValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testFormatPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('format', $service);
        return $service;
    }

    /**
     * @depends testFormatPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testFormatDefaultValue(EmailService $service): EmailService
    {
        $this->assertEquals('html', $service->getFormat());
        return $service;
    }

    /**
     * @depends testFormatPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testIsHtmlValue(EmailService $service): EmailService
    {
        $this->assertTrue($service->isHtml());
        return $service;
    }

    /**
     * @depends testIsHtmlValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testAsTextReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->asText());
        return $service;
    }

    /**
     * @depends testAsTextReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testAsHtmlReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->asHtml());
        return $service;
    }

    /**
     * @depends testAsHtmlReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testAsHtmlIsHtmlValueTruthiness(EmailService $service): EmailService
    {
        $this->assertTrue($service->isHtml());
        $this->assertEquals('html', $service->getFormat());
        return $service;
    }

    /**
     * @depends testAsHtmlIsHtmlValueTruthiness
     * @param EmailService $service
     * @return EmailService
     */
    public function testAsTextValueTruthiness(EmailService $service): EmailService
    {
        $service->asText();
        $this->assertFalse($service->isHtml());
        $this->assertEquals('text', $service->getFormat());
        return $service;
    }

    /**
     * @depends testAsTextValueTruthiness
     * @param EmailService $service
     * @return EmailService
     */
    public function testFromEmailPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('from_email', $service);
        return $service;
    }

    /**
     * @depends testFromEmailPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testFromEmailDefaultValue(EmailService $service): EmailService
    {
        $this->assertNull($service->getFromEmail());
        return $service;
    }

    /**
     * @depends testFromEmailDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetFromEmailReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setFromEmail('from@email.com'));
        return $service;
    }

    /**
     * @depends testSetFromEmailReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetFromEmailHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals('from@email.com', $service->getFromEmail());
        return $service;
    }

    /**
     * @depends testAsTextValueTruthiness
     * @param EmailService $service
     * @return EmailService
     */
    public function testFromNamePropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('from_name', $service);
        return $service;
    }

    /**
     * @depends testFromNamePropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testFromNameDefaultValue(EmailService $service): EmailService
    {
        $this->assertNull($service->getFromName());
        return $service;
    }

    /**
     * @depends testFromNameDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetFromNameReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setFromName('From Name'));
        return $service;
    }

    /**
     * @depends testSetFromNameReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetFromNameHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals('From Name', $service->getFromName());
        return $service;
    }

    /**
     * @depends testAsTextValueTruthiness
     * @param EmailService $service
     * @return EmailService
     */
    public function testReplyToNamePropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('from_reply_to_name', $service);
        return $service;
    }

    /**
     * @depends testReplyToNamePropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testReplyToNameDefaultValue(EmailService $service): EmailService
    {
        $this->assertNull($service->getReplyToName());
        return $service;
    }

    /**
     * @depends testReplyToNameDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetReplyToNameReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setReplyToName('Reply to Name'));
        return $service;
    }

    /**
     * @depends testSetReplyToNameReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testFromReplyToNameHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals('Reply to Name', $service->getReplyToName());
        return $service;
    }

    /**
     * @depends testAsTextValueTruthiness
     * @param EmailService $service
     * @return EmailService
     */
    public function testReplyToPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('from_reply_to', $service);
        return $service;
    }

    /**
     * @depends testReplyToPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testReplyToDefaultValue(EmailService $service): EmailService
    {
        $this->assertNull($service->getReplyToEmail());
        return $service;
    }

    /**
     * @depends testReplyToDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetReplyToEmailReturnInstance(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setReplyToEmail('reply_to@email.com'));
        return $service;
    }

    /**
     * @depends testSetReplyToEmailReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testFromReplyToEmailHasProperValue(EmailService $service): EmailService
    {
        $this->assertEquals('reply_to@email.com', $service->getReplyToEmail());
        return $service;
    }

    /**
     * @depends testFromReplyToEmailHasProperValue
     * @return EmailService
     */
    public function testInstantiationConfigDefaults(): EmailService
    {
        $config = [
            'from_name' => 'From Name',
            'from_email' => 'from@email.com',
            'reply_to_email' => 'from@to_email.com',
            'reply_to_name' => 'reply@to_name.com',
            'bcc' => [
                'one@bcc_email.com',
                'two@bcc_email.com',
            ],
            'cc' => [
                'one@cc_email.com',
                'two@cc_email.com',
            ],
            'to' => 'to@email.com',
        ];

        $service = new EmailService(null, $config);
        $this->assertEquals($config['to'], $service->getTo());
        $this->assertEquals($config['from_name'], $service->getFromName());
        $this->assertEquals($config['from_email'], $service->getFromEmail());
        $this->assertEquals($config['reply_to_email'], $service->getReplyToEmail());
        $this->assertEquals($config['reply_to_name'], $service->getReplyToName());
        $this->assertEquals($config['bcc'], $service->getBcc());
        $this->assertEquals($config['cc'], $service->getCc());

        return $service;
    }

    /**
     * @depends testInstantiationConfigDefaults
     * @param EmailService $service
     * @return EmailService
     */
    public function testTplPropertyExists(EmailService $service): EmailService
    {
        $this->assertObjectHasAttribute('tpl', $service);
        return $service;
    }

    /**
     * @depends testTplPropertyExists
     * @param EmailService $service
     * @return EmailService
     */
    public function testTplDefaultValue(EmailService $service): EmailService
    {
        $this->assertNull($service->getTpl());
        return $service;
    }

    /**
     * @depends testTplDefaultValue
     * @param EmailService $service
     * @return EmailService
     */
    public function testSetTplReturnInstance(EmailService $service): EmailService
    {
        $tpl = $this->createMock('Mithra62\LoginAlert\Services\TemplateService');
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\EmailService', $service->setTpl($tpl));
        return $service;
    }

    /**
     * @depends testSetTplReturnInstance
     * @param EmailService $service
     * @return EmailService
     */
    public function testGetTplHasProperValue(EmailService $service): EmailService
    {
        $this->assertInstanceOf('Mithra62\LoginAlert\Services\TemplateService', $service->getTpl());
        return $service;
    }
}