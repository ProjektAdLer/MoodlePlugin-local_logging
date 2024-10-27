<?php

use core\hook\di_configuration;
use local_logging\hook_listener;

$callbacks = [
    [
        'hook' => di_configuration::class,
        'callback' => hook_listener::class . '::inject_dependencies',
    ],
];