<?php
namespace Mithra62\LoginAlert\Alerts\Types;

use Mithra62\LoginAlert\Alerts\AbstractAlert;

class Cp extends AbstractAlert
{
    /**
     * @param int $member_id
     * @return bool
     */
    public function shouldProcess(int $member_id): bool
    {
        return defined('REQ') && strtoupper(REQ) == 'CP';
    }
}