<?php

namespace Mithra62\LoginAlert\Services;

use Mithra62\LoginAlert\Exceptions\Services\EmailServiceException;
use Mithra62\LoginAlert\Exceptions\Services\TemplateServiceException;
use Mithra62\LoginAlert\Traits\LoggerTrait;

class EmailService
{
    use LoggerTrait;

    /**
     * @var int
     */
    public int $site_id = 1;

    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @var string|null
     */
    protected ?string $to = null;

    /**
     * @var array
     */
    protected array $cc = [];

    /**
     * @var array
     */
    protected array $bcc = [];

    /**
     * @var string|null
     */
    protected ?string $template = null;

    /**
     * @var array
     */
    protected array $template_vars = [];

    /**
     * @var string|null
     */
    protected ?string $subject = null;

    /**
     * @var array
     */
    protected array $custom_vars = [];

    /**
     * @var string
     */
    protected string $format = 'html';

    /**
     * @var string|null
     */
    protected ?string $from_email = null;

    /**
     * @var string|null
     */
    protected ?string $from_name = null;

    /**
     * @var string|null
     */
    protected ?string $from_reply_to = null;

    /**
     * @var string|null
     */
    protected ?string $from_reply_to_name = null;

    /**
     * @var TemplateService|null
     */
    protected ?TemplateService $tpl = null;

    /**
     * @param int|null $site_id
     * @param array $config
     * @param TemplateService|null $tpl
     */
    public function __construct(int $site_id = null, array $config = [], TemplateService $tpl = null)
    {
        $this->logger()->debug('Initialized');
        if($site_id) {
            $this->setSiteId($site_id);
        }

        if($config) {
            $this->setConfig($config);
        }

        if($tpl) {
            $this->tpl = $tpl;
            $this->tpl->setCustomDelim($this->getSetting('custom_delim', '%'));
        }

        ee()->load->library('email');
    }

    /**
     * @param int $site_id
     * @return $this
     */
    public function setSiteId(int $site_id): EmailService
    {
        $this->logger()->debug('Set site_id');
        $this->site_id = $site_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getSiteId()
    {
        return $this->site_id;
    }

    /**
     * @param string $to
     * @return $this
     */
    public function setTo(string $to): EmailService
    {
        $this->logger()->debug('To Email address set to ' . $to);
        $this->to = $to;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTo(): ?string
    {
        if (is_null($this->to)) {
            $this->to = $this->getSetting('to');
        }

        return $this->to;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function addCc(string $email): EmailService
    {
        $this->logger()->debug('CC Email address added ' . $email);
        $this->cc[] = $email;
        return $this;
    }

    /**
     * @param array $cc
     * @return $this
     */
    public function setCc(array $cc = []): EmailService
    {
        $this->logger()->debug('CC Email addresses set to ' . json_encode($cc));
        $this->cc = $cc;
        return $this;
    }

    /**
     * @return array
     */
    public function getCc(): array
    {
        if (!$this->cc) {
            $this->cc = $this->getSetting('cc', []);
        }

        return $this->cc;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function addBcc(string $email): EmailService
    {
        $this->bcc[] = $email;
        return $this;
    }

    /**
     * @param array $bcc
     * @return $this
     */
    public function setBcc(array $bcc = []): EmailService
    {
        $this->logger()->debug('BCC Email addresses set to ' . json_encode($bcc));
        $this->bcc = $bcc;
        return $this;
    }

    /**
     * @return array
     */
    public function getBcc(): array
    {
        if (!$this->bcc) {
            $this->bcc = $this->getSetting('bcc', []);
        }

        return $this->bcc;
    }

    /**
     * @param string $template
     * @return $this
     */
    public function setTemplate(string $template, array $variables = []): EmailService
    {
        $this->logger()->debug('Email template set to ' . $template, $variables);
        $this->template = $template;
        $this->template_vars = $variables;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTemplate(): ?string
    {
        if (is_null($this->template)) {
            $this->template = $this->getSetting('template');
        }

        return $this->template;
    }

    /**
     * @return array
     */
    public function getTemplateVars(): array
    {
        if (is_null($this->template_vars)) {
            $this->template_vars = $this->getSetting('template_vars');
        }

        return $this->template_vars;
    }

    /**
     * @param array $vars
     * @return $this
     */
    public function setTemplateVars(array $vars = [])
    {
        $this->template_vars = $vars;
        return $this;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject(string $subject): EmailService
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        if (is_null($this->subject)) {
            $this->subject = $this->getSetting('subject');
        }

        return $this->subject;
    }

    /**
     * @return array
     */
    public function getCustomVars(): array
    {
        return $this->custom_vars;
    }

    /**
     * @param array $vars
     * @return $this
     */
    public function setCustomVars(array $vars): EmailService
    {
        $this->custom_vars = $vars;
        return $this;
    }

    /**
     * @return $this
     */
    public function asText(): EmailService
    {
        $this->format = 'text';
        return $this;
    }

    /**
     * @return $this
     */
    public function asHtml(): EmailService
    {
        $this->format = 'html';
        return $this;
    }

    /**
     * @return bool
     */
    public function isHtml(): bool
    {
        return $this->format == 'html';
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return string|null
     */
    public function getFromName(): ?string
    {
        if (is_null($this->from_name)) {
            $this->from_name = $this->getSetting('from_name');
        }

        return $this->from_name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setFromName(string $name): EmailService
    {
        $this->from_name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFromEmail(): ?string
    {
        if (is_null($this->from_email)) {
            $this->from_email = $this->getSetting('from_email');
        }

        return $this->from_email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setFromEmail(string $email): EmailService
    {
        $this->from_email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReplyToEmail(): ?string
    {
        if (is_null($this->from_reply_to)) {
            $this->from_reply_to = $this->getSetting('reply_to_email');
        }

        return $this->from_reply_to;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setReplyToName(?string $name): EmailService
    {
        $this->from_reply_to_name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReplyToName(): ?string
    {
        if (is_null($this->from_reply_to_name)) {
            $this->from_reply_to_name = $this->getSetting('reply_to_name') ?? $this->getSetting('from_name');
        }

        return $this->from_reply_to_name;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setReplyToEmail(string $email): EmailService
    {
        $this->from_reply_to = $email;
        return $this;
    }

    /**
     * @return bool
     */
    public function send(): bool
    {
        $this->logger()->debug('Email dispatch started', $this->toArray());
        ee()->email->clear();

        $options = [
            'mailtype' => $this->getFormat(),
            'validate' => true
        ];

        try {

            if(is_null($this->tpl)) {
                throw new EmailServiceException("Template Service isn't setup for Email Service use!");
            }

            $this->validate();
            ee()->email->initialize($options);
            ee()->email
                ->from($this->getFromEmail(), $this->getFromName())
                ->to($this->getTo())
                ->reply_to($this->getReplyToEmail(), $this->getReplyToName())
                ->subject($this->tpl->parseStr($this->getSubject(), $this->getTemplateVars(), $this->getCustomVars()))
                ->message($this->tpl->parseTemplate($this->getTemplate(), $this->getTemplateVars(), $this->getCustomVars()));

            if ($this->getCc()) {
                ee()->email->cc($this->getCc());
            }

            if ($this->getBcc()) {
                ee()->email->bcc($this->getBcc());
            }

            ee()->email->send();
            $this->logger()->debug('Email dispatch completed');
            return true;
        } catch (EmailServiceException $e) {
            $this->logger()->emergency($e->getMessage(), $this->toArray());
            return false;
        } catch (TemplateServiceException $e) {
            $this->logger()->emergency($e->getMessage(), $this->toArray());
            return false;
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'email_to' => $this->getTo(),
            'email_from_email' => $this->getFromEmail(),
            'email_from_name' => $this->getFromName(),
            'email_subject' => $this->getSubject(),
            'template' => $this->getTemplate(),
            'email_reply_email' => $this->getReplyToEmail(),
            'email_reply_name' => $this->getReplyToName(),
        ];
    }

    /**
     * @param $key
     * @param $default
     * @return mixed|null
     */
    protected function getSetting($key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config): EmailService
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param TemplateService $tpl
     * @return $this
     */
    public function setTpl(TemplateService $tpl): EmailService
    {
        $this->tpl = $tpl;
        return $this;
    }

    /**
     * @return TemplateService|null
     */
    public function getTpl(): ?TemplateService
    {
        return $this->tpl;
    }

    /**
     * @return void
     * @throws EmailServiceException
     */
    protected function validate(): void
    {
        $data = $this->toArray();
        $rules = [
            'email_to' => 'required|email',
            'email_from_email' => 'required|email',
            'email_from_name' => 'required',
            'email_subject' => 'required',
            'template' => 'required',
            'email_reply_email' => 'required|email',
            'email_reply_name' => 'required',
        ];

        $result = ee('Validation')->make($rules)->validate($data);
        if (!$result->isValid()) {
            throw new EmailServiceException("Email Service Validation Failed: ".json_encode($result->getAllErrors()));
        }
    }
}