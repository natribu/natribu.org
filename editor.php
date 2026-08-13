<?php
require_once __DIR__ . '/editor_routes.php';

$lang = editor_language_from_request_uri($_SERVER['REQUEST_URI']);
if (!$lang || !preg_match('/^[a-z0-9_]+$/i', $lang) || !file_exists(__DIR__ . '/lang/' . $lang . '.json')) {
    header('Location: /');
    exit();
}

$editor_path = editor_url($lang);
$personalized_page_path = $lang === 'ru' ? '/' : '/' . $lang . '/';
$redirect_url = editor_canonical_redirect_url($_SERVER['REQUEST_URI'], $lang);
if ($redirect_url) {
    header('Location: ' . $redirect_url);
    exit();
}

include('counter.php');
$count = counter('.count.editor');

foreach (json_decode(file_get_contents(__DIR__ . '/lang/' . $lang .'.json'), true) as $var => $val) {
    $val = str_replace(['%COUNT%'], [$count], $val);
    $GLOBALS[$var] = $val;
}

//--- поехали
print '<div id="custom_link_block" style="display: none;">';
print '<p>ссылка готова: <a href=# id="custom_link_example">нажми</a>';

echo '<SCRIPT language=JavaScript>
function highlight(x){
    document.forms[x].elements[0].focus()
    document.forms[x].elements[0].select()
}
</SCRIPT>';
echo '<form><center><textarea cols=120 rows=2 style="border: 1px solid #330000; font-size: 14px;" id="custom_link_text"></textarea>';
echo '<font size=-1><br>херассе какая длинная! <a href="javascript:highlight(0)">выделить всю</a><p>хочется видеть эту ссылку короткой и загадочной? <a href=# id="custom_link_tiny">жми сюда</a></font></center></form>';
print "</div>";
?>
<html>
<head>
    <title><?=$e_head?></title>
    <script src="/personalization.js"></script>
    <script>
        function generateLink() {
            var custom = personalization_fields([
                document.getElementById("custom_name").value,
                document.getElementById("custom_how").value,
                document.getElementById("custom_what").value
            ]);
            if (!personalization_has_content(custom)) {
                document.getElementById('custom_link_block').style.display = "none";
                return false;
            }
            var link = personalization_link(window.location, <?=json_encode($personalized_page_path)?>, custom);
            document.getElementById('custom_link_example').href = link;
            document.getElementById('custom_link_text').value = link;
            document.getElementById('custom_link_tiny').href = "https://tinyurl.com/create.php?url=" + encodeURIComponent(link);
            document.getElementById('custom_link_block').style.display = "block";
            (document.body || document.documentElement).scrollTop = 0;
            return false;
        }
    </script>
</head>
<body bgcolor=white text=black background=/fon1.jpg>

<h1>
    <center><?=$e_head?>
        <OBJECT
            classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
            codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0"
            WIDTH=1 HEIGHT=1>
            <PARAM NAME=movie VALUE="/swf/chasto.swf">
            <PARAM NAME=quality VALUE=high>
            <PARAM NAME=bgcolor VALUE=#FFFFFF>
            <PARAM NAME=loop VALUE=false>
            <EMBED src="/swf/chasto.swf" quality=high loop=false bgcolor=#FFFFFF
                   WIDTH=1 HEIGHT=1 TYPE="application/x-shockwave-flash"
                   PLUGINSPAGE="https://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
        </OBJECT>
    </center>
</h1>

<center>
    <table width=95%>
        <td>
            <div align=justify>
                <p><?=$e_text?>

                    <form action="<?=$editor_path?>" method="POST" onsubmit="return generateLink()">
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
                                                                          id="custom_name"></u></font></small>

</center>
</small></h1>


<p><font color=red><b><?=$kak_eto_moglo?></b></font>
<p><?=$vot_samye?>
<ul>
    <li><?=str_replace("\n", "</li><li>", $prichiny . "\n<font color=red><u>" . $hello_noprichina)?>
        <input type=text name=prichina id="custom_how" size=50
               style="border: 1px solid #330000; font-size: 16px;"></u></font></li>
</ul>

<p><font color=red><b><?=$chto_delat?></b></font>
<p><?=$sovetuem?>
<ul>
    <li><?=str_replace("\n", "</li><li>", $sovety . "\n<font color=red><u>" . $hello_nosovet)?>
        <input type=text name=delat id="custom_what" size=50
               style="border: 1px solid #330000; font-size: 16px;"></u></font></li>
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
