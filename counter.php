<?php
define("MEMCACHE_HOST", "localhost");
define("MEMCACHE_POST", 11211);

$mc = new Memcache;
$mc->connect(MEMCACHE_HOST, MEMCACHE_POST) or die();
echo $mc->increment("counter");
?>