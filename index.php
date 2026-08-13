<?php
error_reporting(E_ERROR | E_PARSE);
require_once __DIR__ . '/editor_routes.php';

$lang = explode('/', explode('?', ltrim($_SERVER['REQUEST_URI'], '/'), 2)[0], 2)[0];
if (!$lang) {
    $lang = 'ru'; // TODO: Check client language preferences
}
if (!preg_match('/^[a-z0-9_]+$/i', $lang) || !file_exists('lang/' . $lang . '.json')) {
    header('Location: /');
    exit();
}

$editor_path = editor_url($lang);

//--- поехали
include('counter.php');
$count = counter($lang);

if (class_exists('Memcached')) {
    $memcache = new Memcached;
    $memcache->addServer('127.0.0.1', 11211);
    $memcache->set('count_na_' . $lang, $count, 600); // записать в memcached
}

$count = '<span id=counter>' . $count . '</span>';

$censorship_mode = ($_GET['censorship_mode'] ?? null) === 'on';
$censorship = function ($text) {
    return preg_replace('/х(\s*)у(\s*)(й)\b/mui', '✱$1✱$2$3', $text);
};

$lang_data = json_decode(file_get_contents(__DIR__ . '/lang/' . $lang .'.json'), true);
foreach ($lang_data as $var => $val) {
    $val = str_replace(
        [
            '%EDITOR_LINK%',
            '%COUNT%',
        ],
        [
            $editor_path,
            $count,
        ],
        $val
    );
    if ($censorship_mode) {
        $val = $censorship($val);
    }
    $GLOBALS[$var] = $val;
}

header('Content-Type: text/html; charset=utf-8');

$page_mp3 = !empty($mp3) && file_exists(__DIR__ . '/media/' . $mp3) ? $mp3 : 'na.mp3';
?>
<html>
<head>
<title><?=$headpage ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body bgcolor=white text=black background=/fon1.jpg>
<?php
echo '<table width=100%><tr>';
echo '<td><i><font size=-2>'.$epigraph.'<img src=//home.lleo.me/cgi-bin/na?lang=$lang width=1 height=1></font></i></td>';
echo '<td align=right><button type="button" id="page_audio_button" aria-label="Play sound" title="Play sound" style="padding:0;border:0;background:transparent;cursor:pointer">';
echo '<img src="/media/nah.gif" width=130 height=70 alt="" style="display:block"></button></td>';
echo '</tr></table>';
echo '<audio id="page_audio" src="/media/' . htmlspecialchars($page_mp3, ENT_QUOTES, 'UTF-8') . '" preload="auto"></audio>';
echo '
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
        echo "'); window.external.AddFavorite('https://natribu.org";
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
        echo "'); window.external.AddFavorite('https://natribu.org";
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
        echo "'); window.location.href='" . $editor_path . "' \">";
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
document.write("<a href='https://www.liveinternet.ru/click' "+
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

<script src="/audio_player.js"></script>
<script>if (window.location.search || window.location.hash) {document.write('<scri'+'pt src="/personalization.js"></scri'+'pt>')}</script>
<script>
    function inject(src) {
        var s = document.createElement('script');
        s.setAttribute('type', 'text/javascript');
        s.setAttribute('src', src);
        var head = document.getElementsByTagName('head').item(0);
        head.insertBefore(s, head.firstChild);
    }

    function idd(id) {
        return document.getElementById(id);
    }
    function zabil(id, s) {
        idd(id).innerHTML = s;
    }

    setTimeout("inject('/poshli.php?lang=<?=$lang?>&ask=0&old=0')", 60000);
    try {
        var custom = personalization_fields_from_payload(personalization_decode(window.location.hash.slice(1) || window.location.search.slice(1)));
        personalization_display(document, custom);
    } catch (e) {}
</script>

</body>
</html>
