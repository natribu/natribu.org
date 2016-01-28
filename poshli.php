<?php // случайное число

$memcache=function_exists('memcache_connect'); if(!$memcache) exit;
$memcache=memcache_connect('localhost',ini_get('memcache.default_port'));

$lang=$_GET['lang'];
$ask=intval($_GET['ask']);
$old=intval($_GET['old']);

$c=intval(memcache_get($memcache,'count_na_'.$lang));

$s="setTimeout(\"inject('/na/poshli.php?lang=".$lang."&ask=".(++$ask)."&old=".$c."')\",10000);
idd('counter').style.color='red'; setTimeout(\"idd('counter').style.color='black';\",800);";

if($old&&$c!=$old) $s.="zabil('counter','$c'); mkdiv(\"<object width=1 height=1><param name='movie' value='http://lleo.aha.ru/na/swf/poshel.swf' /><param name='loop' value='false' /><embed src='/na/swf/poshel.swf' width='1' height='1' loop='false' type='application/x-shockwave-flash'></embed></object>\");";

header('Content-Type: application/x-javascript');
die($s);

?>