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

function counter ($lang) {

	mysql_connect('localhost', 'natribu', 'NahPass');
	mysql_select_db('natribu');
	//include($_SERVER["DOCUMENT_ROOT"]."/../lleo/mysql_.php"); //include($HOME."/lleo/mysql.php");


	//$lang="en";

	if (!mysql_num_rows(mysql_query("SELECT `lang` FROM nahui WHERE `lang`='".mysql_escape_string($lang)."'"))) {

		// вставить новый счетчик если не было
		mysql_query("INSERT INTO nahui
			(`lang`, `count`, `last_ip`)
			VALUES
			('".mysql_escape_string($lang)."','1','".mysql_escape_string($_SERVER["REMOTE_ADDR"])."')");
		//echo "\nвставлен новый счетчик для языка:".$lang;
	} else {
		// увеличить счетчик
		mysql_query("UPDATE nahui SET count=count+1,
			last_ip='".mysql_escape_string($_SERVER["REMOTE_ADDR"])."'
			WHERE `lang`='".mysql_escape_string($lang)."' AND last_ip!='".mysql_escape_string($_SERVER["REMOTE_ADDR"])."'");
	}
	// снять показания счетчика
	$sql = mysql_query("SELECT * FROM nahui WHERE `lang`='".mysql_escape_string($lang)."'");
	if (mysql_num_rows($sql) == 1) {
		$p = mysql_fetch_assoc($sql);
		$count = $p["count"];
		//	$last_ip = $p["last_ip"];
	}
	return $count;
}

function counter_get ($lang) {
	// сконнектиться
	mysql_connect('localhost', 'natribu', 'NahPass');
	mysql_select_db('natribu');
	// снять показания счетчика
	$sql = mysql_query("SELECT * FROM nahui WHERE `lang`='".mysql_escape_string($lang)."'");
	if (mysql_num_rows($sql) == 1) {
		$p = mysql_fetch_assoc($sql);
		$count = $p["count"];
		//	$last_ip = $p["last_ip"];
	}
	return $count;
}
