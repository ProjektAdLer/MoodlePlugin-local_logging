<?php


use core\di;

function xmldb_local_logging_upgrade($oldversion): bool {
    $db = di::get(moodle_database::class);
    $dbman = $db->get_manager(); // Loads ddl manager and xmldb classes.

    if ($oldversion < 2025030300) {
        // Define table to be deleted.
        $table = new xmldb_table('local_logging_log');

        // Drop table if it exists.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Logging upgrade save point.
        upgrade_plugin_savepoint(true, 2025030300, 'local', 'logging');
    }

    // Everything has succeeded to here. Return true.
    return true;
}