<?php

require __DIR__ . '/vendor/autoload.php';

use React\EventLoop\Factory;
use React\Stream\ReadableResourceStream;
use React\Stream\WritableResourceStream;
use React\HttpClient\Client;
use React\HttpClient\Response;
use React\Promise;

$loop = Factory::create();
$stdout = new WritableResourceStream(STDOUT, $loop);
$stdin = new ReadableResourceStream(STDIN, $loop);
$stdin->pipe($stdout);

$client = new Client($loop);

$urls = [
    'https://www.livespace.io/pl/',
    'https://www.google.pl/',
    'https://www.amazon.com/',
    'https://www.wp.pl/'
];

$promises = [];
foreach ($urls as $url) {
    $deferred = new Promise\Deferred();
    $request = $client->request('GET', $url);

    $request->on('response', function (Response $response) use ($deferred, $url) {
        $response->on('data', function ($data) use ($url) {
            echo $url . " in progress\n";
        });

        $response->on('end', function () use ($deferred, $url) {
            echo $url . " resolved\n";
            $deferred->resolve($url);
        });
    });
    $request->end();
    $promises[] = $deferred->promise();
}

echo "I'm not blocked!\n";
Promise\race($promises)->then(function($url){
    echo $url . " wins the race!\n";
});
echo "I'm not blocked also!\n";

echo "I'm not blocked!\n";
$loop->addPeriodicTimer(0.2, function () {
    $memory = memory_get_usage() / 1024 / 1024;
    $formatted = number_format($memory, 3).'M';
    echo "Current memory usage: {$formatted}\n";
});
echo "I'm not blocked too!\n";

$loop->run();