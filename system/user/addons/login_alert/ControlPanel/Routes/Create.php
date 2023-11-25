<?php
namespace Mithra62\LoginAlert\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;
use Mithra62\LoginAlert\Model\MemberLoginAlert as Settings;
use Mithra62\LoginAlert\Forms\Settings as SettingsForm;

class Create extends AbstractRoute
{
    protected $base_url = 'addons/settings/login_alert';

    public function process($id = false)
    {
        $vars['cp_page_title'] = lang('la.create_alert');
        $vars['base_url'] = $this->url('create');

        $form = new SettingsForm();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            echo 'fdsafdsafdsa';
            exit;


            $_POST['status'] = 'open';
            $plan = ee('Model')
                ->get('cartthrob_subscriptions:Plan')
                ->filter('id', ee()->input->post('plan_id'))
                ->first();

            if ($plan) {
                $_POST['interval_units'] = $plan->interval_units;
                $_POST['interval_length'] = $plan->interval_length;
                $_POST['name'] = $plan->name;
                if (empty(ee()->input->post('price')) && $plan) {
                    $_POST['price'] = $plan->price;
                }
            }

            $post_data = ee('cartthrob_subscriptions:SubscriptionsService')->processRawData($subscription, $_POST);
            $subscription->set($post_data);
            $result = $subscription->validate();
            if ($result->isValid()) {
                $price = '0'; // must submit as string since "elements()" is a silly function
                $transaction_id = '';
                $funds_handled = true;
                if (ee()->input->post('charge_before_create') == 'y') {
                    $state = ee('cartthrob_subscriptions:PaymentsService')->chargeVault($subscription->Vault, $subscription->price);
                    if (!$state->isAuthorized()) {
                        $funds_handled = false;
                        $form->setData($_POST);
                        $vars['errors'] = $result;
                        ee('CP/Alert')->makeInline('shared-form')
                            ->asIssue()
                            ->withTitle(lang('ct.sub.error.create_charge_subscription'))
                            ->now();
                    } else {
                        $transaction_id = $state->getTransactionId();
                        $price = $subscription->price;
                    }
                }

                if ($funds_handled) {
                    $subscription = ee('cartthrob_subscriptions:SubscriptionsService')->createSubscription($subscription, $post_data);
                    $overrides = [
                        'price' => $price,
                        'vault_id' => $subscription->vault_id,
                        'transaction_id' => $transaction_id,
                    ];

                    ee('cartthrob_subscriptions:SubscriptionsService')->createSubOrder($subscription, $overrides);
                    ee('CP/Alert')->makeInline('shared-form')
                        ->asSuccess()
                        ->withTitle(lang('ct.sub.subscription_created'))
                        ->defer();

                    ee()->functions->redirect(ee('CP/URL')->make($this->base_url . '/subscriptions/list-subs'));
                    exit;
                }
            } else {
                $form->setData($_POST);
                $vars['errors'] = $result;
                ee('CP/Alert')->makeInline('shared-form')
                    ->asIssue()
                    ->withTitle(lang('ct.sub.error.create_subscription'))
                    ->now();
            }
        }

        $vars = $vars + $form->generate();

        $this->addBreadcrumb($this->url('edit'), 'la.alert.edit');
        $this->setBody('edit_alert', $vars);
        $this->setHeading('re.header.edit_role_expire');
        return $this;
    }
}