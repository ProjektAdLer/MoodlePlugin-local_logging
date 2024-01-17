<?php
use local_logging\logger;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/local/logging/classes/logger.php');

class logger_test extends advanced_testcase {

    public function setUp(): void {
        // Set up the necessary environment.
        $this->resetAfterTest(true);
    }

    public function test_log_info() {
        global $DB;
        global $CFG;

        // Set min log level to 'TRACE'
        $CFG->local_logging_minloglevel = 'DEBUG';

        // Create a logger instance.
        $logger = new logger('testcomponent', 'testtitle');

        // Use the logger to log an info message.
        $logger->info('Test info message');

        // Retrieve the last log entry from the database.
        $lastlog = $DB->get_records('local_logging_log', null, 'id DESC', '*', 0, 1);
        if ($lastlog) {
            $lastlog = reset($lastlog); // Resets the internal pointer of the array to the first element and returns the value of the first array element.
        }
        // Assert that the log entry is as expected.
        $this->assertEquals('Test info message', $lastlog->message);
        $this->assertEquals(logger::LEVEL_INFO, $lastlog->level);
        $this->assertEquals('testcomponent', $lastlog->component);
        $this->assertEquals('testtitle', $lastlog->title);

        // just call the other logging methods
        $logger->trace('Test trace message');
        $logger->debug('Test debug message');
        $logger->warning('Test warning message');
        $logger->error('Test error message');

        // verify there are now 4 log entries (none for TRACE as min log level is DEBUG)
        $this->assertEquals(4, $DB->count_records('local_logging_log'));
    }
}
