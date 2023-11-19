<?php

namespace Mithra62\LoginAlert\Extensions;

use ExpressionEngine\Service\Addon\Controllers\Extension\AbstractRoute;
use ExpressionEngine\Library\Data\Collection;

class MemberMemberLoginSingle extends AbstractRoute
{
    //public function process(\stdClass $member_data)
    public function process($ignore)
    {
        $alerts = ee('login_alert:AlertService')->getAlerts(false);
        if (!$alerts instanceof Collection || $alerts->count() == 0) {
            return;
        }

        $member = new \stdClass();
        $member->member_id = 1;
        foreach($alerts AS $alert) {
            if($alert->shouldProcess($member->member_id)) {
                $alert->process();
            }
        }
    }
}
