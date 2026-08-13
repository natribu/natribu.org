<?php

function counter ($lang) {

	$db = mysqli_connect('localhost', 'natribu', 'NahPass');
	mysqli_select_db($db, 'natribu');
	//include($_SERVER["DOCUMENT_ROOT"]."/../lleo/mysql_.php"); //include($HOME."/lleo/mysql.php");


	//$lang="en";

	if (!mysqli_num_rows(mysqli_query($db, "SELECT `lang` FROM nahui WHERE `lang`='".mysqli_escape_string($db, $lang)."'"))) {

		// вставить новый счетчик если не было
		mysqli_query($db, "INSERT INTO nahui
			(`lang`, `count`, `last_ip`)
			VALUES
			('".mysqli_escape_string($db, $lang)."','1','".mysqli_escape_string($db, $_SERVER["REMOTE_ADDR"])."')");
		//echo "\nвставлен новый счетчик для языка:".$lang;
	} else {
		// увеличить счетчик
		mysqli_query($db, "UPDATE nahui SET count=count+1,
			last_ip='".mysqli_escape_string($db, $_SERVER["REMOTE_ADDR"])."'
			WHERE `lang`='".mysqli_escape_string($db, $lang)."' AND last_ip!='".mysqli_escape_string($db, $_SERVER["REMOTE_ADDR"])."'");
	}
	// снять показания счетчика
	$sql = mysqli_query($db, "SELECT * FROM nahui WHERE `lang`='".mysqli_escape_string($db, $lang)."'");
	if (mysqli_num_rows($sql) == 1) {
		$p = mysqli_fetch_assoc($sql);
		$count = $p["count"];
		//	$last_ip = $p["last_ip"];
	}
	return $count;
}

function counter_get ($lang) {
	// сконнектиться
	$db = mysqli_connect('localhost', 'natribu', 'NahPass');
	mysqli_select_db($db, 'natribu');
	// снять показания счетчика
	$sql = mysqli_query($db, "SELECT * FROM nahui WHERE `lang`='".mysqli_escape_string($db, $lang)."'");
	if (mysqli_num_rows($sql) == 1) {
		$p = mysqli_fetch_assoc($sql);
		$count = $p["count"];
		//	$last_ip = $p["last_ip"];
	}
	return $count;
}
