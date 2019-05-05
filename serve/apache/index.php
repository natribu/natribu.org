<?php
function guessLanguage() {
	foreach(array_multisort(
		array_map(
			function($v){return preg_split("/\s*;\s*q=/", $v);}, 
			preg_split("/\s*,\s*/", $_SERVER["HTTP_ACCEPT_LANGUAGE"])
		),
		SORT_DESC,
		SORT_NUMERIC
	) as $v){if(is_dir($v)) return $v;}
	return "ru";
}
$page = $_GET["p"];
$page = empty($page) ? "index" : $page;
$locale = $_COOKIE["lang"] ?? guessLanguage();
if($page == "setLocale"){
	$locale = $_GET["locale"] ?? "ru";
	$page = "index";
}
setcookie("locale", $locale);
readfile("$locale/$page.html");
?>