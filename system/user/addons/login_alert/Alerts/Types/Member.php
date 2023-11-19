<?php
namespace Mithra62\LoginAlert\Alerts\Types;

use Mithra62\LoginAlert\Alerts\AbstractAlert;

class Member extends AbstractAlert
{
    /**
     * @return bool
     */
    public function shouldProcess(): bool
    {
        return false;
    }
}