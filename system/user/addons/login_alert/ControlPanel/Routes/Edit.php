<?php
namespace Mithra62\LoginAlert\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;
use Mithra62\LoginAlert\Model\MemberLoginAlerts as Settings;
use Mithra62\LoginAlert\Forms\Settings as SettingsForm;

class Edit extends AbstractRoute
{
    /**
     * @var string
     */
    protected $base_url = 'addons/settings/login_alert';

    public function process($id = false)
    {
        $vars['cp_page_title'] = lang('la.edit_alert_title');
        $vars['base_url'] = ee('CP/URL')->make($this->base_url . '/edit/' . $id);

        $alert = ee('Model')
            ->get('login_alert:Settings')
            ->filter('id', $id)
            ->first();

        if (!$alert instanceof Settings) {
            ee('CP/Alert')->makeBanner('plan-delete')
                ->asIssue()
                ->withTitle(lang('la.alert_not_found'))
                ->defer();
            ee()->functions->redirect($this->url('index'));
        }

        $form = new SettingsForm;
        $form->setData($alert->toArray());
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 'fdsa';
            exit;
        }

        $vars += $form->generate();

        $this->addBreadcrumb($this->url('edit'), 're.header.edit_role_expire');
        $this->setBody('edit_alert', $vars);
        $this->setHeading('re.header.edit_role_expire');
        return $this;
    }
}