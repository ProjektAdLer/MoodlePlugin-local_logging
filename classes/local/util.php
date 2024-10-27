<?php

namespace local_logging\local;

class util {
    const LEVEL_TRACE = 100;
    const LEVEL_DEBUG = 200;
    const LEVEL_INFO = 300;
    const LEVEL_WARNING = 400;
    const LEVEL_ERROR = 500;

    public static function convertLogLevelToString(int $level): string {
        $levels = [
            self::LEVEL_TRACE => 'TRACE',
            self::LEVEL_DEBUG => 'DEBUG',
            self::LEVEL_INFO => 'INFO',
            self::LEVEL_WARNING => 'WARNING',
            self::LEVEL_ERROR => 'ERROR',
        ];

        return strtoupper($levels[$level] ?? 'UNKNOWN');
    }


    public static function convertLogLevelStringToInt (string $level): int {
        $levels = [
            'TRACE' => self::LEVEL_TRACE,
            'DEBUG' => self::LEVEL_DEBUG,
            'INFO' => self::LEVEL_INFO,
            'WARNING' => self::LEVEL_WARNING,
            'ERROR' => self::LEVEL_ERROR,
        ];

        return $levels[strtoupper($level)] ?? self::LEVEL_WARNING;
    }
}