<?php
use local_logging\task\log_rotation_task;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/local/logging/classes/task/log_rotation_task.php');

class log_rotation_task_test extends advanced_testcase {

    public function setUp(): void {
        $this->resetAfterTest(true);
    }

    public function test_log_rotation() {
        global $DB, $CFG;

        // Set the number of logs to keep
        $CFG->local_logging_maxlogs = 100;

        // Simulate adding more than 10,000 log entries
        for ($i = 0; $i < 110; $i++) {
            $record = new stdClass();
            $record->logdate = time();
            $record->level = 300; // INFO level
            $record->component = 'testcomponent';
            $record->message = 'Test message ' . $i;
            $DB->insert_record('local_logging_log', $record);
        }

        // Verify that more than 10,000 records exist
        $this->assertGreaterThan(100, $DB->count_records('local_logging_log'));

        // Execute the log rotation task
        $task = new log_rotation_task();
        $task->execute();

        // Verify that only 10,000 records remain
        $this->assertEquals(100, $DB->count_records('local_logging_log'));
    }
}
