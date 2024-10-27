<?php

global $CFG;

use core\uuid;


class local_logging_generator extends component_generator_base {
    public function create_log($data = [], bool $insert = true) {
        global $DB;
        $default_data = [
            'logdate' => time(),
            'message' => 'Test log message',
            'level' => 100,
            'component' => 'testcomponent',
            'title' => 'title',
            'user_id' => 2
        ];
        $data = array_merge($default_data, $data);
        $log = (object)$data;

        if ($insert) {
            $log->id = $DB->insert_record('local_logging_log', $log);
        }
        return $log;
    }
}
