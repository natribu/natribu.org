<?php

/* Этот файл — часть сайта НАХУЙ <http://natribu.org/>.
 * Copyright 2004–2016 Евгений Ненаглядов
 *
 * Сайт НАХУЙ — свободная программа: вы можете перераспространять его и/или
 * изменять его на условиях Афферо Стандартной общественной лицензии GNU в том
 * виде, в каком она была опубликована Фондом свободного программного
 * обеспечения; либо версии 3 лицензии, либо (по вашему выбору) любой более
 * поздней версии.
 *
 * Сайт НАХУЙ распространяется в надежде, что он будет полезным,
 * но БЕЗО ВСЯКИХ ГАРАНТИЙ; даже без неявной гарантии ТОВАРНОГО ВИДА
 * или ПРИГОДНОСТИ ДЛЯ ОПРЕДЕЛЕННЫХ ЦЕЛЕЙ. Подробнее см. в Афферо Стандартной
 * общественной лицензии GNU.
 *
 * Вы должны были получить копию Афферо Стандартной общественной лицензии GNU
 * вместе с этой программой. Если это не так, см.
 * <https://www.gnu.org/licenses/agpl.html>.
 */

// случайное число

$memcache=function_exists('memcache_connect'); if(!$memcache) exit;
$memcache=memcache_connect('localhost',ini_get('memcache.default_port'));

$lang=$_GET['lang'];
$ask=intval($_GET['ask']);
$old=intval($_GET['old']);

$c=intval(memcache_get($memcache,'count_na_'.$lang));

$s="setTimeout(\"inject('/poshli.php?lang=".$lang."&ask=".(++$ask)."&old=".$c."')\",10000);
idd('counter').style.color='red'; setTimeout(\"idd('counter').style.color='black';\",800);";

if($old&&$c!=$old) $s.="zabil('counter','$c'); mkdiv(\"<object width=1 height=1><param name='movie' value='/swf/poshel.swf' /><param name='loop' value='false' /><embed src='/na/swf/poshel.swf' width='1' height='1' loop='false' type='application/x-shockwave-flash'></embed></object>\");";

header('Content-Type: application/x-javascript');
die($s);

?>
