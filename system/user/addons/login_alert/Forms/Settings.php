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

        $field_set = $field_group->getFieldSet('la.form.status');
        $field_set->setDesc('la.form.desc.status');
        $field = $field_set->getField('status', 'select');
        $field->setValue($this->get('status', 0))
            ->setChoices($this->options['yes_no']);

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

        $field_set = $field_group->getFieldSet('la.form.log_into_when');
        $field_set->setDesc('la.form.desc.log_into_when');
        $field = $field_set->getField('log_into_when', 'select');
        $field->setValue($this->get('log_into_when', 0))
            ->setChoices([
                'member' => lang('la.form.type.log_into_when.member'),
                'role' => lang('la.form.type.log_into_when.role'),
            ])
            ->setValue($this->get('log_into_when'));

        $field_set = $field_group->getFieldSet('la.form.log_into_what');
        $field_set->setDesc('la.form.desc.log_into_what');
        $field = $field_set->getField('log_into_what', 'text')
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

        $field_set = $field_group->getFieldSet('la.form.notify_template');
        $field_set->setDesc('la.form.desc.notify_template');
        $field = $field_set->getField('notify_template', 'select');
        $field->setValue($this->get('notify_template'))
            ->setChoices($this->templateOptions());

        return $form->toArray();
    }

    protected function templateOptions(): array
    {
        $templates = [];

        ee()->load->model('template_model');

        $query = ee()->template_model->get_templates();

        foreach ($query->result() as $row) {
            $templates[$row->group_name . '/' . $row->template_name] = $row->group_name . '/' . $row->template_name;
        }

        return $templates;
    }
}