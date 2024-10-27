<?php

namespace local_logging\local\output;

use dml_exception;
use moodle_database;
use stdClass;

class log_output_db implements log_output {
    private moodle_database $db;

    public function __construct(moodle_database $db = null) {
        global $DB;
        $this->db = $db ?? $DB;
    }

    /**
     * @throws dml_exception
     */
    public function output(string $message, int $level, string $component, string $title, int $time, ?int $user_id): void {
        $record = new stdClass();
        $record->message = $message;
        $record->level = $level;
        $record->component = $component;
        $record->title = $title;
        $record->logdate = $time;
        $record->user_id = $user_id;
        $this->db->insert_record('local_logging_log', $record);
    }
}