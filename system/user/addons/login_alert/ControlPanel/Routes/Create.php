<?php
namespace Mithra62\LoginAlert\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;
use Mithra62\LoginAlert\Forms\Settings as SettingsForm;

class Create extends AbstractRoute
{
    protected $addon_name = 'login_alert';

    public function process($id = false)
    {
        $vars['cp_page_title'] = lang('la.create_alert');
        $vars['base_url'] = $this->url('create');
        $vars['save_btn_text'] = lang('la.create');
        $vars['save_btn_text_working'] = lang('la.creating');

        $form = new SettingsForm();
        $alert = ee('Model')
            ->make('login_alert:Settings');
        if (ee()->input->server('REQUEST_METHOD') === 'POST') {
            $form->setData($_POST);
            $alert->set($_POST);
            $result = $alert->validate();
            if ($result->isValid()) {
                $alert->save();
                ee('CP/Alert')->makeInline('shared-form')
                    ->asSuccess()
                    ->withTitle(lang('la.alert_created'))
                    ->defer();

                ee()->functions->redirect($this->url('index'));
                exit;
            } else {
                $vars['errors'] = $result;
                ee('CP/Alert')->makeInline('shared-form')
                    ->asIssue()
                    ->withTitle(lang('la.error.create.alert'))
                    ->now();
            }
        }

        $vars += $form->generate();

        $this->addBreadcrumb($this->url('edit'), 'la.alert.create');
        $this->setBody('edit_alert', $vars);
        $this->setHeading('la.header.create_alert');
        return $this;
    }
}