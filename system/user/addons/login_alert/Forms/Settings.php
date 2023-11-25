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
        $field = $field_set->getField('name', 'text')
            ->setValue($this->get('name'));

        $field_set = $field_group->getFieldSet('la.form.enabled');
        $field_set->setDesc('la.form.desc.enabled');
        $field = $field_set->getField('enabled', 'select');
        $field->setValue($this->get('enabled', 0))
            ->setChoices($this->options['yes_no'])
            ->setValue($this->get('enabled'));

        $field_set = $field_group->getFieldSet('la.form.log_into');
        $field_set->setDesc('la.form.desc.log_into');
        $field = $field_set->getField('log_into', 'select');
        $field->setValue($this->get('log_into', 0))
            ->setChoices([
                'CP' => lang('la.form.type.cp'),
                'PAGE' => lang('la.form.type.frontend'),
                'both' => lang('la.form.type.both'),
            ])
            ->setValue($this->get('log_into'));

        $field_set = $field_group->getFieldSet('la.form.log_into_what');
        $field_set->setDesc('la.form.desc.log_into_what');
        $field = $field_set->getField('log_into_what', 'select');
        $field->setValue($this->get('log_into_what', 0))
            ->setChoices([
                'member' => lang('la.form.type.log_into_what.member'),
                'role' => lang('la.form.type.log_into_what.role'),
            ])
            ->setValue($this->get('log_into_what'));

        //notification fields
        $field_group = $form->getGroup('la.form.header.notification');

        $field_set = $field_group->getFieldSet('la.form.notify_emails');
        $field_set->setDesc('la.form.note.notify_emails');
        $field = $field_set->getField('notify_emails', 'text')
            ->setValue($this->get('notify_emails'));

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