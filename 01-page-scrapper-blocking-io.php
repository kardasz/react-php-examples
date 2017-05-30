<?php

require __DIR__ . '/vendor/autoload.php';

$urls = [
    'https://www.livespace.io/pl/',
    'https://www.google.pl/',
    'https://www.amazon.com/',
    'https://www.wp.pl/'
];

foreach ($urls as $url) {
    $response = file_get_contents(
        $url
    );
}