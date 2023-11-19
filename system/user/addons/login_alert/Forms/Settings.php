<?php
namespace Mithra62\LoginAlert\Forms;

use ExpressionEngine\Library\CP\Form\AbstractForm;
use ExpressionEngine\Library\CP\Form;
use ExpressionEngine\Model\Role\Role AS RoleModel;
use ExpressionEngine\Service\Validation\Validator;

class Settings extends AbstractForm
{
    public function generate(): array
    {
        $form = new Form;
        $field_group = $form->getGroup('la.form.header.alert_details');

        $field_set = $field_group->getFieldSet('la.form.name');
        $field_set->setDesc('la.form.desc.name');
        $field = $field_set->getField('role_name', 'html');
        $field->setContent($this->getRole()->name);

        $field_set = $field_group->getFieldSet('re.form.enabled');
        $field_set->setDesc('re.form.desc.enabled');
        $field = $field_set->getField('enabled', 'select');
        $field->setValue($this->get('enabled', 0))
            ->setChoices([
                '1' => 'Yes',
                '0' => 'No',
            ]);
        // TODO: Implement generate() method.

        return $form->toArray();
    }

    /**
     * @param string $key
     * @param $default
     * @return mixed|string
     */
    public function get(string $key = '', $default = '')
    {
        $value = ee()->input->post($key);
        if(!$value) {
            $value = ee('role_expire:RolesService')->getSetting($this->getRole()->role_id, $key);
            if(!$value) {
                $value = parent::get($key, $default);
            }
        }

        return $value;
    }


    /**
     * @return Validator
     */
    public function getValidator(): Validator
    {
        $validator = ee('Validation')->make($this->rules);
        $data = $this->data;
        $validator->defineRule('whenTtlIs', function ($key, $value, $parameters, $rule) use ($data) {
            return ($data['ttl'] == $parameters[0]) ? true : $rule->skip();
        });

        $validator->defineRule('whenNotificationIs', function ($key, $value, $parameters, $rule) use ($data) {
            return ($data['notify_enabled'] == $parameters[0]) ? true : $rule->skip();
        });

        return $validator;
    }
}