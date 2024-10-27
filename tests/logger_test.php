<?php

namespace local_logging;

global $CFG;

use core\di;
use local_logging\lib\adler_testcase;
use local_logging\local\output\log_output;
use local_logging\local\output\log_output_stdout;
use local_logging\local\util;
use Mockery;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/logging/tests/lib/adler_testcase.php');

class logger_test extends adler_testcase {
    public function provide_test_all_levels_data() {
        return [
            'trace' => [
                'level_name' => 'TRACE',
                'level_int' => util::LEVEL_TRACE,
            ],
            'debug' => [
                'level_name' => 'DEBUG',
                'level_int' => util::LEVEL_DEBUG,
            ],
            'info' => [
                'level_name' => 'INFO',
                'level_int' => util::LEVEL_INFO,
            ],
            'warning' => [
                'level_name' => 'WARNING',
                'level_int' => util::LEVEL_WARNING,
            ],
            'error' => [
                'level_name' => 'ERROR',
                'level_int' => util::LEVEL_ERROR,
            ]
        ];
    }

    /**
     * @dataProvider provide_test_all_levels_data
     */
    public function test_all_levels($level_name, $level_int) {
        $mockOutput = Mockery::mock(log_output::class);
        $mockOutput->shouldReceive('output')
            ->once()
            ->with('Test message', $level_int, 'testcomponent', 'testtitle', Mockery::type('int'), null);
        di::set(log_output::class, $mockOutput);

        global $CFG;
        $CFG->local_logging_minloglevel = $level_name;

        // Create a logger instance.
        $logger = new logger('testcomponent', 'testtitle');

        // Use the logger to log a message.
        $logger->{$level_name}('Test message');
    }

    public function test_log_info() {
        $mockOutput = Mockery::mock(log_output_stdout::class);
        $mockOutput->shouldReceive('output')
            ->once()
            ->with('Test info message', util::LEVEL_INFO, 'testcomponent', 'testtitle', Mockery::type('int'), null);
        di::set(log_output::class, $mockOutput);

        global $CFG;
        $CFG->local_logging_minloglevel = 'TRACE';

        // Create a logger instance.
        $logger = new logger('testcomponent', 'testtitle');

        // Use the logger to log an info message.
        $logger->info('Test info message');
    }

    public function test_log_info_below_minloglevel() {
        $mockOutput = Mockery::mock(log_output_stdout::class);
        $mockOutput->shouldReceive('output')
            ->never();
        di::set(log_output::class, $mockOutput);

        global $CFG;
        $CFG->local_logging_minloglevel = 'ERROR';

        // Create a logger instance.
        $logger = new logger('testcomponent', 'testtitle');

        // Use the logger to log an info message.
        $logger->info('Test info message');
    }
}
