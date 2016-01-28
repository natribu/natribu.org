<?

die("figvam");

echo "<pre>";


include($_SERVER["DOCUMENT_ROOT"]."/../lleo/mysql.php"); //include($HOME."/lleo/mysql.php");


/*
count_set("ru","3202623","82.162.50.218");
count_set("en","52987","70.82.170.89");
count_set("ua","39488","72.30.252.172");
count_set("by","20711","82.207.26.175");
count_set("de","8943","84.149.154.193");
count_set("ee","6330","88.83.192.67");
count_set("eo","6879","66.249.72.233");
count_set("es","4718","194.6.196.18");
count_set("fi","404","82.193.96.235");
count_set("fr","2588","194.44.243.65");
count_set("he","22","85.141.179.17");
count_set("hy","74","83.217.229.146");
count_set("il","319","81.26.139.149");
count_set("la","3939","195.38.53.69");
count_set("lat","834","194.44.243.65");
count_set("lt","692","88.83.192.67");
count_set("lv","22785","84.237.155.74");
count_set("md","158","85.29.201.205");
count_set("nr","995","194.44.243.65");
count_set("pd","3685","81.19.66.38");
count_set("am","211","194.44.243.65");
count_set("uz","520","194.44.243.65");
count_set("editor","3445","217.212.224.146");
count_set("wap","12","217.118.83.1");

*/
echo "
</pre>";


function count_set($lang,$count,$last_ip) {

//$lang=trim($lang);
//$count=trim($count);
//$last=trim($last);

echo "

".$lang.": ".$count." IP:".$last_ip;

//if (!mysql_num_rows(mysql_query("SELECT `lang` FROM nahui WHERE `lang`='".mysql_escape_string($lang)."'"))) {

// вставить новый счетчик если не было
mysql_query("INSERT INTO nahui (`lang`, `count`, `last_ip`) VALUES
('".mysql_escape_string($lang)."','".mysql_escape_string($count)."','".mysql_escape_string($last_ip)."')");

echo "
".$lang." - выставлен: ".$count." IP:".$last_ip;

/*

} 


else {


// снять показания счетчика
$sql = mysql_query("SELECT * FROM nahui WHERE `lang`='".$lang."'");
if (mysql_num_rows($sql) == 1) {
	$p = mysql_fetch_assoc($sql);
	$ncount = $p["count"];
	$nlast_ip = $p["last_ip"];
}

echo "
!".$lang."=".$ncount." (IP:".$nlast_ip.") итого=".($count+$ncount);

// увеличить счетчик
mysql_query("UPDATE nahui SET count=".$ncount." WHERE `lang`='".$lang."'");
}
*/
}

?>
