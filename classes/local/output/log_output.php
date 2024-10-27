<?php

namespace local_logging\local\output;

use dml_exception;

interface log_output {
    /**
     * @throws dml_exception
     */
    public function output(string $message, int $level, string $component, string $title, int $time, ?int $user_id): void;
}