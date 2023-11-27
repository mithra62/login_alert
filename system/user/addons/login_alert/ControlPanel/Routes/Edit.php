<?php
namespace Mithra62\LoginAlert\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;
use Mithra62\LoginAlert\Model\MemberLoginAlert as Settings;
use Mithra62\LoginAlert\Forms\Settings as SettingsForm;

class Edit extends AbstractRoute
{
    protected $addon_name = 'login_alert';

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
            ee('CP/Alert')->makeBanner('shared-form')
                ->asIssue()
                ->withTitle(lang('la.alert_not_found'))
                ->defer();
            ee()->functions->redirect($this->url('index'));
        }

        $form = new SettingsForm;
        $form->setData($alert->toArray());
        if (ee()->input->server('REQUEST_METHOD') === 'POST') {
            $alert->set($_POST);
            $result = $alert->validate();
            if ($result->isValid()) {
                $alert->save();
                ee('CP/Alert')->makeInline('shared-form')
                    ->asSuccess()
                    ->withTitle(lang('la.alert_updated'))
                    ->defer();

                ee()->functions->redirect($this->url('index'));
                exit;

            } else {
                $form->setData($_POST);
                $vars['errors'] = $result;
                ee('CP/Alert')->makeInline('shared-form')
                    ->asIssue()
                    ->withTitle(lang('la.error.update_alert'))
                    ->now();
            }

        }

        $vars += $form->generate();

        $this->addBreadcrumb($this->url('edit'), 'la.header.edit_alert_title');
        $this->setBody('edit_alert', $vars);
        $this->setHeading('re.header.edit_role_expire');
        return $this;
    }
}