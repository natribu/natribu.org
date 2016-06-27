<?php

/* Этот файл — часть сайта НАХУЙ <http://natribu.org/>.
 * Copyright 2004–2016 Евгений Ненаглядов
 *
 * Сайт НАХУЙ — свободная программа: вы можете перераспространять его и/или
 * изменять его на условиях Афферо Стандартной общественной лицензии GNU в том
 * виде, в каком она была опубликована Фондом свободного программного
 * обеспечения; либо версии 3 лицензии, либо (по вашему выбору) любой более
 * поздней версии.
 *
 * Сайт НАХУЙ распространяется в надежде, что он будет полезным,
 * но БЕЗО ВСЯКИХ ГАРАНТИЙ; даже без неявной гарантии ТОВАРНОГО ВИДА
 * или ПРИГОДНОСТИ ДЛЯ ОПРЕДЕЛЕННЫХ ЦЕЛЕЙ. Подробнее см. в Афферо Стандартной
 * общественной лицензии GNU.
 *
 * Вы должны были получить копию Афферо Стандартной общественной лицензии GNU
 * вместе с этой программой. Если это не так, см.
 * <https://www.gnu.org/licenses/agpl.html>.
 */

$lang = explode('/', explode('?', ltrim($_SERVER['REQUEST_URI'], '/'))[0])[0] ?: 'ru';
if (!preg_match('/^[a-z0-9_]+$/i', $lang) || !file_exists('lang/' . $lang . '.json')) {
    header('Location: /');
    exit();
}

//--- поехали
include('counter.php');
$count = counter($lang);

$memcache = new Memcached;
$memcache->addServer('localhost', ini_get('memcache.default_port'));
$memcache->set('count_na_' . $lang, $count, 600); // записать в memcache

$count = '<span id=counter>' . $count . '</span>';

foreach (json_decode(file_get_contents(__DIR__ . '/lang/' . $lang .'.json'), true) as $var => $val) {
    $val = str_replace(
        ['%COUNT%', '%EDITOR_LINK%'],
        [$count, '/editor/' . $lang . '/'],
        $val);
    $GLOBALS[$var] = $val;
}

header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
<title><?=$headpage ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body bgcolor=white text=black background=/fon1.jpg>
<?
if ($media) {
    echo "<table width=100%><tr><td><i><font size=-2>$epigraph<img src=http://home.lleo.me/cgi-bin/na?lang=$lang width=1 height=1></font></i></td><td align=right>";
    echo '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" WIDTH=130 HEIGHT=70>';
    echo '<PARAM NAME=movie VALUE="/swf/' . $media . '"><PARAM NAME=quality VALUE=high><PARAM NAME=bgcolor VALUE=#FFFFFF><PARAM NAME=loop VALUE=false>';
    echo '<EMBED src="/swf/' . $media . '" quality=high loop=false bgcolor=#FFFFFF WIDTH=130 HEIGHT=70 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED></OBJECT>';
} else {
    echo "<p><i><font size=-2>" . $epigraph . "<img src=http://home.lleo.me/cgi-bin/na?" . $lang . " width=1 height=1></font></i>";
}
echo '</td></tr></table>
<center><table width=70%><td valign=center><div align=justify>
<h1><center><p>' . $head . '<br><small>' . $official_site . '<span id="custom_name_block" style="display: none;"><br><font size=+1 color=red><u>' . $hello_you . ' <span id="custom_name"></span></u></font></span>';

echo '<FORM><select name=lo onChange=" {for (var i=0; i < this.length; i++){if (this.options[i].selected){top.window.location=this.options[i].value;break;} } }">';
echo str_replace('/' . $lang . '/">', '/' . $lang . '/"selected>', file_get_contents('select.txt'));
echo '</SELECT></FORM>
</small></center></h1>
<p><br><font color=red><b>' . $oi_chto_eto . '</b></font><p>' . $zdes_raspolojeno . '

<p><font color=red><b>' . $chto_eto_znachit . '</b></font><p>' . $vas_poslali . '

<p><font color=red><b>' . $kak_eto_moglo . '</b></font><p>' . $vot_samye . '
<ul><li>' . str_replace("\n", '</li><li>',$prichiny) , '</li><li id="custom_how_block" style="display: none;"><font color=red><u>' . $hello_noprichina . ' <span id="custom_how"></span></u></font></li></ul>

<p>';

echo $est_variant;

echo '<p><font color=red><b>' . $chto_delat . '</b></font><p>' . $sovetuem . '
<ul><li>' . str_replace("\n", '</li><li>', $sovety) . '</li><li id="custom_what_block" style="display: none;"><font color=red><u>' . $hello_nosovet . ' <span id="custom_what"></span></u></font></span></li></ul>';

if ($bottom_vernutsa . $bottom_izbrannoe . $bottom_start . $bottom_druga) {
    echo '<center>';
    if ($bottom_vernutsa) {
        echo "\n<input TYPE=\"BUTTON\" VALUE=\"" . $bottom_vernutsa . "\" onClick=\"window.alert('";
        echo str_replace("\\n##\\n", "'); window.alert('",
            str_replace("\n", "\\n", str_replace("я", "\\я", $bottom_vernut)));
        echo "'); return true;\">";
        echo ' &nbsp; ';
    }
    if ($bottom_izbrannoe) {
        echo "\n<input TYPE=\"BUTTON\" VALUE=\"" . $bottom_izbrannoe . "\" onClick=\"window.alert('";
        echo str_replace("\\n##\\n", "'); window.alert('",
            str_replace("\n", "\\n", str_replace("я", "\\я", $bottom_izbr)));
        echo "'); window.external.AddFavorite('http://natribu.org";
        if ($lang !== "ru") {
            echo '/' . $lang;
        }
        echo "','" . $head . "'); return true;\">";
        echo ' &nbsp; ';
    }
    if ($bottom_start) {
        echo "\n<input TYPE=\"BUTTON\" VALUE=\"" . $bottom_start . "\" onClick=\"window.alert('";
        echo str_replace("\\n##\\n", "'); window.alert('",
            str_replace("\n", "\\n", str_replace("я", "\\я", $bottom_strt)));
        echo "'); window.external.AddFavorite('http://natribu.org";
        if ($lang !== "ru") {
            echo '/' . $lang;
        }
        echo "','" . $head . "'); return true;\">";
        echo ' &nbsp; ';
    }
    if ($bottom_druga) {
        echo "\n<input TYPE=\"BUTTON\" VALUE=\"" . $bottom_druga . "\" onClick=\"window.alert('";
        echo str_replace("\\n##\\n", "'); window.alert('",
            str_replace("\n", "\\n", str_replace("я", "\\я", $bottom_drug)));
        echo "'); window.location.href='/editor/" . $lang ."/' \">";
    }
    echo '</center>';
}
?>

<p><font color=red><b><?=$kak_mne_jit?></b></font>
<ul>
    <li><?=str_replace("\n", "</li><li>", $zapomnite)?></li>
</ul>

<p><br>
<center><input TYPE="BUTTON" VALUE=" <?=$about?> " onClick="window.location.href='/about.php'"></center>
<p>
<table width=100%>
    <tr>
        <td width="33%">
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
        <td width="33%" align="center"><iframe src="https://ghbtns.com/github-btn.html?user=natribu&repo=natribu.org&type=star" frameborder="0" scrolling="0" width="50" height="20"></iframe></td>
        <td width="33%" align=right><font size=-1><?=$perevod?>&nbsp;<?=$perevodchik?></font>
        </td>
    </tr>
</table>

</td>
</table>

<div id="custom_disclaimer" style="display: none;"><?=$otvetstvenno?></div>

</center>

<script>if (window.location.search || window.location.hash) {document.write('<scri'+'pt src="/base64.js"></scri'+'pt>')}</script>
<script>
    function inject(src) {
        var s = document.createElement('script');
        s.setAttribute('type', 'text/javascript');
        s.setAttribute('src', src);
        var head = document.getElementsByTagName('head').item(0);
        head.insertBefore(s, head.firstChild);
    }

    function mkdiv(s) {
        var div = document.createElement('DIV');
        div.innerHTML = s;
        var p = document.body;
        p.insertBefore(div, p.lastChild);
    }
    function idd(id) {
        return document.getElementById(id);
    }
    function zabil(id, s) {
        idd(id).innerHTML = s;
    }

    setTimeout("inject('/poshli.php?lang=<?=$lang?>&ask=0&old=0')", 60000);
    try {
        var custom = base64_decode((window.location.hash.slice(1) || window.location.search.slice(1)).replace(/-/g, "/")).replace(/^\s+|\s+$/gm,'').split(/\s*%\s*/);
        document.getElementById('custom_name_block').style.display = 'inline';
        document.getElementById('custom_name').textContent = custom[0];
        document.getElementById('custom_how_block').style.display = 'list-item';
        document.getElementById('custom_how').textContent = custom[1];
        document.getElementById('custom_what_block').style.display = 'list-item';
        document.getElementById('custom_what').textContent = custom[2];
        document.getElementById('custom_disclaimer').style.display = 'block';
    } catch (e) {}
</script>

</body>
</html>
