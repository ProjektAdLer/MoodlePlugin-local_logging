<?php

namespace local_logging\local\db;

use dml_exception;

class log_repository extends base_repository {
    /**
     * @throws dml_exception
     */
    public function count(): int {
        return $this->db->count_records('local_logging_log');
    }

    /**
     * @throws dml_exception
     */
    public function get_records_range(int $start, int $end, string $sort): array {
        return $this->db->get_records('local_logging_log', null, $sort, '*', $start, $end);
    }

    /**
     * @throws dml_exception
     */
    public function delete(int $id): void {
        $this->db->delete_records('local_logging_log', ['id' => $id]);
    }
}