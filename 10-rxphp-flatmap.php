<?php

require __DIR__ . '/vendor/autoload.php';

use React\EventLoop\Factory;
use Rx\Scheduler;

$loop = Factory::create();
Scheduler::setDefaultFactory(function () use ($loop) {
    return new Scheduler\EventLoopScheduler($loop);
});
register_shutdown_function(function () use ($loop) {
    $loop->run();
});



$observable = Rx\Observable::range(1, 2);
$observable
    ->flatMap(function ($value) {
        return Rx\Observable::range($value, 2);
    })->subscribe(
        function ($x) {
            echo 'Next: ', $x, PHP_EOL;
        },
        function (Exception $ex) {
            echo 'Error: ', $ex->getMessage(), PHP_EOL;
        },
        function () {
            echo 'Completed', PHP_EOL;
        }
    );
