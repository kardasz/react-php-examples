<?php

require __DIR__ . '/vendor/autoload.php';

use React\Promise;

$emiter = new \Evenement\EventEmitter();

$promises = [];

$deferred = new Promise\Deferred();
$emiter->on('send_email', function() use ($deferred) {
    // Make async request ...
    echo 'Sending email...'. PHP_EOL;
    $deferred->resolve('Email sent');
});
$promises[] = $deferred->promise();

$deferred = new Promise\Deferred();
$emiter->on('send_sms', function() use ($deferred) {
    // Make async request ...
    echo 'Sending sms...' . PHP_EOL;
    $deferred->resolve('Sms sent');
});
$promises[] = $deferred->promise();

echo "I'm not blocked!\n";

Promise\all($promises)->then(function($results){
    echo sprintf('[%s] All done', implode(', ', $results)) . PHP_EOL;
});

echo "I'm not blocked also!\n";

$emiter->emit('send_email');
$emiter->emit('send_sms');