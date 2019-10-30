<?php
error_reporting(E_ALL & ~E_NOTICE);
require 'vendor/autoload.php';
require 'natribu.php';

$options = [];
foreach(array_slice($argv, 1) as $opt){
	if(substr($opt, 0, 2) === "--"){
		list($k, $v) = explode("=", substr($opt, 2));
		$options[$k] = $v ?? true;
	}
}
$n = PHP_EOL;
if($argc === 1 || $options["help"]){
	echo "Usage: php ./build.php [--build=<dir>] [--serve=<dest>] [--prod]$n";
	echo "   php ./build.php --build=buildNode/ --serve=node$n";
	echo "   php ./build.php --build=build/ --prod$n";
	echo "   php ./build.php --help$n$n";
	echo "   --help          Show this help$n";
	echo "   --prod          Enable production mode$n";
	echo "   --build=<dir>   Build at specified directory$n";
	echo "   --serve=<dest>  Serve files for destination$n$n";
	echo "   Build destinations:$n";
	echo "   * apache  Apache / PHP 5+ setup [default]$n";
	echo "   * node    An Node.js server$n";
	echo "   * static  Static HTML pages$n";
	//echo "   * ngnix   Ngnix / PHP 5+ setup$n";
	//echo "   * gae     Google App Engine / PHP 5$n";
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
	return "\033[${colorCode}m$string\033[0m$n";
}

try {
	$buildDir = $options["build"] ?? "build/";
	$serveDest = $options["serve"] ?? "default";
	$production = $options["prod"] ?? false;
	if($production) {
		echo "! Production mode enabled$n";
	}
	$timer = microtime(true);
	echo "Building in $buildDir...$n";
	if(is_dir($buildDir)){
		echo "Clearing $buildDir...$n";
		rmdir_recursive($buildDir);
	}
	if(!is_dir($buildDir) && !mkdir($buildDir, null, true)){
		throw new Exception("Build directory $buildDir is cannot be created");
	}
	$buildDir = realpath($buildDir);
	
	echo "Building pages...$n";
	$nahui = new NatribuNext\Engine();
	foreach($nahui->locales as $localeId => $localeData) {
		mkdir($buildDir. DIRECTORY_SEPARATOR .$localeId, null, true);
		
		foreach($localeData as $pageId => $_) {
			if($pageId === "__meta__") continue;
			echo "* Building ${localeId}/${pageId}.html$n";

			if(!file_put_contents(
				implode(DIRECTORY_SEPARATOR, [$buildDir, $localeId, "$pageId.html"]),
				$nahui->render($pageId, $localeId)
			)) throw new Exception("Failed to save $buildDir/$localeId/$pageId.html");
		}
	}

	echo "Copying static files...$n";
	rcopy("static/", "$buildDir/static");

	echo "Preparing for serve destination...$n";
	if(!is_dir("serve/$serveDest")){
		if($production) {
			throw new Exception("Serve destination not supported");
		}
		$serveDest = "default";
		echo color("Serve destination not supported, using default", "0;33");
	}

	$GLOBALS["production"] = $production;
	$GLOBALS["buildDir"] = $buildDir;
	require "serve/$serveDest/__build__.php";

	printf(color("Build success! Time passed: %dms", "1;32"), (microtime(true) - $timer)*1000);
} catch(Exception $e) {
	echo color("Exception occured: $e", "1;31");
}
?>