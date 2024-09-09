<?php
namespace local_logging;

use dml_exception;
use stdClass;

defined('MOODLE_INTERNAL') || die();

// todo: user id
// TODO: in case of cli script, output to stdout
// TODO: automatically log all exceptions
// - https://stackoverflow.com/a/27238667

class logger {
    private String $component;
    private String $title;
    private int $minLoglevel;

    const LEVEL_TRACE = 100;
    const LEVEL_DEBUG = 200;
    const LEVEL_INFO = 300;
    const LEVEL_WARNING = 400;
    const LEVEL_ERROR = 500;

    public function __construct($component, $title) {
        global $CFG;
        $this->component = $component;
        $this->title = $title;
        $this->minLoglevel = $this->parseLogLevel($CFG->local_logging_minloglevel ?? 'WARNING');
    }

    private function parseLogLevel($level): int {
        $levels = [
            'TRACE' => self::LEVEL_TRACE,
            'DEBUG' => self::LEVEL_DEBUG,
            'INFO' => self::LEVEL_INFO,
            'WARNING' => self::LEVEL_WARNING,
            'ERROR' => self::LEVEL_ERROR,
        ];

        return $levels[strtoupper($level)] ?? self::LEVEL_WARNING;
    }

    /**
     * @throws dml_exception
     */
    private function log($level, $message): void {
        if ($level < $this->minLoglevel) {
            return;
        }

        if (defined('CLI_SCRIPT') || defined('CLI_SCRIPT')) {
            echo '[' . date('Y-m-d H:i:s') . '] ' . strtoupper(array_search($level, [
                    self::LEVEL_TRACE => 'TRACE',
                    self::LEVEL_DEBUG => 'DEBUG',
                    self::LEVEL_INFO => 'INFO',
                    self::LEVEL_WARNING => 'WARNING',
                    self::LEVEL_ERROR => 'ERROR',
                ])) . ' ' . $this->component . ' - ' . $this->title . ': ' . $message . PHP_EOL;
        } else {
            global $DB;
            $record = new stdClass();
            $record->logdate = time();
            $record->level = $level;
            $record->component = $this->component;
            $record->title = $this->title;
            $record->message = $message;

            $DB->insert_record('local_logging_log', $record);
        }
    }

    /**
     * @throws dml_exception
     */
    public function trace($message): void {
        $this->log(self::LEVEL_TRACE, $message);
    }

    /**
     * @throws dml_exception
     */
    public function debug($message): void {
        $this->log(self::LEVEL_DEBUG, $message);
    }

    /**
     * @throws dml_exception
     */
    public function info($message): void {
        $this->log(self::LEVEL_INFO, $message);
    }

    /**
     * @throws dml_exception
     */
    public function warning($message): void {
        $this->log(self::LEVEL_WARNING, $message);
    }

    /**
     * @throws dml_exception
     */
    public function error($message): void {
        $this->log(self::LEVEL_ERROR, $message);
    }
}
