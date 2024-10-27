<?php

use local_logging\lib\adler_testcase;
use local_logging\task\log_rotation_task;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/local/logging/classes/task/log_rotation_task.php');
require_once($CFG->dirroot . '/local/logging/tests/lib/adler_testcase.php');


class log_rotation_task_test extends adler_testcase {
    public function test_get_name() {
        $task = new log_rotation_task();
        $result = $task->get_name();
        $this->assertIsString($result);
        $this->assertNotEmpty($result);

    }
    public function test_log_rotation() {
        global $DB, $CFG;

        // Set the number of logs to keep
        $CFG->local_logging_maxlogs = 100;

        // Simulate adding more than 100 log entries
        for ($i = 0; $i < 110; $i++) {
            $record = new stdClass();
            $record->logdate = time();
            $record->level = 300; // INFO level
            $record->component = 'testcomponent';
            $record->message = 'Test message ' . $i;
            $DB->insert_record('local_logging_log', $record);
        }

        // Verify that more than 100 records exist
        $this->assertGreaterThan(100, $DB->count_records('local_logging_log'));

        // Execute the log rotation task
        $task = new log_rotation_task();
        $task->execute();

        // Verify that only 100 records remain
        $this->assertEquals(100, $DB->count_records('local_logging_log'));

        // check latest entry exists
        $last_record = $DB->get_records('local_logging_log', null, '', 'message', 99, 1);
        $this->assertEquals('Test message 109', reset($last_record)->message, 'The last record should be "Test message 109"');

        // check first entry does not exist
        $first_record = $DB->get_records('local_logging_log', null, '', 'message', 0, 1);
        $this->assertNotEquals('Test message 0', reset($first_record)->message, 'The first record should not be "Test message 0"');
    }
}
