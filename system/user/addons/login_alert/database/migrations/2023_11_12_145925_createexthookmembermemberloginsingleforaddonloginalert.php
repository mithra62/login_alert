<?php

use ExpressionEngine\Service\Migration\Migration;

class CreateExtHookMemberMemberLoginSingleForAddonLoginAlert extends Migration
{
    /**
     * Execute the migration
     * @return void
     */
    public function up()
    {
        $addon = ee('Addon')->get('login_alert');

        $ext = [
            'class' => $addon->getExtensionClass(),
            'method' => 'member_member_login_single',
            'hook' => 'member_member_login_single',
            'settings' => serialize([]),
            'priority' => 10,
            'version' => $addon->getVersion(),
            'enabled' => 'y'
        ];

        // If we didnt find a matching Extension, lets just insert it
        ee('Model')->make('Extension', $ext)->save();
    }

    /**
     * Rollback the migration
     * @return void
     */
    public function down()
    {
        $addon = ee('Addon')->get('login_alert');

        ee('Model')->get('Extension')
            ->filter('class', $addon->getExtensionClass())
            ->delete();
    }
}
