<?php

namespace Mithra62\LoginAlert\Services;

use ExpressionEngine\Library\Data\Collection;
use ExpressionEngine\Model\Member\Member AS MemberModel;
use ExpressionEngine\Model\Role\Role AS RoleModel;

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

    /**
     * @param $role_ids
     * @return bool
     */
    public function validateRoleIds($role_ids): bool
    {
        $check = explode(',', $role_ids);
        $return = false;
        if(is_array($check)) {
            foreach($check AS $role_id) {
                $role = ee('Model')
                    ->get('Role')
                    ->filter('role_id', $role_id)
                    ->first();

                if(!$role instanceof RoleModel) {
                    $return = true;
                    break;
                }
            }
        }

        return $return;
    }

    /**
     * @param $member_ids
     * @return bool
     */
    public function validateMemberIds($member_ids): bool
    {
        $check = explode(',', $member_ids);
        $return = false;
        if(is_array($check)) {
            foreach($check AS $role_id) {
                $role = ee('Model')
                    ->get('Member')
                    ->filter('member_id', $role_id)
                    ->first();

                if(!$role instanceof MemberModel) {
                    $return = true;
                    break;
                }
            }
        }

        return $return;
    }
}