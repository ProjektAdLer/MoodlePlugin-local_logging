<?php

namespace local_logging\local\output;

use core\task\logmanager;
use local_logging\local\util;

class log_output_to_default_outputs implements log_output {
    public function output(string $message, int $level, string $component, string $title, int $time, ?int $user_id): void {
        $formatted_date = date('Y-m-d H:i:s', $time);
        $formatted_loglevel = util::convertLogLevelToString($level);
        $formatted_uid = $user_id ?? 'none';

        $formatted_log_message = "[$formatted_date] $formatted_loglevel (uid: $formatted_uid) $component/$title: $message";

        if (defined('STDOUT') && !PHPUNIT_TEST && !defined('BEHAT_TEST')) {
            // this case is taken from mtrace
            if ($output = logmanager::add_line($formatted_log_message . PHP_EOL)) {
                fwrite(STDOUT, $output);
            }
        } else if (defined('PHPUNIT_TEST') && PHPUNIT_TEST || defined('BEHAT_TEST') && BEHAT_TEST) {
            echo $formatted_log_message . PHP_EOL;
        } else {
            error_log($formatted_log_message);
        }
    }
}