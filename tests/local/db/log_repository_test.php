<?php

namespace local_logging\local\db;

use core\di;
use local_logging\lib\adler_testcase;

global $CFG;
require_once($CFG->dirroot . '/local/logging/tests/lib/adler_testcase.php');


class log_repository_test extends adler_testcase {
    public function test_count() {
        $this->assertEquals(0, di::get(log_repository::class)->count());
        $this->getDataGenerator()->get_plugin_generator('local_logging')->create_log();
        $this->assertEquals(1, di::get(log_repository::class)->count());
    }

    public function test_get_records_range() {
        for ($i = 0; $i < 4; $i++) {
            $this->getDataGenerator()->get_plugin_generator('local_logging')->create_log([
                'message' => 'Test message ' . $i,
            ]);
        }

        $records = di::get(log_repository::class)->get_records_range(1, 2, 'id ASC');

        $this->assertCount(2, $records);
        $this->assertEquals('Test message 1', array_shift($records)->message);
        $this->assertEquals('Test message 2', array_shift($records)->message);
    }

    public function test_delete() {
        $log = $this->getDataGenerator()->get_plugin_generator('local_logging')->create_log();
        $this->assertEquals(1, di::get(log_repository::class)->count());
        di::get(log_repository::class)->delete($log->id);
        $this->assertEquals(0, di::get(log_repository::class)->count());
    }
}