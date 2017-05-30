<?php


$urls = [
    'https://www.livespace.io/pl/',
    'https://www.google.pl/',
    'https://www.amazon.com/',
    'https://www.wp.pl/'
];

$mh = curl_multi_init();
foreach ($urls as $key => $value){
    $ch[$key] = curl_init($value);
    curl_setopt($ch[$key], CURLOPT_NOBODY, true);
    curl_setopt($ch[$key], CURLOPT_HEADER, true);
    curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch[$key], CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch[$key], CURLOPT_SSL_VERIFYHOST, false);

    curl_multi_add_handle($mh,$ch[$key]);
}

do {
    curl_multi_exec($mh, $running);
    curl_multi_select($mh);
} while ($running > 0);

foreach(array_keys($ch) as $key){
    echo curl_getinfo($ch[$key], CURLINFO_HTTP_CODE);
    echo curl_getinfo($ch[$key], CURLINFO_EFFECTIVE_URL);
    echo "\n";

    curl_multi_remove_handle($mh, $ch[$key]);
}

curl_multi_close($mh);