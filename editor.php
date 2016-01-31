<?
list($script, $lang, $human) = explode('/', $_SERVER['REQUEST_URI']);

if (!preg_match('/[a-z0-9]{1,3}/i', $lang)) {
    $human = $lang;
    $lang = 'ru';
}
if (!file_exists('lang/' . $lang . '.php')) {
    header('Location: /');
    exit();
}

//--- поехали
// Определение ЖЖ-истов
$lju = base64_decode($_COOKIE["lju"]);
if (!$lju && preg_match("/^http\:\/\/(.*?)\.livejournal\.com\/friends/", $_SERVER['HTTP_REFERER'], $matches)) {
    $lju = $matches[1];
    setcookie('lju', base64_encode($lju), time() + 86400 * 365, '/');
}

$name = str_replace('&amp;', '&', htmlspecialchars(trim($_POST['name'], ENT_QUOTES)));
$prichina = str_replace('&amp;', '&', htmlspecialchars(trim($_POST['prichina'], ENT_QUOTES)));
$delat = str_replace('&amp;', '&', htmlspecialchars(trim($_POST['delat'], ENT_QUOTES)));


if ($name . $prichina . $delat) {
    $stroka = $name . '%' . $prichina . '%' . $delat;
    $stroka = base64_encode($stroka);
    $stroka = str_replace(['=', '/'], ['', '-'], $stroka);

    if ($lang === 'ru') {
        $ssylka = 'http://natribu.org/?' . $stroka;
    } else {
        $ssylka = 'http://natribu.org/' . $lang . '/?' . $stroka;
    }

    print '<p>ссылка готова: <a href=' . $ssylka . '>нажми</a>';

    echo '<SCRIPT language=JavaScript>
function highlight(x){
    document.forms[x].elements[0].focus()
    document.forms[x].elements[0].select()
}
</SCRIPT>';
    echo '<form><center><textarea cols=120 rows=2 style="border: 1px solid #330000; font-size: 14px;">' . $ssylka . "</textarea>";
    echo '<font size=-1><br>херассе какая длинная! <a href="javascript:highlight(0)">выделить всю</a><p>хочется видеть эту ссылку короткой и загадочной? <a href=http://tinyurl.com/create.php?url=' . $ssylka . '>жми сюда</a></font></center></form>';
}

include('counter.php');
$count = counter('.count.editor');

$codepage = "UTF-8";
/** @noinspection PhpIncludeInspection */
include('lang/' . $lang . '.php');

header('Content-Type: text/html; charset=' . $codepage);

?>
<html>
<head>
    <title><?=$e_head?></title>
</head>
<body bgcolor=white text=black background=http://natribu.org/fon1.jpg>

<h1>
    <center><?=$e_head?>
        <OBJECT
            classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
            codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0"
            WIDTH=1 HEIGHT=1>
            <PARAM NAME=movie VALUE="/na/swf/chasto.swf">
            <PARAM NAME=quality VALUE=high>
            <PARAM NAME=bgcolor VALUE=#FFFFFF>
            <PARAM NAME=loop VALUE=false>
            <EMBED src="/na/swf/chasto.swf" quality=high loop=false bgcolor=#FFFFFF
                   WIDTH=1 HEIGHT=1 TYPE="application/x-shockwave-flash"
                   PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
        </OBJECT>
    </center>
</h1>

<center>
    <table width=95%>
        <td>
            <div align=justify>
                <p><?=$e_text?>

                    <form action="editor" method="POST">
                        <center>
                            <table width=80% border=1 cellspacing=0 cellpadding=20>
                                <td valign=center>
                                    <div align=justify>

                                        <h1>
                                            <small>
                                                <center>
                <p><?=$head?><br>
                    <small><?=$official_site?><br>
                        <font size=+1 color=red><u><?=$hello_you?> <input type=text name=name
                                                                          size=40
                                                                          style="border: 1px solid #330000; font-size: 16px;"
                                                                          value="<?=$name?> "></u></font></small>

</center>
</small></h1>


<p><font color=red><b><?=$kak_eto_moglo?></b></font>
<p><?=$vot_samye?>
<ul>
    <li><?=str_replace("\n", "</li><li>", $prichiny . "\n<font color=red><u>" . $hello_noprichina)?>
        <input type=text name=prichina size=50
               style="border: 1px solid #330000; font-size: 16px;"
               value="<?=$prichina?> "></u></font></li>
</ul>

<p><font color=red><b><?=$chto_delat?></b></font>
<p><?=$sovetuem?>
<ul>
    <li><?=str_replace("\n", "</li><li>", $sovety . "\n<font color=red><u>" . $hello_nosovet)?>
        <input type=text name=delat size=50
               style="border: 1px solid #330000; font-size: 16px;"
               value="<?=$delat?> "></u></font></li>
</ul>

</td>
</table>
</center>

<p><br>
<center><input type=submit value="<?=$e_submit?> "></center>

</form>

<?=$e_comment?>

</div>
</td>
</table>

</body>
</html>
