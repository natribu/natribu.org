<?php
list($script, $lang, $human) = explode("/",$_SERVER['REQUEST_URI']);

if ($lang == "" || strlen($lang) > "3") {
	$human=$lang;
	$lang="ru";
}

if (!file_exists("lang/".$lang.".php")) {
	header("Location: http://natribu.org/"); exit();
}

//--- поехали

$u = poiskovik(); if($u) { $poiskovik=$u[1]; $text=$u[0]; }

include("counter.php");
$count = counter($lang);

$memcache = new Memcached;
$memcache->addServer('localhost',ini_get('memcache.default_port'));
$memcache->set("count_na_$lang",$count,600); // записать в memcache

$count="<span id=counter>$count</span>";

//--------------------

$kolnah = $_COOKIE["nah"]+1;
setcookie("nah",$kolnah,time()+86400*365, "/", ".natribu.org", 0);

// --- декодировать строку параметров:
eregi("([^%]*)%([^%]*)%([^%]*)", base64_decode(str_replace("-","/",$_SERVER["QUERY_STRING"]))."%", $userdata);

//--------------------
$codepage = "windows-1251";
include("lang/".$lang.".php");
if ($codepage=="")
	$codepage="windows-1251";
header("Content-Type: text/html; charset=".$codepage);

if($_GET)

?>
<html>
<head>
<title><?=$headpage?></title>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?=$codepage?>" />
</head>
<body bgcolor=white text=black background=http://natribu.org/fon1.jpg>
<?
if ($media) {

	//echo "<table width=100%><tr><td><i><font size=-2>$epigraph<img src=http://lleo.homeip.net:8081/cgi-bin/na_$lang width=1 height=1></font></i></td><td align=right>";
	//echo "<table width=100%><tr><td><i><font size=-2>$epigraph<img src=http://lleo.homeip.net:8081/na/na.php?lang=$lang></font></i></td><td align=right>";
	echo "<table width=100%><tr><td><i><font size=-2>$epigraph<img src=http://lleo.homeip.net:8081/cgi-bin/na?lang=$lang width=1 height=1></font></i></td><td align=right>";

	echo '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" WIDTH=130 HEIGHT=70>';
	echo '<PARAM NAME=movie VALUE="/swf/'.$media.'"><PARAM NAME=quality VALUE=high><PARAM NAME=bgcolor VALUE=#FFFFFF><PARAM NAME=loop VALUE=false>';
	echo '<EMBED src="/swf/'.$media.'" quality=high loop=false bgcolor=#FFFFFF WIDTH=130 HEIGHT=70 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED></OBJECT>';

	//echo '<object type="application/x-shockwave-flash" data="'.$media.'" width="1" height="1"><param name="movie" value="'.$media.'"></object>';

} else {

	echo "<p><i><font size=-2>".$epigraph."<img src=http://lleo.homeip.net:8081/cgi-bin/na_".$lang." width=1 height=1></font></i>";

}

echo "</td></tr></table>
<center><table width=70%><td valign=center><div align=justify>
<h1><center><p>".$head."<br><small>".$official_site.($userdata[1]?"<br><font size=+1 color=red><u>".$hello_you.$userdata[1]."</u></font>":"");

echo "<FORM><select name=lo onChange=\" {for (var i=0; i < this.length; i++){if (this.options[i].selected){top.window.location=this.options[i].value;break;} } }\">";

echo str_replace("/".$lang."/\">","/".$lang."/\"selected>",file_get_contents("select.txt"));
//echo file_get_contents("select.txt");
//include("national.php");


echo "</SELECT></FORM>
</small></center></h1>
<p><br><font color=red><b>".$oi_chto_eto."</b></font><p>".$zdes_raspolojeno."

<p><font color=red><b>".$chto_eto_znachit."</b></font><p>".$vas_poslali."

<p><font color=red><b>".$kak_eto_moglo."</b></font><p>".$vot_samye."
<ul><li>".str_replace("\n","</li><li>",$prichiny.($userdata[2]?"\n<font color=red><u>".$hello_noprichina.$userdata[2]."</u></font>":""))."</li></ul>

<p>";

if (!$u) {
	$poisk="";
}
echo str_replace("=POISK=",$poisk,$est_variant);

echo "<p><font color=red><b>".$chto_delat."</b></font><p>".$sovetuem."
<ul><li>".str_replace("\n","</li><li>",$sovety.($userdata[3]?"\n<font color=red><u>".$hello_nosovet.$userdata[3]."</u></font>":""))."</li></ul>";


if ($bottom_vernutsa.$bottom_izbrannoe.$bottom_start.$bottom_druga) {
	echo "<center>";
	if ($bottom_vernutsa) {
		echo "\n<input TYPE=\"BUTTON\" VALUE=\"".$bottom_vernutsa."\" onClick=\"window.alert('";
		echo str_replace("\\n##\\n","'); window.alert('",str_replace("\n","\\n",str_replace("я","\\я",$bottom_vernut)));
		echo "'); return true;\">";
		echo ' &nbsp; ';
	}
	if ($bottom_izbrannoe) {
		echo "\n<input TYPE=\"BUTTON\" VALUE=\"".$bottom_izbrannoe."\" onClick=\"window.alert('";
		echo str_replace("\\n##\\n","'); window.alert('",str_replace("\n","\\n",str_replace("я","\\я",$bottom_izbr)));
		echo "'); window.external.AddFavorite('http://natribu.org";
		if ($lang!="ru") {
			echo "/".$lang;
		}
		echo "','".$head."'); return true;\">";
		echo ' &nbsp; ';
	}
	if ($bottom_start) {
		echo "\n<input TYPE=\"BUTTON\" VALUE=\"".$bottom_start."\" onClick=\"window.alert('";
		echo str_replace("\\n##\\n","'); window.alert('",str_replace("\n","\\n",str_replace("я","\\я",$bottom_strt)));
		echo "'); window.external.AddFavorite('http://natribu.org";
		if ($lang!="ru") {
			echo "/".$lang;
		}
		echo "','".$head."'); return true;\">";
		echo ' &nbsp; ';
	}
	if ($bottom_druga) {
		echo "\n<input TYPE=\"BUTTON\" VALUE=\"".$bottom_druga."\" onClick=\"window.alert('";
		echo str_replace("\\n##\\n","'); window.alert('",str_replace("\n","\\n",str_replace("я","\\я",$bottom_drug)));
		echo "'); javascript:window.location.href='/";
		if ($lang!="ru") {
			echo $lang."/";
		}
		echo "editor' \">";
	}
	echo "</center>";
}
?>

<p><font color=red><b><?=$kak_mne_jit?></b></font>
<ul>
	<li><?=str_replace("\n","</li><li>", $zapomnite)?></li>
</ul>

<p><br>
<center><input TYPE="BUTTON" VALUE=" <?=$about?> "
	onClick="javascript:window.location.href='/about.php' "></center>
<p>
<table width=100%>
	<tr>
		<td>
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t44.1;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet' "+
"border='0' width='31' height='31'><\/a>")
//--></script><!--/LiveInternet-->
</td>
		<td align=right><font size=-1><?=$perevod?>&nbsp;<?=$perevodchik?></font>
		</td>
	</tr>
</table>

</td>
</table>

<?
if ($userdata[1].$userdata[2].$userdata[3]) {
	print "$otvetstvenno";
	//$dnevlog = fopen("log/stroki.log","a+");
	//fputs($dnevlog,"\n\n".$userdata[1]);
	//fputs($dnevlog,"\n".$userdata[2]);
	//fputs($dnevlog,"\n".$userdata[3]);
	//fclose($dnevlog);
}
?>

</center>

<script>
function inject (src){
	var s=document.createElement('script');
	s.setAttribute('type','text/javascript');
	s.setAttribute('src',src);
	var head=document.getElementsByTagName('head').item(0);
	head.insertBefore(s,head.firstChild);
}

function mkdiv (s){
	var div=document.createElement('DIV');
	div.innerHTML=s;
	var p=document.body;
	p.insertBefore(div, p.lastChild);
}
function idd (id) {
	return document.getElementById(id);
}
function zabil (id, s) {
	idd(id).innerHTML=s;
}

setTimeout("inject('/poshli.php?lang=<?=$lang?>&ask=0&old=0')",60000);

var Base64 = {

	// private property
	_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

	// public method for encoding
	encode : function (input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;

		input = Base64._utf8_encode(input);

		while (i < input.length) {

			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);

			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;

			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}

			output = output +
			this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
			this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

		}

		return output;
	},

	// public method for decoding
	decode : function (input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;

		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

		while (i < input.length) {

			enc1 = this._keyStr.indexOf(input.charAt(i++));
			enc2 = this._keyStr.indexOf(input.charAt(i++));
			enc3 = this._keyStr.indexOf(input.charAt(i++));
			enc4 = this._keyStr.indexOf(input.charAt(i++));

			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;

			output = output + String.fromCharCode(chr1);

			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}

		}

		output = Base64._utf8_decode(output);

		return output;

	},

	// private method for UTF-8 encoding
	_utf8_encode : function (string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";

		for (var n = 0; n < string.length; n++) {

			var c = string.charCodeAt(n);

			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}

		}

		return utftext;
	},

	// private method for UTF-8 decoding
	_utf8_decode : function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;

		while ( i < utftext.length ) {

			c = utftext.charCodeAt(i);

			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			}
			else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			}
			else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}

		}

		return string;
	}

}
qs = new String(document.location).split('?', 2)[1].replace(/\-/g, '/');
alert(qs);
//eregi("([^%]*)%([^%]*)%([^%]*)", base64_decode(str_replace("-","/",$_SERVER["QUERY_STRING"]))."%", $userdata);
</script>

</body>
</html>


<?
function poiskovik () {
	$u=parse_url($_SERVER["HTTP_REFERER"]);
	parse_str($u['query'],$outr);
	// GOOGLE
	if (ereg ("google.", $u["host"])) {
		$s[0]=iconv('utf-8','windows-1251',urldecode($outr['q']));
		$s[1]="Google";
	}
	// YANDEX-search
	if (ereg ("yandex.ru/yandsearch", $u["host"].$u["path"])) {
		$s[0]=urldecode($outr['text']);
		$s[1]="Yandex";
	}
	// YANDEX-yandpage
	if (ereg ("yandex.ru/yandpage", $u["host"].$u["path"])) {
		parse_str(urldecode($outr['qs']),$outr2);
		$s[0]=iconv('koi8-r','windows-1251',urldecode($outr2['text']));
		$s[1]="Yandex";
	}
	// RAMBLER
	if (ereg ("rambler.ru", $u["host"])) {
		$s[0]=trim(urldecode($outr['words']." ".$outr['old_q']));
		$k_koi=strlen(str_replace("-","",strtr($searchtext,"КГХЛЕОЗЫЭЪИЯЖЩЧБРТПМДЦЬСЮУНЙФШВА","--------------------------------")));
		$k_win=strlen(str_replace("-","",strtr($searchtext,"кгхлеозыэъияжщчбртпмдцьсюунйфшва","--------------------------------")));
		if ($k_koi < $k_win) $s[0]=iconv('cp1251','koi8-r',$s[0]);
		$s[1]="Rambler";
	}
	// GO.MAIL.RU
	if (ereg ("go.mail.ru/search", $u["host"].$u["path"])) {
    $s[0]=trim(urldecode($outr['q']." ".$outr['old_q']));
    $s[1]="Go.mail.ru";
}
return $s;
}
