<?php
copy("./index.php", "$buildDir/index.php");
file_put_contents("$buildDir/.htaccess", "
## .htaccess for natribu-next
Options -Indexes -MultiViews +FollowSymLinks
AddDefaultCharset UTF-8
ServerSignature Off
FileETag none

<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteRule ^static($|/) - [L]
	RewriteRule ^(.+)$ /index.php?p=$1 [L]
</IfModule>

Header add Service-Worker-Allowed /
");

?>