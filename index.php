<?php
list($lang, $human) = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));

if (!preg_match('/[a-z0-9]{1,3}/i', $lang)) {
    $human = $lang;
    $lang = 'ru';
}

if (!file_exists('lang/' . $lang . '.json')) {
    header('Location: /');
    exit();
}

//--- поехали
list($poiskovik, $text) = poiskovik();

include('counter.php');
$count = counter($lang);

$memcache = new Memcached;
$memcache->addServer('localhost', ini_get('memcache.default_port'));
$memcache->set('count_na_' . $lang, $count, 600); // записать в memcache

$count = '<span id=counter>' . $count . '</span>';

//--------------------

$kolnah = $_COOKIE['nah'] + 1;
setcookie('nah', $kolnah, time() + 86400 * 365, '/', '.natribu.org', 0);

//--------------------
$codepage = "UTF-8";
/** @noinspection PhpIncludeInspection */

foreach (json_decode(file_get_contents(__DIR__ . '/lang/' . $lang .'.json'), true) as $var => $val) {
    $val = str_replace(
        ['%COUNT%', '%POISKOVIK%', '%TEXT%', '%EDITOR_LINK%'],
        [$count, $poiskovik, $text, '/editor/' . $lang . '/'],
        $val);
    $GLOBALS[$var] = $val;
}

header('Content-Type: text/html; charset=utf-8');

if ($_GET)

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

    if (!$u) {
        $poisk = '';
    }
    echo str_replace('=POISK=', $poisk, $est_variant);

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


<?
function poiskovik()
{
    $s = [];
    $u = parse_url($_SERVER['HTTP_REFERER']);
    parse_str($u['query'], $outr);
    // GOOGLE
    if (ereg('google.', $u['host'])) {
        $s[0] = urldecode($outr['q']);
        $s[1] = 'Google';
    }
    // YANDEX-search
    if (ereg('yandex.ru/yandsearch', $u['host'] . $u['path'])) {
        $s[0] = urldecode($outr['text']);
        $s[1] = 'Yandex';
    }
    // YANDEX-yandpage
    if (ereg('yandex.ru/yandpage', $u['host'] . $u['path'])) {
        parse_str(urldecode($outr['qs']), $outr2);
        $s[0] = iconv('koi8-r', 'UTF-8', urldecode($outr2['text']));
        $s[1] = 'Yandex';
    }
    // RAMBLER
    if (ereg('rambler.ru', $u['host'])) {
        $s[0] = trim(urldecode($outr['words'] . " " . $outr['old_q']));
        $k_koi = strlen(str_replace("-", "",
            strtr($s[0], "КГХЛЕОЗЫЭЪИЯЖЩЧБРТПМДЦЬСЮУНЙФШВА", "--------------------------------")));
        $k_win = strlen(str_replace("-", "",
            strtr($s[0], "кгхлеозыэъияжщчбртпмдцьсюунйфшва", "--------------------------------")));
        if ($k_koi < $k_win) {
            $s[0] = iconv('cp1251', 'koi8-r', $s[0]);
        }
        $s[1] = 'Rambler';
    }
    // GO.MAIL.RU
    if (ereg('go.mail.ru/search', $u['host'] . $u['path'])) {
        $s[0] = trim(urldecode($outr['q'] . ' ' . $outr['old_q']));
        $s[1] = 'Go.mail.ru';
    }

    return $s;
}
