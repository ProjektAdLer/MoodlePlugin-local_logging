<?php
defined('MOODLE_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => 'local_logging\\task\\log_rotation_task',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '*',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    )
);
