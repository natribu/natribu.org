<?php
error_reporting(E_ALL & ~E_NOTICE);
require 'vendor/autoload.php';
require 'natribu.php';

$buildDir = "build/";
$options = [];
foreach(array_slice($argv, 1) as $opt){
	if(substr($opt, 0, 2) === "--"){
		$options[substr($opt, 2)] = true;
	}else{
		$buildDir = $opt;
	}
}
if($argc === 1 || $options["help"]){
	echo "Usage: php ./build.php [buildDir] [--serveDst]". PHP_EOL;
	echo "   php ./build.php --node buildNode/". PHP_EOL;
	echo "   php ./build.php build/ --default". PHP_EOL;
	echo "   php ./build.php build/". PHP_EOL;
	echo "   php ./build.php --help". PHP_EOL;
	echo PHP_EOL;
	echo "   --help    Show this help". PHP_EOL;
	echo PHP_EOL;
	echo "   Build destinations:". PHP_EOL;
	echo "   --apache  Apache / PHP 5+ setup [default]". PHP_EOL;
	echo "   --node    An Node.js server". PHP_EOL;
	//echo "   --ngnix Ngnix / PHP 5+ setup". PHP_EOL;
	//echo "   --gae Google App Engine / PHP 5". PHP_EOL;
	return;
}

function rcopy($src, $dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while(($file = readdir($dir))) {
		if(($file !== ".") && ($file != "..")) {
			$srcFile = $src . DIRECTORY_SEPARATOR . $file;
			$dstFile = $dst . DIRECTORY_SEPARATOR . $file;
			if(is_dir($srcFile)) {
				$this->rcopy($srcFile, $dstFile);
			} else {
				copy($srcFile, $dstFile);
			}
		}
	}
	closedir($dir);
}

function rmdir_recursive($dir) {
	if(!file_exists($dir)){	return true; }
	if(!is_dir($dir)) { return unlink($dir); }
	foreach(scandir($dir) as $item) {
		if($item == '.' || $item == '..') { continue; }
		if(!rmdir_recursive($dir . DIRECTORY_SEPARATOR . $item)){ return false; }
	}
	return rmdir($dir);
}

function color($string, $colorCode = "0;30") {
	return "\033[${colorCode}m$string\033[0m". PHP_EOL;
}

try {
	$timer = microtime(true);
	echo "Building in $buildDir...". PHP_EOL;
	if(is_dir($buildDir)){
		echo "Clearing $buildDir...". PHP_EOL;
		rmdir_recursive($buildDir);
	}
	if(!is_dir($buildDir) && !mkdir($buildDir, null, true)){
		throw new Exception("Build directory $buildDir is cannot be created");
	}
	$buildDir = realpath($buildDir);
	
	echo "Building pages...". PHP_EOL;
	$nahui = new NatribuNext\Engine();
	foreach($nahui->locales as $localeId => $localeData) {
		mkdir($buildDir. DIRECTORY_SEPARATOR .$localeId, null, true);
		
		foreach($localeData as $pageId => $_) {
			if($pageId === "__meta__") continue;
			echo "* Building ${localeId}/${pageId}.html". PHP_EOL;

			if(!file_put_contents(
				implode(DIRECTORY_SEPARATOR, [$buildDir, $localeId, "$pageId.html"]),
				$nahui->render($pageId, $localeId)
			)) throw new Exception("Failed to save $buildDir/$localeId/$pageId.html");
		}
	}

	echo "Copying static files...". PHP_EOL;
	rcopy("static/", "$buildDir/static");

	echo "Preparing app for serve destination...". PHP_EOL;
	if($options["node"]) {
		file_put_contents("$buildDir/package.json", json_encode([
			"name" => "natribu-next-build",
			"version" => "1.0.0-rc".time(),
			"private" => true,
			"main" => "app.js",
			"scripts" => ["test" => "exit 0"]
		], JSON_PRETTY_PRINT));
		rcopy("serve/node", $buildDir);
	} else {
		if(!$options["apache"]){
			echo color("Serve destination not specified, using default", "0;33");
		}
		rcopy("serve/apache", $buildDir);
	}

	printf(color("Build success! Time passed: %dms", "1;32"), (microtime(true) - $timer)*1000);
} catch(Exception $e) {
	echo color("Exception occured: $e", "1;31");
}
?>