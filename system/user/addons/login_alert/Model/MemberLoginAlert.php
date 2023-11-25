<?php
namespace Mithra62\LoginAlert\Model;

use ExpressionEngine\Service\Model\Model;
use ExpressionEngine\Service\Validation\Validator;

class MemberLoginAlert extends Model
{
    protected static $_primary_key = 'id';
    protected static $_table_name = 'member_login_alerts';

    protected int $id;
    protected int $site_id;
    protected string $name;
    protected int $status;
    protected int $created_date;
    protected int $last_updated;

    /**
     * The EE template to use for the notification
     * @var string
     */
    protected string $notify_template;

    /**
     * @var string
     */
    protected string $notify_subject;

    /**
     * The emails to send notifications to
     * @var string
     */
    protected string $notify_emails;

    /**
     * The member_ids, seperated by commas, to notify
     * @experimental
     * @var string
     */
    protected string $notify_member_ids;

    /**
     * Whether cp, frontend, or both
     * @var string
     */
    protected string $log_into;

    /**
     * The user session criteria to base notifications against
     * Either member or role
     * @var string
     */
    protected string $log_into_when;

    /**
     * The value component for session  criteria
     * @var string
     */
    protected string $log_into_what;

    /**
     * @param string $req
     * @param int $member_id
     * @return bool
     */
    public function shouldProcess(string $req, int $member_id): bool
    {
        if($req == $this->log_into || $this->log_into == 'both') {
            if($this->log_into_when == 'member') {
                return $this->isMember($member_id);
            } elseif($this->log_into_when == 'role') {
                return $this->isRole($member_id);
            }
        }

        return false;
    }

    /**
     * @param string $req
     * @param int $member_id
     * @return void
     */
    public function process(string $req, int $member_id): void
    {
        $deliveries = explode(',', $this->notify_emails);
        foreach($deliveries AS $delivery) {
            if (filter_var($delivery, FILTER_VALIDATE_EMAIL)) {
                ee('login_alert:EmailService')
                    ->setTo($delivery)
                    ->setFromEmail(ee()->config->item('webmaster_email'))
                    ->setFromName(ee()->config->item('site_name'))
                    ->setReplyToEmail(ee()->config->item('webmaster_email'))
                    ->setReplyToName(ee()->config->item('site_name'))
                    ->setSubject($this->notify_subject)
                    ->setTemplate($this->notify_template, $this->toArray())
                    ->send();
            }
        }
    }

    /**
     * @param int $member_id
     * @return bool
     */
    protected function isMember(int $member_id): bool
    {
        $log_into_what = explode(',',$this->log_into_what);
        foreach($log_into_what AS $key => $value) {
            if($member_id == (int)trim($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int $member_id
     * @return bool
     */
    protected function isRole(int $member_id): bool
    {
        $log_into_what = explode(',',$this->log_into_what);
        $roles = ee('login_alert:AlertService')->getMemberRoles($member_id);
        foreach($log_into_what AS $key => $role) {
            if(in_array((int)trim($role), $roles)) {
                return true;
            }
        }

        return false;
    }
}