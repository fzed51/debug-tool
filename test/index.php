<?php

include __DIR__ . "/../vendor/autoload.php";

include __DIR__ . "/include.php";

function test_trace()
{
    trace('message');
    trace('debug', 'debug message');
    trace('notice', 'notice message');
    trace('warning', 'warning message');
    trace('error', 'error message');
}

function test_dd()
{
    $x = [(object) ["x" => 1]];
    fn_inc($x);
}

echo "test_trace" . PHP_EOL;
test_trace();
echo "test_dd" . PHP_EOL;
test_dd();
