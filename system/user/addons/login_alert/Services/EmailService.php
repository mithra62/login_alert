<?php

namespace Mithra\LoginAlert\Services;

use Mithra\LoginAlert\Exceptions\Services\EmailServiceException;
use Mithra\LoginAlert\Exceptions\Services\TemplateServiceException;
use Mithra\LoginAlert\Email\Parser;

class EmailService
{
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
     * @var TemplateService
     */
    protected ?TemplateService $tpl = null;

    /**
     * @param int $site_id
     * @param array $config
     * @param TemplateService|null $tpl
     */
    public function __construct(int $site_id, array $config = [], TemplateService $tpl = null)
    {
        $this->site_id = $site_id;
        $this->config = $config;
        $this->tpl = $tpl;
        $this->tpl->setCustomDelim($this->getSetting('custom_delim', '%'));
        ee()->load->library('email');
    }

    /**
     * @param int $to
     * @return $this
     */
    public function setSiteId(int $site_id): EmailService
    {
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
        return $this->to;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function addCc(string $email): EmailService
    {
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
        return $this->template;
    }

    /**
     * @return array
     */
    public function getTemplateVars(): array
    {
        return $this->template_vars;
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
     * @param string $name
     * @return $this
     */
    public function setReplyToName(string $name): EmailService
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
            $this->from_reply_to_name = $this->getSetting('reply_to_name');
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
     * @param array $email
     * @return bool
     */
    public function dispatch(array $email): bool
    {
        $mg = Mailgun::create($this->getSetting('private_key'));
        $builder = new MessageBuilder();

        $recipients = $email['recipients'] ?? [];
        $cc = $email['cc_array'] ?? [];
        $bcc = $email['bcc_array'] ?? [];

        foreach ($recipients as $recipient) {
            $builder->addToRecipient($recipient);
        }

        foreach ($cc as $recipient) {
            $builder->addCcRecipient($recipient);
        }

        foreach ($bcc as $recipient) {
            $builder->addBccRecipient($recipient);
        }

        $subject = $email['subject'];
        if (! $subject) {
            $subject = $email['headers']['Subject'];
        }

        $content = Parser::parse($email);
        $builder->setFromAddress($this->getFromEmail());
        $builder->setSubject($subject);

        if ($content['html'] && $this->isHtml()) {
            $builder->setHtmlBody($content['html']);
        }

        if ($content['text']) {
            $builder->setTextBody($content['text']);
        }

        $builder->setTestMode($this->getSetting('test_mode', false));

        // disable link tracking with password reset links
        if ($this->endsWith($subject, 'Password Reset Request')) {
            $track_open = false;
            $track_click = false;
        } else {
            $track_open = true;
            $track_click = true;
        }

        $builder->setOpenTracking($track_open);
        $builder->setClickTracking($track_click);

        switch ($this->getSiteId()) {
            case 1:
                $mg_domain = $this->getSetting('bb_domain');
                break;
            case 2:
                $mg_domain = $this->getSetting('cnc_domain');
                break;
            default:
                $mg_domain = $this->getSetting('bb_domain'); // fallback
                mail('admin@oc03.com', 'BB Error',
                    'Method:'.__METHOD__."\n\nLine: ".__LINE__."\n\n".print_r($this, true));
                break;
        }

        $this->logger()->debug('Sending domain set to '.$mg_domain);
        $sent = $mg->messages()->send($mg_domain, $builder->getMessage());
        if ($sent instanceof SendResponse) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     * @param string $haystack
     * @param string $needle
     */
    private function endsWith($haystack, $needle) {
        $length = strlen($needle);
        return $length > 0 ? substr($haystack, -$length) === $needle : true;
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
            throw new EmailServiceException("Validation Failed: ".json_encode($result->getAllErrors()));
        }
    }
}