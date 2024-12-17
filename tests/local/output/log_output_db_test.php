<?php

namespace local_logging\local\output;

use core\di;
use local_logging\lib\adler_testcase;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/local/logging/tests/lib/adler_testcase.php');

class log_output_db_test extends adler_testcase {
    public function test_output() {
        global $DB;

        // Create an instance of log_output_db.
        $logOutput = di::get(log_output_db::class);

        // Define test data.
        $message = 'Test message';
        $level = 100;
        $component = 'testcomponent';
        $title = 'testtitle';
        $time = time();
        $user_id = null;

        // Call the output method.
        $logOutput->output($message, $level, $component, $title, $time, $user_id);

        // Retrieve the last log entry from the database.
        $lastlog = $DB->get_records('local_logging_log', null, 'id DESC', '*', 0, 1);
        if ($lastlog) {
            $lastlog = reset($lastlog); // Resets the internal pointer of the array to the first element and returns the value of the first array element.
        }

        // Assert that the log entry is as expected.
        $this->assertEquals($message, $lastlog->message);
        $this->assertEquals($level, $lastlog->level);
        $this->assertEquals($component, $lastlog->component);
        $this->assertEquals($title, $lastlog->title);
        $this->assertEquals($time, $lastlog->logdate);
        $this->assertNull($lastlog->user_id);
    }
}