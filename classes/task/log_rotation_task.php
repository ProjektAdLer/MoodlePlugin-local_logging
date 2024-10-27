<?php
namespace local_logging\task;

use coding_exception;
use core\di;
use core\task\scheduled_task;
use dml_exception;
use lang_string;
use local_logging\local\db\log_repository;

defined('MOODLE_INTERNAL') || die();

class log_rotation_task extends scheduled_task {

    /**
     * @throws coding_exception
     */
    public function get_name(): lang_string|string {
        return get_string('logrotationtask', 'local_logging');
    }

    /**
     * @throws dml_exception
     */
    public function execute(): void {
        global $CFG;

        $maxLogs = $CFG->local_logging_maxlogs ?? 10000; // Default to 10,000 if not set
        $logCount = di::get(log_repository::class)->count();

        if ($logCount > $maxLogs) {
            $deleteCount = $logCount - $maxLogs;

            // Select the IDs of the records to delete
            $records_to_delete = di::get(log_repository::class)->get_records_range(0, $deleteCount, 'id ASC');

            // Delete the records
            foreach ($records_to_delete as $record) {
                di::get(log_repository::class)->delete($record->id);
            }
        }
    }
}
