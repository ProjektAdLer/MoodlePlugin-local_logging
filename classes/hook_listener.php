<?php

namespace local_logging;

use core\di;
use core\hook\di_configuration;
use local_logging\local\output\log_output;
use local_logging\local\output\log_output_db;
use local_logging\local\output\log_output_mtrace;
use local_logging\local\output\log_output_stdout;

class hook_listener {
    public static function inject_dependencies(di_configuration $hook): void {
        $hook->add_definition(
            id: log_output::class,
            definition: function (): log_output {
                return di::get(log_output_mtrace::class);
//                if (defined('CLI_SCRIPT') || defined('PHPUNIT_TEST')) {
//                    return new log_output_stdout();
//                    return di::get(log_output_mtrace::class);
//                } else {
//                    return di::get(log_output_db::class);
//                }
            }
        );
    }
}