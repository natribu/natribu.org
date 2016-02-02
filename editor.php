<?
$lang = explode('/', explode('?', ltrim($_SERVER['REQUEST_URI'], '/'))[0])[0] ?: 'ru';
if (!preg_match('/^[a-z0-9_]+$/i', $lang) || !file_exists('lang/' . $lang . '.json')) {
    header('Location: /');
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
    <script src="/base64.js"></script>
    <script>
        function generateLink() {
            var custom_name = document.getElementById("custom_name").value;
            var custom_how = document.getElementById("custom_how").value;
            var custom_what = document.getElementById("custom_what").value;
            if (!custom_name || !custom_how || !custom_what) {
                return false;
            }
            var link = "http://natribu.org/<?=$lang?>/#" + base64_encode(custom_name + " % " + custom_how + " % " + custom_what).replace(/=/g, "").replace(/\//g, "-");
            document.getElementById('custom_link_example').href = link;
            document.getElementById('custom_link_text').value = link;
            document.getElementById('custom_link_tiny').href = "http://tinyurl.com/create.php?url=" + encodeURIComponent(link);
            document.getElementById('custom_link_block').style.display = "block";
            (document.body || document.documentElement).scrollTop = 0;
            return false;
        }
    </script>
</head>
<body bgcolor=white text=black background=http://natribu.org/fon1.jpg>

<h1>
    <center><?=$e_head?>
        <OBJECT
            classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
            codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0"
            WIDTH=1 HEIGHT=1>
            <PARAM NAME=movie VALUE="/swf/chasto.swf">
            <PARAM NAME=quality VALUE=high>
            <PARAM NAME=bgcolor VALUE=#FFFFFF>
            <PARAM NAME=loop VALUE=false>
            <EMBED src="/swf/chasto.swf" quality=high loop=false bgcolor=#FFFFFF
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

                    <form action="/editor/<?=$lang?>/" method="POST" onsubmit="return generateLink()">
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
                                                                          id="custom_name"
                                                                          value="<?=$name?> "></u></font></small>

</center>
</small></h1>


<p><font color=red><b><?=$kak_eto_moglo?></b></font>
<p><?=$vot_samye?>
<ul>
    <li><?=str_replace("\n", "</li><li>", $prichiny . "\n<font color=red><u>" . $hello_noprichina)?>
        <input type=text name=prichina id="custom_how" size=50
               style="border: 1px solid #330000; font-size: 16px;"
               value="<?=$prichina?> "></u></font></li>
</ul>

<p><font color=red><b><?=$chto_delat?></b></font>
<p><?=$sovetuem?>
<ul>
    <li><?=str_replace("\n", "</li><li>", $sovety . "\n<font color=red><u>" . $hello_nosovet)?>
        <input type=text name=delat id="custom_what" size=50
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
