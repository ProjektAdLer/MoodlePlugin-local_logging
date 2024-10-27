<?php

namespace local_logging;

use core\hook\di_configuration;
use local_logging\local\output\log_output;
use local_logging\local\output\log_output_db;
use local_logging\local\output\log_output_stdout;

class hook_listener {
    public static function inject_dependencies(di_configuration $hook): void {
        $hook->add_definition(
            id: log_output::class,
            definition: function (): log_output {
                if (defined('CLI_SCRIPT') || defined('PHPUNIT_TEST')) {
                    return new log_output_stdout();
                } else {
                    return new log_output_db();
                }
            }
        );
    }
}