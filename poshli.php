<?php // случайное число

$memcache = class_exists('Memcached') ? new Memcached : null;
if (!$memcache) exit;
$memcache->addServer('127.0.0.1', 11211);

$lang=$_GET['lang'] ?? '';
if (!preg_match('/^[a-z0-9_]+$/i', $lang) || !file_exists(__DIR__ . '/lang/' . $lang . '.json')) exit;
$ask = intval($_GET['ask'] ?? 0);
$old = intval($_GET['old'] ?? 0);

$count = $memcache->get('count_na_' . $lang);
if ($memcache->getResultCode() !== Memcached::RES_SUCCESS) exit;
$c = intval($count);

$s="setTimeout(\"inject('/poshli.php?lang=".$lang."&ask=".(++$ask)."&old=".$c."')\",10000);
idd('counter').style.color='red'; setTimeout(\"idd('counter').style.color='black';\",800);";

if($old&&$c!=$old) $s.="zabil('counter','$c');";

header('Content-Type: application/x-javascript');
die($s);

?>
