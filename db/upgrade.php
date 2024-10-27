<?php


function xmldb_local_logging_upgrade($oldversion): bool {
    global $CFG, $DB;

    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.

    if ($oldversion < 2024090100) {
        // Define field user_id to be added to local_logging_log.
        $table = new xmldb_table('local_logging_log');
        $field = new xmldb_field('user_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'title');

        // Add field user_id.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define key fk_user_id to be added to local_logging_log.
        $key = new xmldb_key('fk_user_id', XMLDB_KEY_FOREIGN, ['user_id'], 'user', ['id']);

        // Add key fk_user_id.
        $dbman->add_key($table, $key);

        // Logging the upgrade.
        upgrade_plugin_savepoint(true, 2024090100, 'local', 'logging');
    }

    // Everything has succeeded to here. Return true.
    return true;
}