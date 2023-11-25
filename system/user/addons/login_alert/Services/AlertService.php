<?php

namespace Mithra62\LoginAlert\Services;

use Mithra62\LoginAlert\Model\MemberLoginAlert AS Settings;
use Mithra62\LoginAlert\Exceptions\Alerts\AlertException;
use ExpressionEngine\Library\String\Str;
use ExpressionEngine\Library\Data\Collection;
use ExpressionEngine\Model\Member\Member AS MemberModel;

class AlertService extends AbstractService
{
    /**
     * @param int|null $site_id
     */
    public function __construct(int $site_id = null)
    {
        if($site_id) {
            $this->site_id = $site_id;
        }
    }

    /**
     * @param $all
     * @return Collection
     */
    public function getAlerts($all = true): Collection
    {
        $return = [];
        $model = ee('Model')
            ->get('login_alert:Settings')
            ->filter('site_id', $this->getSiteId());

        if (!$all) {
            $model->filter('status', 1);
        }

        if ($model->count() >= 1) {
            foreach ($model->all() AS $alert) {
                $return[] = $alert;
            }
        }

        return new Collection($return);
    }

    /**
     * @param int $member_id
     * @return array
     */
    public function getMemberRoles(int $member_id): array
    {
        $return = [];
        $member = ee('Model')
            ->get('Member')
            ->filter('member_id', $member_id)
            ->first();

        if($member instanceof MemberModel) {
            $return[$member->PrimaryRole->role_id] = $member->PrimaryRole->role_id;
            foreach($member->Roles AS $role) {
                $return[$role->role_id] = $role->role_id;
            }
        }

        return array_merge($return); //easy normalize
    }
}