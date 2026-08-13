<?php

$root = dirname(__DIR__);
$index = file_get_contents($root . '/index.php');
$polling = file_get_contents($root . '/poshli.php');
$failures = [];

foreach (['memcache_connect', 'memcache_get', 'memcache.default_port'] as $legacy_api) {
    if (strpos($index . $polling, $legacy_api) !== false) {
        $failures[] = 'Legacy API remains: ' . $legacy_api;
    }
}

foreach (['index.php' => $index, 'poshli.php' => $polling] as $file => $contents) {
    if (strpos($contents, "addServer('127.0.0.1', 11211)") === false) {
        $failures[] = $file . ' does not use the shared Memcached endpoint';
    }
}

if (strpos($polling, 'Memcached::RES_SUCCESS') === false) {
    $failures[] = 'Polling does not handle a failed Memcached read';
}

if ($failures) {
    fwrite(STDERR, implode("\n", $failures) . "\n");
    exit(1);
}

echo "Memcached polling tests passed.\n";
