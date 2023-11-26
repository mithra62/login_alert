<?php
namespace Mithra62\LoginAlert\Forms;

use ExpressionEngine\Library\CP\Form\AbstractForm;
use ExpressionEngine\Library\CP\Form;

class DeleteAlert extends AbstractForm
{
    public function generate(): array
    {
        $form = new Form;
        $field_group = $form->getGroup('la.form.header.remove_alert');
        $field_set = $field_group->getFieldSet('la.form.confirm_delete');
        $field_set->setDesc('la.form.desc.confirm_delete');
        $field = $field_set->getField('confirm', 'yes_no');

        return $form->toArray();
    }
}