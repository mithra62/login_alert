<?php
namespace Mithra62\LoginAlert\Alerts;

use Mithra62\LoginAlert\Model\MemberLoginAlerts AS Settings;
use ExpressionEngine\Library\Data\Entity;

abstract class AbstractAlert extends Entity
{
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
     * @var int
     */
    protected int $created_date;

    /**
     * @var int
     */
    protected int $last_updated;

    /**
     * @var Settings|null
     */
    protected ?Settings $model = null;

    /**
     * @return mixed
     */
    abstract public function shouldProcess(int $member_id): bool;

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
    public function setModel(Settings $model)
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
}