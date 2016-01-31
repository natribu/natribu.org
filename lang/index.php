<?php
mysql_connect('localhost', 'natribu', 'NahPass');
mysql_select_db('natribu');

if (!$_GET['lang']) {
    $d = opendir('.');
    while (($f = readdir($d)) !== false) {
        if ($f[0] !== '.' && $f !== 'index.php') {
            list($lang, $type) = explode('.', $f);
            echo "<a href=./?lang=$lang>$lang</a> | ";
        }
    }
} else if (preg_match('/^[a-z0-9_-]+$/', $_GET['lang'])) {
    $fields = [
        'changed',
        'codepage',
        'other',
        'email',
        'password',
        'headpage',
        'epigraph',
        'media',
        'head',
        'official_site',
        'national_office',
        'oi_chto_eto',
        'zdes_raspolojeno',
        'chto_eto_znachit',
        'vas_poslali',
        'kak_eto_moglo',
        'vot_samye',
        'prichiny',
        'poisk',
        'est_variant',
        'chto_delat',
        'sovetuem',
        'sovety',
        'kak_mne_jit',
        'zapomnite',
        'bottom_vernutsa',
        'bottom_vernut',
        'bottom_izbrannoe',
        'bottom_izbr',
        'bottom_start',
        'bottom_strt',
        'bottom_druga',
        'bottom_drug',
        'about',
        'perevod',
        'perevodchik',
        'lj_zdra',
        'lj_raz',
        'hello_you',
        'hello_noprichina',
        'hello_nosovet',
        'otvetstvenno',
        'post',
        'post_',
        'postprivet',
        'post_name',
        'post_mail',
        'post_html',
        'post_ip',
        'post_button',
        'post_alert',
        'post_hidden',
        'disclamer',
        'lleo',
        'lleo_url',
        'e_head',
        'e_text',
        'e_submit',
        'e_comment'
    ];
    $codepage = null;
    /** @noinspection PhpIncludeInspection */
    include($_GET['lang'] . '.php');
    $codepage = $codepage ?: 'UTF-8';
    print "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /></head><body>";
    foreach ($fields as $f) {
        $v = &$GLOBALS[$f];
        $v = iconv($codepage, 'utf-8', $v);
        $v = preg_replace_callback('/\&\#\d+;/', 'converter', $v);
        if ($v && $f !== 'changed') {
            $sql = 'INSERT INTO `lang` (`lang`, `key`, `value`) VALUES (\'' . $_GET['lang'] . '\', \'' . $f . '\', \'' . mysql_real_escape_string(htmlspecialchars($v)) . '\');';
            print $sql . '<br>';
        }
    }
}

function converter($m)
{
    return mb_convert_encoding($m[0], 'utf-8', 'HTML-ENTITIES');
}