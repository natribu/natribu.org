<?php
$indexPage = <<<EOD
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>НАХУЙ-Landing</title>
		<meta http-equiv="refresh" content="3;url=ru/"/>
	</head>
	<body>
		Please wait, you're being told to...<br>
		Подождите, вас посылают...<br>
		<a href="en/">Click here if nothing happens</a><br>
		<a href="ru/">Нажмите сюда если ничего не происходит</a>
		<script>
			var l = __LOCALES__;
			for(var i = 0;i <= l.length; i++){
				if(~navigator.languages.indexOf(l[i])){
					location.replace(l[i] + "/");
					break;
				}
			}
		</script>
	</body>
</html>
EOD;
try {
	$locales = [];
	foreach(scandir($buildDir) as $dir) {
		if($dir === "static") continue;
		foreach(scandir($dir) as $file) {
			if(substr($file, -5) !== ".html") continue;
			$path = $buildDir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $file;
			file_put_contents($path, str_replace("static/", "../static/", file_get_contents($path)));
		}
		$locales[] = $dir;
	}
	file_put_contents(
		"$buildDir/index.html",
		str_replace("__LOCALES__", json_encode($locales), $indexPage)
	);
} catch(Exception $e) {
	$__buildError__ = $e;
}
?>