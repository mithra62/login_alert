<?php
namespace Mithra62\LoginAlert\Alerts;

use Mithra62\LoginAlert\Exceptions\Alerts\AlertException;
use Mithra62\LoginAlert\Model\MemberLoginAlerts AS Settings;
use Mithra62\LoginAlert\Traits\LoggerTrait;
use ExpressionEngine\Library\Data\Entity;

abstract class AbstractAlert extends Entity
{
    use LoggerTrait;

    /**
     * @var int
     */
    protected int $id;

    /**
     * @var int
     */
    protected int $site_id;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $template;

    /**
     * @var string
     */
    protected string $status;

    /**
     * @var string
     */
    protected string $subject;

    /**
     * @var array
     */
    protected array $notify_emails;

    /**
     * @var array
     */
    protected array $notify_member_ids;

    /**
     * @var int
     */
    protected int $created_date;

    /**
     * @var int
     */
    protected int $last_updated;

    /**
     * The currently logged in member ID
     * Used to determine Alert flow
     * @var int
     */
    protected int $member_id;

    /**
     * @var Settings|null
     */
    protected ?Settings $model = null;

    /**
     * @return bool
     */
    abstract public function shouldProcess(): bool;

    /**
     * @return void
     */
    public function process()
    {
        $this->logger()->debug('Alert process start');
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getStatus() === 1;
    }

    /**
     * @return Settings|null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param Settings $model
     * @return $this
     */
    public function setModel(Settings $model): AbstractAlert
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        if(!$this->id) {
            $this->id = $this->getModel()->id;
        }

        return $this->id;
    }

    /**
     * @return int
     */
    public function getSiteId(): int
    {
        if(!$this->site_id) {
            $this->site_id = $this->getModel()->site_id;
        }

        return $this->site_id;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        if(!$this->status) {
            $this->status = $this->getModel()->status;
        }

        return $this->status;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if(!$this->name) {
            $this->name = $this->getModel()->name;
        }

        return $this->name;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        if(!$this->subject) {
            $this->subject = $this->getModel()->subject;
        }

        return $this->subject;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        if(!$this->template) {
            $this->template = $this->getModel()->template;
        }

        return $this->template;
    }

    /**
     * @return array
     */
    public function getNotifyEmails(): array
    {
        if(!$this->notify_emails) {
            $this->notify_emails = json_decode($this->getModel()->notify_emails);
        }

        return $this->notify_emails;
    }

    /**
     * @return array
     */
    public function getNotifyMemberIds(): array
    {
        if(!$this->notify_member_ids) {
            $this->notify_member_ids = json_decode($this->getModel()->notify_member_ids);
        }

        return $this->notify_member_ids;
    }

    /**
     * @return int
     */
    public function getCreatedDate(): int
    {
        if(!$this->created_date) {
            $this->created_date = $this->getModel()->created_date;
        }

        return $this->created_date;
    }

    /**
     * @param int $member_id
     * @return $this
     */
    public function setMemberId(int $member_id): AbstractAlert
    {
        $this->member_id = $member_id;
        return $this;
    }

    /**
     * @return int
     * @throws AlertException
     */
    public function getMemberId(): int
    {
        if(!$this->member_id) {
            throw new AlertException("Member ID isn't set yet!");
        }

        return $this->member_id;
    }
}