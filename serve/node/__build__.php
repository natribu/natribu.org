<?php
file_put_contents("$buildDir/package.json", json_encode([
	"name" => "natribu-next-build",
	"version" => "1.0.0-rc".time(),
	"private" => true,
	"main" => "app.js",
	"scripts" => ["test" => "exit 0"]
], JSON_PRETTY_PRINT));

copy("./app.js", "$buildDir/app.js");
if(!$production){
	copy("./localhost.crt", "$buildDir/cert.pem");
	copy("./localhost.key", "$buildDir/key.pem");
}
?>