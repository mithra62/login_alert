<?php
namespace Mithra62\LoginAlert\Model;

use ExpressionEngine\Service\Model\Model;
use ExpressionEngine\Service\Validation\Validator;

class MemberLoginAlerts extends Model
{
    protected static $_primary_key = 'id';
    protected static $_table_name = 'member_login_alerts';

    protected int $id;
    protected string $name;
    protected int $template;
    protected int $status;
    protected string $subject;
    protected string $to;
    protected int $created_date;
    protected int $last_updated;
}