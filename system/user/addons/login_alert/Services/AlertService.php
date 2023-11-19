<?php

namespace Mithra62\LoginAlert\Services;

use Mithra62\LoginAlert\Alerts\AbstractAlert;
use ExpressionEngine\Library\Data\Collection;
use Mithra62\LoginAlert\Model\MemberLoginAlerts;
use Mithra62\LoginAlert\Exceptions\Alerts\AlertException;
use ExpressionEngine\Library\String\Str;

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
                $return[] = $this->buildObj($alert);
            }
        }

        return new Collection($return);
    }

    /**
     * @param MemberLoginAlerts $alert
     * @return AbstractAlert
     */
    protected function buildObj(MemberLoginAlerts $alert): AbstractAlert
    {
        $class = 'Mithra62\LoginAlert\Alerts\Types\\' . Str::studly($alert->type);
        if (!class_exists($class)) {
            throw new AlertException("Alert Object doesn't exist! " . $class);
        }

        $obj = new $class;
        $obj->setModel($alert);
        return $obj;
    }
}