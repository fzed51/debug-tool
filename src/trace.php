<?php

/**
 * @author Fabien Sanchez
 * 2019-09-30 10:28
 */

function trace($level, $message = '')
{

    if (!defined('TRACE_FILE')) {
        $trace_file = './trace_' . date('Ymd') . '.log';
    } else {
        $trace_file = TRACE_FILE;
    }
    if (!defined('TRACE_MAX_LEVEL')) {
        $trace_max_level = 4;
    } else {
        $trace_max_level = (int) TRACE_MAX_LEVEL;
    }
    if (!defined('TRACE_ACCEPT_EOL')) {
        $trace_accept_eol = false;
    } else {
        $trace_accept_eol = (bool) TRACE_ACCEPT_EOL;
    }

    $_level = [];
    $_level[0] = 'ERROR';
    $_level['ERROR'] = 0;
    $_level[1] = 'WARNING';
    $_level['WARNING'] = 1;
    $_level[2] = 'NOTICE';
    $_level['NOTICE'] = 2;
    $_level[3] = 'DEBUG';
    $_level['DEBUG'] = 3;

    if ($message ===  '') {
        $message = $level;
        $level = 2;
    }

    if (is_string($level)) {
        $level = strtoupper($level);
    }
    if (!isset($_level[$level])) {
        $level = 2;
    }
    if (!is_int($level)) {
        $level = $_level[$level];
    }
    if ($trace_max_level < $level) {
        return;
    }

    try {
        $handle = fopen($trace_file, 'a+');
        if (!$trace_accept_eol) {
            $message = str_ireplace(
                ["\r\n", "\r", "\n", PHP_EOL],
                '§',
                $message
            );
        }
        $maintenant = (new DateTime)->format(DATE_ATOM);
        $fullMessage = sprintf(
            '%s [%s] %s' . PHP_EOL,
            $maintenant,
            $_level[$level],
            $message
        );
        fwrite($handle, $fullMessage);
    } finally {
        if ($handle !== false) {
            fclose($handle);
        }
    }
}
