<?php
namespace Mithra62\LoginAlert\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;
use Mithra62\LoginAlert\Model\MemberLoginAlert as Settings;
use Mithra62\LoginAlert\Forms\DeleteAlert;

class Delete extends AbstractRoute
{
    protected $addon_name = 'login_alert';

    public function process($id = false)
    {
        if (is_null($id)) {
            ee()->functions->redirect(ee('CP/URL')->make($this->base_url . '/vaults'));
        }

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

        $form = new DeleteAlert;

        if (!empty($_POST) && ee()->input->post('confirm') == 'y') {
            //$alert->delete();

            ee('CP/Alert')->makeBanner('shared-form')
                ->asSuccess()
                ->withTitle(lang('la.alert_deleted'))
                ->defer();

            ee()->functions->redirect($this->url('index'));
        }

        $vars = [
            'cp_page_title' => lang('la.header.delete_alert'),
            'base_url' => $this->url('delete/' . $alert->id),
            'save_btn_text' => lang('la.delete'),
            'save_btn_text_working' => lang('la.deleting'),
            'alert' => $alert,
        ];

        $vars += $form->generate();

        $this->addBreadcrumb($this->url('edit'), 'la.header.delete_alert');
        $this->setBody('edit_alert', $vars);
        $this->setHeading('la.header.alerts');
        return $this;

    }
}