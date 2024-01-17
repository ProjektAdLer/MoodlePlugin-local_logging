<?php
namespace local_logging\task;

defined('MOODLE_INTERNAL') || die();

class log_rotation_task extends \core\task\scheduled_task {

    public function get_name() {
        return get_string('logrotationtask', 'local_logging');
    }

    public function execute() {
        global $DB, $CFG;

        $maxLogs = $CFG->local_logging_maxlogs ?? 10000; // Default to 10,000 if not set
        $logCount = $DB->count_records('local_logging_log');

        if ($logCount > $maxLogs) {
            $deleteCount = $logCount - $maxLogs;

            // Select the IDs of the records to delete
            $recordsToDelete = $DB->get_records_select('local_logging_log', '', null, 'id ASC', 'id', 0, $deleteCount);

            // Delete the records
            foreach ($recordsToDelete as $record) {
                $DB->delete_records('local_logging_log', ['id' => $record->id]);
            }
        }
    }
}
