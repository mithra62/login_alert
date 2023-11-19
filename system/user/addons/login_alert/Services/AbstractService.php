<?php

namespace Mithra62\LoginAlert\Services;

use Mithra62\LoginAlert\Traits\LoggerTrait;

abstract class AbstractService
{
    use LoggerTrait;

    /**
     * @var int|null
     */
    protected ?int $site_id = 1;

    /**
     * @param int $site_id
     * @return $this
     */
    public function setSiteId(int $site_id): AbstractService
    {
        $this->logger()->debug('Set site_id');
        $this->site_id = $site_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getSiteId(): ?int
    {
        return $this->site_id;
    }

}