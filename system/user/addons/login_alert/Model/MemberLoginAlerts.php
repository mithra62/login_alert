<?php
namespace Mithra62\LoginAlert\Model;

use ExpressionEngine\Service\Model\Model;
use ExpressionEngine\Service\Validation\Validator;

class MemberLoginAlerts extends Model
{
    protected static $_primary_key = 'id';
    protected static $_table_name = 'member_login_alerts';

    protected int $id;
    protected int $site_id;
    protected string $name;
    protected string $notify_template;
    protected int $status;
    protected string $notify_subject;
    protected string $type;
    protected string $notify_emails;
    protected string $notify_member_ids;

    protected int $created_date;
    protected int $last_updated;
}