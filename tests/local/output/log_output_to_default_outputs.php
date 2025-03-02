<?php

namespace local_logging\local\output;

use local_logging\lib\adler_testcase;
use local_logging\local\util;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/local/logging/tests/lib/adler_testcase.php');

class test_log_output_to_default_outputs extends adler_testcase {
    public function test_output() {
        // Arrange
        $logOutput = new log_output_to_default_outputs();
        $message = 'Test message';
        $level = util::LEVEL_TRACE;
        $component = 'testcomponent';
        $title = 'testtitle';
        $time = time();
        $user_id = null;

        // Act
        ob_start();
        $logOutput->output($message, $level, $component, $title, $time, $user_id);
        $output = ob_get_clean();

        // Assert
        $this->assertStringContainsString('[' . date('Y-m-d H:i:s', $time) . ']', $output);
        $this->assertStringContainsString('TRACE', $output);
        $this->assertStringContainsString($component, $output);
        $this->assertStringContainsString($title . ':', $output);
        $this->assertStringContainsString($message, $output);
    }
}