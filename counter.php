<?
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
