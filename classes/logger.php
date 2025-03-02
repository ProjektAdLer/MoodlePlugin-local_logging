<?php

namespace local_logging;

use core\di;
use dml_exception;
use local_logging\local\output\log_output;
use local_logging\local\util;

defined('MOODLE_INTERNAL') || die();

class logger {
    private string $component;
    private string $title;
    private int $minLoglevel;

    public function __construct($component, $title) {
        global $CFG;

        $this->component = $component;
        $this->title = $title;
        $this->minLoglevel = util::convertLogLevelStringToInt($CFG->local_logging_minloglevel ?? 'WARNING');
    }

    /**
     * @throws dml_exception
     */
    private function log(int $level, string $message): void {
        global $USER;

        if ($level < $this->minLoglevel) {
            return;
        }

        $user_id = $USER?->id ?? null;
        di::get(log_output::class)->output($message, $level, $this->component, $this->title, time(), $user_id);
    }

    /**
     * @throws dml_exception
     */
    public function trace($message): void {
        $this->log(util::LEVEL_TRACE, $message);
    }

    /**
     * @throws dml_exception
     */
    public function debug($message): void {
        $this->log(util::LEVEL_DEBUG, $message);
    }

    /**
     * @throws dml_exception
     */
    public function info($message): void {
        $this->log(util::LEVEL_INFO, $message);
    }

    /**
     * @throws dml_exception
     */
    public function warning($message): void {
        $this->log(util::LEVEL_WARNING, $message);
    }

    /**
     * @throws dml_exception
     */
    public function error($message): void {
        $this->log(util::LEVEL_ERROR, $message);
    }
}
