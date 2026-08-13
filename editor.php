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

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$e_head?></title>
    <script src="/personalization.js"></script>
    <script>
        function highlight(id) {
            var field = document.getElementById(id);
            field.focus();
            field.select();
        }

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
<body style="color: black; background: white url('/fon1.jpg');">

<div id="custom_link_block" style="display: none;">
    <p>ссылка готова: <a href="#" id="custom_link_example">нажми</a></p>
    <div style="text-align: center;">
        <textarea cols="120" rows="2"
                  style="border: 1px solid #330000; font-size: 14px;"
                  id="custom_link_text"></textarea>
        <small><br>херассе какая длинная!
            <a href="#" onclick="highlight('custom_link_text'); return false;">выделить всю</a><br><br>
            хочется видеть эту ссылку короткой и загадочной?
            <a href="#" id="custom_link_tiny">жми сюда</a>
        </small>
    </div>
</div>

<div style="text-align: center;">
    <h1><?=$e_head?></h1>
</div>

<table style="width: 95%; margin: 0 auto;">
    <tr>
        <td>
            <div style="text-align: justify;">
                <p><?=$e_text?></p>

                <form action="<?=$editor_path?>" method="POST" onsubmit="return generateLink()">
                    <table style="width: 80%; margin: 0 auto; border: 1px solid; border-collapse: collapse;">
                        <tr>
                            <td style="vertical-align: middle; padding: 20px; border: 1px solid;">
                                <div style="text-align: justify;">

                                    <div style="text-align: center;">
                                        <h1><small><?=$head?><br>
                                            <small><?=$official_site?><br>
                                                <span style="color: red; font-size: larger;"><u><?=$hello_you?>
                                                    <input type="text" name="name" size="40"
                                                           style="border: 1px solid #330000; font-size: 16px;"
                                                           id="custom_name"></u></span>
                                            </small>
                                        </small></h1>
                                    </div>

                                    <p style="color: red;"><b><?=$kak_eto_moglo?></b></p>
                                    <p><?=$vot_samye?></p>
                                    <ul>
                                        <li><?=str_replace("\n", "</li><li>", $prichiny . "\n<span style=\"color: red;\"><u>" . $hello_noprichina)?>
                                            <input type="text" name="prichina" id="custom_how" size="50"
                                                   style="border: 1px solid #330000; font-size: 16px;"></u></span></li>
                                    </ul>

                                    <p style="color: red;"><b><?=$chto_delat?></b></p>
                                    <p><?=$sovetuem?></p>
                                    <ul>
                                        <li><?=str_replace("\n", "</li><li>", $sovety . "\n<span style=\"color: red;\"><u>" . $hello_nosovet)?>
                                            <input type="text" name="delat" id="custom_what" size="50"
                                                   style="border: 1px solid #330000; font-size: 16px;"></u></span></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <p style="text-align: center;"><br>
                        <input type="submit" value="<?=$e_submit?> ">
                    </p>
                </form>

                <?=$e_comment?>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
