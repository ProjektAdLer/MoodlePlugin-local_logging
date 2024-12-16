<?php

namespace local_logging\local\output;

use local_logging\local\util;

class log_output_mtrace implements log_output {
    public function output(string $message, int $level, string $component, string $title, int $time, ?int $user_id): void {
        mtrace(
            '[' . date('Y-m-d H:i:s', $time) . '] ' . util::convertLogLevelToString($level) . ' ' . $component . ' - ' . $title . ': ' . $message . PHP_EOL,
        );
    }
}