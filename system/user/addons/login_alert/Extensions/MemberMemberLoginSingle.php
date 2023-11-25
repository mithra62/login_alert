<?php

namespace Mithra62\LoginAlert\Extensions;

use ExpressionEngine\Service\Addon\Controllers\Extension\AbstractRoute;
use ExpressionEngine\Library\Data\Collection;

class MemberMemberLoginSingle extends AbstractRoute
{
    /**
     * @param \stdClass $member_data
     * @return void
     */
    public function process(\stdClass $member_data)
    {
        $alerts = ee('login_alert:AlertService')->getAlerts(false);
        if (!$alerts instanceof Collection || $alerts->count() == 0) {
            return;
        }

        $req = defined('REQ') ? REQ : '';
        foreach($alerts AS $alert) {
            if($alert->shouldProcess($req, $member_data->member_id)) {
                $alert->process($req, $member_data->member_id);
            }
        }
    }
}
