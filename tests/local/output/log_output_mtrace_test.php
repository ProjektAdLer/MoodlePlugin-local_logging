<?php

namespace local_logging\local\output;

use local_logging\lib\adler_testcase;
use local_logging\local\util;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/local/logging/tests/lib/adler_testcase.php');

class log_output_mtrace_test extends adler_testcase {
    public function test_output() {
        // Create an instance of log_output_stdout.
        $logOutput = new log_output_mtrace();

        // Define test data.
        $message = 'Test message';
        $level = util::LEVEL_TRACE; // Assuming 100 corresponds to TRACE level
        $component = 'testcomponent';
        $title = 'testtitle';
        $time = time();
        $user_id = null;

        // Start output buffering.
        ob_start();

        // Call the output method.
        $logOutput->output($message, $level, $component, $title, $time, $user_id);

        // Get the output and clean the buffer.
        $output = ob_get_clean();

        // Assert that the output contains the expected components.
        $this->assertStringContainsString('[' . date('Y-m-d H:i:s', $time) . ']', $output);
        $this->assertStringContainsString('TRACE', $output);
        $this->assertStringContainsString($component, $output);
        $this->assertStringContainsString($title . ':', $output);
        $this->assertStringContainsString($message, $output);
    }
}