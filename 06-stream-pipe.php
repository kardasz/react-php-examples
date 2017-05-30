<?php

require __DIR__ . '/vendor/autoload.php';

use React\EventLoop\Factory;
use React\Stream\ReadableResourceStream;
use React\Stream\WritableResourceStream;

$loop = Factory::create();
$stdout = new WritableResourceStream(STDOUT, $loop);
$stdin = new ReadableResourceStream(STDIN, $loop);
$stdin->pipe($stdout);

echo "I'm not blocked!\n";
$loop->addPeriodicTimer(1, function () {
    $memory = memory_get_usage() / 1024;
    $formatted = number_format($memory, 3).'K';
    echo "Current memory usage: {$formatted}\n";
});
echo "I'm not blocked too!\n";

$loop->run();