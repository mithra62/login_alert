<?php
namespace Mithra62\LoginAlert\Forms;

use ExpressionEngine\Library\CP\Form\AbstractForm;
use ExpressionEngine\Library\CP\Form;

class Settings extends AbstractForm
{
    public function generate(): array
    {

        $form = new Form;

        //basics
        $field_group = $form->getGroup('la.form.header.alert_details');

        $field_set = $field_group->getFieldSet('la.form.name');
        $field_set->setDesc('la.form.desc.name');
        $field = $field_set->getField('role_name', 'text');

        $field_set = $field_group->getFieldSet('la.form.enabled');
        $field_set->setDesc('la.form.desc.enabled');
        $field = $field_set->getField('enabled', 'select');
        $field->setValue($this->get('enabled', 0))
            ->setChoices($this->options['yes_no']);

        //notification fields
        $field_group = $form->getGroup('la.form.header.notification');

        $field_set = $field_group->getFieldSet('la.form.notify_to');
        $field_set->setDesc('la.form.note.notify_to');
        $field = $field_set->getField('notify_to', 'text')
            ->setValue($this->get('notify_to'));

        $field_set = $field_group->getFieldSet('la.form.notify_subject');
        $field_set->setDesc('la.form.note.notify_subject');
        $field = $field_set->getField('notify_subject', 'text')
            ->setValue($this->get('notify_subject'));

        $field_set = $field_group->getFieldSet('la.form.notify_format');
        $field_set->setDesc('la.form.desc.notify_format');
        $field = $field_set->getField('notify_format', 'select');
        $field->setValue($this->get('notify_format'))
            ->setChoices([
                'html' => 'HTML',
                'text' => 'Text',
            ]);

        return $form->toArray();
    }
}