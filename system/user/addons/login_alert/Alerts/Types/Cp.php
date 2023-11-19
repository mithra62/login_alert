<?php
namespace Mithra62\LoginAlert\Alerts\Types;

use Mithra62\LoginAlert\Alerts\AbstractAlert;

class Cp extends AbstractAlert
{
    /**
     * @return bool
     */
    public function shouldProcess(): bool
    {
        return defined('REQ') && strtoupper(REQ) == 'CP';
    }
}