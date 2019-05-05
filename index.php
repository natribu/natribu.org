<?php
if(strpos($_SERVER["request_url"], "static/") !== -1) {
    $path = realpath($_SERVER["request_url"]);
    if(strpos(dirname($path), "static/") === 0){
        readfile($path);
        exit();
    }
}

?>