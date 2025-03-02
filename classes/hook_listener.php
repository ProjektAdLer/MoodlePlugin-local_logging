<?php

namespace local_logging;

use core\di;
use core\hook\di_configuration;
use local_logging\local\output\log_output;
use local_logging\local\output\log_output_to_default_outputs;

class hook_listener {
    public static function inject_dependencies(di_configuration $hook): void {
        $hook->add_definition(
            id: log_output::class,
            definition: function (): log_output {
                return di::get(log_output_to_default_outputs::class);
            }
        );
    }
}