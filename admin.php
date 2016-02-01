<?
parse_ini_file('');
$adminpass = 'sdddddddddddddddderfececece3lfkelrkcjlkerjckl4cjkl23io4frhj';

// Определение ЖЖ-истов
$lju = base64_decode($_COOKIE['lju']);
if (!$lju && preg_match("/\Ahttp\:\/\/(.*?)\.livejournal\.com\/friends/", $_SERVER['HTTP_REFERER'], $matches)) {
    $lju = $matches[1];
    setcookie('lju', base64_encode($lju), time() + 86400 * 365, '/');
}


//print "<pre>test<p>";
//$fromlang="ru_";
//$tolang="en_test";

/// КАЖДУЮ ТАКУЮ ХЕРОВИНУ ПРАВИТЬ В ТРЕХ (!) МЕСТАХ

$imena = [
    'poisk',
    'codepage',
    'lj_user',
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

//print_r($_POST);

//$e='tolang';
//echo 'e=';
//.$$($e);
//exit();


//if (!$_POST["action"])
//{ exit(); }


if (!$_POST['action']) {
    echo "<html><head><title>nahui-admin-center</title></head>
<body bgcolor=white text=black background=http://natribu.org/fon1.jpg>
<font color=red><u>&copy; LLeo admin interface</u></font>";


    $sel = file_get_contents("select.txt");
    $sel = str_replace("http://natribu.org/", "", $sel);
    $sel = str_replace("/\">", "\">", $sel);
    $sel = str_replace("value=\"\">", "value=\"ru_\"selected>", $sel);

    echo "<form action=\"admin.php\" method=\"POST\">
<h1>For translators only</h2>
<p>If you want to translate NAHUI to other language:
<p>FROM: <select name=fromlang>
" . $sel . "
</SELECT>

<p>TO: <input type=text size=3 name=tolang value=en>
(Pls check language's name in list below!)

<input type=hidden name=action value=edit>

<p>create your password: <input type=text name=password size=8>

<p><input type=submit value=\" Go! \">
</FORM>


<p><center><table cellspacing=0 cellpadding=10 border=1><tr valign=top>
<td><font size=-2><pre>
ac Ascension Island
ad Andorra
ae United Arab Emirates
af Afghanistan
ag Antigua and Barbuda
ai Anguilla
al Albania
am Armenia
an Netherlands Antilles
ao Angola
aq Antarctica
ar Argentina
as American Samoa
at Austria
au Australia
aw Aruba
az Azerbaijan
ax Aland Islands
ba Bosnia and Herzegovina
bb Barbados
bd Bangladesh
be Belgium
bf Burkina Faso
bg Bulgaria
bh Bahrain
bi Burundi
bj Benin
bm Bermuda
bn Brunei Darussalam
bo Bolivia
br Brazil
bs Bahamas
bt Bhutan
bv Bouvet Island
bw Botswana
by Belarus
bz Belize
ca Canada
cc Cocos (Keeling) Islands
cd Congo
cf Central African Republic
cg Congo, Republic of
ch Switzerland
ci Cote d'Ivoire
ck Cook Islands
cl Chile
cm Cameroon
cn China
co Colombia
cr Costa Rica
cs Serbia and Montenegro
cu Cuba
cv Cape Verde
cx Christmas Island
cy Cyprus
cz Czech Republic
de Germany
dj Djibouti
dk Denmark
dm Dominica
do Dominican Republic
dz Algeria
ec Ecuador
ee Estonia
eg Egypt
eh Western Sahara
er Eritrea
es Spain
et Ethiopia
eu European Union
fi Finland
fj Fiji
fk Falkland Islands (Malvinas)
fm Micronesia, Federal State of
fo Faroe Islands
fr France
ga Gabon
gb United Kingdom
gd Grenada
ge Georgia
gf French Guiana
gg Guernsey
gh Ghana
gi Gibraltar
gl Greenland
gm Gambia
gn Guinea
gp Guadeloupe

</td><td><font size=-2><pre>

gq Equatorial Guinea
gr Greece
gs South Georgia & South Sandwich Islands
gt Guatemala
gu Guam
gw Guinea-Bissau
gy Guyana
hk Hong Kong
hm Heard and McDonald Islands
hn Honduras
hr Croatia/Hrvatska
ht Haiti
hu Hungary
id Indonesia
ie Ireland
il Israel
im Isle of Man
in India
io British Indian Ocean Territory
iq Iraq
ir Iran, Islamic Republic of
is Iceland
it Italy
je Jersey
jm Jamaica
jo Jordan
jp Japan
ke Kenya
kg Kyrgyzstan
kh Cambodia
ki Kiribati
km Comoros
kn Saint Kitts and Nevis
kp Korea, Democratic People's Republic
kr Korea, Republic of
kw Kuwait
ky Cayman Islands
kz Kazakhstan
la Lao Democratic Republic
lb Lebanon
lc Saint Lucia
li Liechtenstein
lk Sri Lanka
lr Liberia
ls Lesotho
lt Lithuania
lu Luxembourg
lv Latvia
ly Libyan Arab Jamahiriya
ma Morocco
mc Monaco
md Moldova, Republic of
mg Madagascar
mh Marshall Islands
mk Macedonia Yugoslav Republic
ml Mali
mm Myanmar
mn Mongolia
mo Macau
mp Northern Mariana Islands
mq Martinique
mr Mauritania
ms Montserrat
mt Malta
mu Mauritius
mv Maldives
mw Malawi
mx Mexico
my Malaysia
mz Mozambique
na Namibia
nc New Caledonia
ne Niger
nf Norfolk Island
ng Nigeria
ni Nicaragua
nl Netherlands
no Norway
np Nepal
nr Nauru
nu Niue
nz New Zealand
om Oman
pa Panama
pe Peru
pf French Polynesia
pg Papua New Guinea
ph Philippines

</td><td><font size=-2><pre>

pk Pakistan
pl Poland
pm Saint Pierre and Miquelon
pn Pitcairn Island
pr Puerto Rico
ps Palestinian Territories
pt Portugal
pw Palau
py Paraguay
qa Qatar
re Reunion Island
ro Romania
ru Russian Federation
rw Rwanda
sa Saudi Arabia
sb Solomon Islands
sc Seychelles
sd Sudan
se Sweden
sg Singapore
sh Saint Helena
si Slovenia
sj Svalbard & Jan Mayen Islands
sk Slovak Republic
sl Sierra Leone
sm San Marino
sn Senegal
so Somalia
sr Suriname
st Sao Tome and Principe
sv El Salvador
sy Syrian Arab Republic
sz Swaziland
tc Turks and Caicos Islands
td Chad
tf French Southern Territories
tg Togo
th Thailand
tj Tajikistan
tk Tokelau
tl Timor-Leste
tm Turkmenistan
tn Tunisia
to Tonga
tp East Timor
tr Turkey
tt Trinidad and Tobago
tv Tuvalu
tw Taiwan
tz Tanzania
ua Ukraine
ug Uganda
uk United Kingdom
um United States Minor Outlying Islands
us United States
uy Uruguay
uz Uzbekistan
va Holy See (Vatican City State)
vc Saint Vincent and the Grenadines
ve Venezuela
vg Virgin Islands, British
vi Virgin Islands, U.S.
vn Vietnam
vu Vanuatu
wf Wallis and Futuna Islands
ws Samoa
ye Yemen
yt Mayotte
yu Yugoslavia
za South Africa
zm Zambia
zw Zimbabwe

</td></tr></table></center>



";

    exit();
}


if ($_POST['action'] === 'post') {
    echo "<html><head><title>nahui-admin-center (SAVE)</title></head>
<body bgcolor=white text=black background=http://natribu.org/fon1.jpg>
<font color=red><u>&copy; LLeo admin interface (SAVE)</u></font>";


    if (strlen($_POST['tolang']) > 3) {
        print '<p>error: newerland :)';
        exit();
    }

    $tolang = $_POST['tolang'];

    if (file_exists("lang/" . $tolang . ".php")) {

        $l2 = getlang("lang/" . $tolang . ".php");

        if ($_POST['password'] != $adminpass) {
            if ($_POST['password'] != $l2['password']) {
                print "error password: " . $_POST['password'];
                exit();
            }
        }

        if ($l2['changed'] !== "web") {
            echo '<p>backup...<p>' . $l2['changed'];
            rename('lang/' . $tolang . '.php', 'lang/' . $tolang . '.php.old');
        }

    }

//    $f = fopen($tolang.".temp","w");
    $f = fopen('lang/' . $tolang . '.php', 'w');

    fputs($f, "<?\n\n\$changed=\"web\";\n\n\n");
    for ($i = 0; $i < sizeof($imena); $i++) {
        $n = $imena[$i];
        $s = $_POST[$n];

        $s = str_replace("\r", '', $s);
        $s = addslashes(trim($s));
        while (str_replace("\n\n", "\n", $s) != $s) {
            $s = str_replace("\n\n", "\n", $s);
        }

        $s = str_replace("\n##", '##', $s);
        $s = str_replace("##\n", '##', $s);
        $s = str_replace('##', "\n##\n", $s);

//    $s=str_replace("&amp;","&",$s);

        $s = str_replace("\$", '', $s);
        $s = preg_replace('/\\*(.*?)\\*/', '\\\$$1', $s);
        //$s=str_replace("*count*","\$count",$s);
        //$s=str_replace("*poiskovik*","\$poiskovik",$s);
        //$s=str_replace("*text*","\$text",$s);
        //$s=str_replace("*poisk*","\$poisk",$s);

        $s = str_replace('*ent*', "\n", $s);


        fputs($f, "\n\n\$" . $n . "=\"" . $s . "\";");
        //print "\n".$n;
    }

    fputs($f, "\n\n?>");
    fclose($f);
    copy('lang/' . $tolang . '.php', 'new/' . $tolang . '.php');


    print 'saved!';

    echo '<form action="admin.php" method="POST">
<input type=hidden name=action value=edit>
<input type=hidden name=fromlang value=' . $fromlang . '>
<input type=hidden name=tolang value=' . $tolang . '>
<input type=hidden name=password value=' . $l2['password'] . '>
<input type=submit value=" Continue edit ">
</FORM>

<p><form action=' . $tolang . ' method="POST">
<input type=submit value=" V I E W  http://natribu.org/' . $tolang . '/">
</FORM>
';
    exit();
}


/////-----------------------------------------------------------------------------------------------


if ($_POST['action'] === "edit") {

    $tolang = $_POST['tolang'];
    $pattern = '#[a-z]{1,3}#';
    $found = preg_match($pattern, $toland, $out);
    $toland = $out[0];
    if (
        (strlen($tolang) > 3) ||
        (strlen($tolang) < 2)
    ) {
        print "<p>error: newerland :)";
        exit();
    }

    $fromlang = $_POST['fromlang'];

//echo "PREVED!!! ".$fromlang." to:".$tolang;
//exit();

    $l2 = getlang('lang/' . $tolang . '.php');

    if (file_exists('lang/' . $tolang . '.php')) {
// если файл такой уже есть
        if ($_POST['password'] !== $adminpass) {
            if ($l2['password'] !== $_POST['password']) {
                echo '<p>wrong password';
                exit ();
            }
        }
    } else {
// если файла еще нет - сделать начальные установки
        $l2['password'] = $_POST['password'];
        $l2['lj_user'] = $lju;
//$l2['codepage']="utf-8"; //а то заебусь потом
        $l2['codepage'] = ''; //а то заебусь потом
    }


    $codepage = 'windows-1251';
    if ($l2['codepage']) {
        $codepage = $l2['codepage'];
    }
    header('Content-Type: text/html; charset=' . $codepage);


    echo '<html><head><title>nahui-admin-center-EDIT</title></head>
<body bgcolor=white text=black background=http://natribu.org/fon1.jpg>
<font color=red><u>&copy; LLeo admin interface (EDIT):</u></font>';

//echo "<p>l2[codepage]=".$l2['codepage']."<p>codepage=".$codepage;


    $l1 = getlang('lang/' . $fromlang . '.php');


    echo '<form action="admin.php" method="POST">

<input type=hidden name=fromlang value=' . $fromlang . '>
<input type=hidden name=tolang value=' . $tolang . '>
<input type=hidden name=action value=post>';

    hidden_page('password');
    hidden_page('lleo_url');
    hidden_page('media');
    hidden_page('e_comment');
//    hidden_page('other');
    hidden_page('lj_user');
    hidden_page('codepage');

//<input type=hidden name=password value=".trim($l2['password']).">

    echo '<center><h1>Pls, translate:</h1><p><table border=0 cellspacing=10 cellpadding=1>';

    echo '<tr><td><h1>from: <a href=http://natribu.org/' . $fromlang . '/>' . $fromlang . '</a>
</h1></td><td><h1>to: <a href=http://natribu.org/' . $tolang . '/>' . $tolang . '</a></h1></td></tr>';

    echo '<tr><td colspan=2 align=center><font size=+1 color=red>
autor
</font><hr color=red></td></tr>';

    page('perevod');
    page('perevodchik');

    echo "<tr><td colspan=2 align=center><font size=+1 color=red>
your secret information (admin only):
</font><hr color=red></td></tr>";

    page('email');
    page('other');

    echo '<tr><td colspan=2 align=center><font size=+1 color=red>
main
</font><hr color=red></td></tr>';

    page('headpage');
    page('epigraph');
    page('head');
    page('official_site');
    page('national_office');
    page('oi_chto_eto');
    page('zdes_raspolojeno');
    page('chto_eto_znachit');
    page('vas_poslali');
    page('kak_eto_moglo');
    page('vot_samye');
    page('prichiny');
    page('poisk');
    page('est_variant');
    page('chto_delat');
    page('sovetuem');
    page('sovety');
    page('kak_mne_jit');
    page('zapomnite');

    echo '<tr><td colspan=2 align=center><font size=+1 color=red>
bottons
</font><hr color=red></td></tr>';

    page('bottom_vernutsa');
    page('bottom_vernut');
    page('bottom_izbrannoe');
    page('bottom_izbr');
    page('bottom_start');
    page('bottom_strt');
    page('bottom_druga');
    page('bottom_drug');


    echo '<tr><td colspan=2 align=center><font size=+1 color=red>
interactive
</font><hr color=red></td></tr>';

    page('hello_you');
    page('hello_noprichina');
    page('hello_nosovet');
    page('otvetstvenno');


    echo '<tr><td colspan=2 align=center><font size=+1 color=red>
about project
</font><hr color=red></td></tr>';

    page('about');
    page('lj_zdra');
    page('lj_raz');


    echo '<tr><td colspan=2 align=center><font size=+1 color=red>
post
</font><hr color=red></td></tr>';

    page('post');
    page('post_');
    page('postprivet');
    page('post_name');
    page('post_mail');
    page('post_html');
    page('post_ip');
    page('post_button');
    page('post_alert');
    page('post_hidden');

    echo '<tr><td colspan=2 align=center><font size=+1 color=red>
about
</font><hr color=red></td></tr>';

    page('disclamer');
    page('lleo');


    echo '<tr><td colspan=2 align=center><font size=+1 color=red>
message editor
</font><hr color=red></td></tr>';

    page('e_head');
    page('e_text');
    page('e_submit');


    echo '<tr><td colspan=2 align=center><hr color=red><p><br><input type=submit value=" S A V E &nbsp; C H A N G E S "></td></tr>';


    echo '</table></form></center>
<div align=right>contact with admin: <a href=mailto:lleo@aha.ru>lleo@aha.ru</a></div>
';


//}

//else {
//  echo "<p>file not exist!";
//}

}


function getlang($file)
{

    $count = '*count*';
    $poiskovik = '*poiskovik*';
    $text = '*text*';

    include($file);

    $langa = [

        'poisk' => $poisk,
        'changed' => $changed,
        'lj_user' => $lj_user,
        'other' => $other,
        'codepage' => $codepage,
        'email' => $email,
        'password' => $password,

        'headpage' => $headpage,
        'epigraph' => $epigraph,
        'media' => $media,
        'head' => $head,
        'official_site' => $official_site,
        'national_office' => $national_office,
        'oi_chto_eto' => $oi_chto_eto,
        'zdes_raspolojeno' => $zdes_raspolojeno,
        'chto_eto_znachit' => $chto_eto_znachit,
        'vas_poslali' => $vas_poslali,
        'kak_eto_moglo' => $kak_eto_moglo,
        'vot_samye' => $vot_samye,
        'prichiny' => $prichiny,
        'est_variant' => $est_variant,
        'chto_delat' => $chto_delat,
        'sovetuem' => $sovetuem,
        'sovety' => $sovety,
        'kak_mne_jit' => $kak_mne_jit,
        'zapomnite' => $zapomnite,
        'bottom_vernutsa' => $bottom_vernutsa,
        'bottom_vernut' => $bottom_vernut,
        'bottom_izbrannoe' => $bottom_izbrannoe,
        'bottom_izbr' => $bottom_izbr,
        'bottom_start' => $bottom_start,
        'bottom_strt' => $bottom_strt,
        'bottom_druga' => $bottom_druga,
        'bottom_drug' => $bottom_drug,
        'about' => $about,
        'perevod' => $perevod,
        'perevodchik' => $perevodchik,
        'lj_zdra' => $lj_zdra,
        'lj_raz' => $lj_raz,
        'hello_you' => $hello_you,
        'hello_noprichina' => $hello_noprichina,
        'hello_nosovet' => $hello_nosovet,
        'otvetstvenno' => $otvetstvenno,
        'post' => $post,
        'post_' => $post_,
        'postprivet' => $postprivet,
        'post_name' => $post_name,
        'post_mail' => $post_mail,
        'post_html' => $post_html,
        'post_ip' => $post_ip,
        'post_button' => $post_button,
        'post_alert' => $post_alert,
        'post_hidden' => $post_hidden,
        'disclamer' => $disclamer,
        'lleo' => $lleo,
        'lleo_url' => $lleo_url,
        'e_head' => $e_head,
        'e_text' => $e_text,
        'e_submit' => $e_submit,
        'e_comment' => $e_comment
    ];

    return $langa;
}


function page($n)
{

    global $l1, $l2;
    $cols = 50;

    $n1 = trim($l1[$n]);
    $n2 = trim($l2[$n]);

    $n1 = stripslashes($n1);
    $n2 = stripslashes($n2);

    $n1 = str_replace('&', '&amp;', $n1);
    $n2 = str_replace('&', '&amp;', $n2);
    $n1 = str_replace('&amp;#', '&#', $n1);
    $n2 = str_replace('&amp;#', '&#', $n2);

//$n1n=substr_count($n1,"\n");
//$n2n=substr_count($n2,"\n");

//$bukv1=iconv($l1['codepage'],"koi8-r",$n1);
//$bukv2=iconv($l1['codepage'],"koi8-r",$n2);
//strlen( html_entity_decode($n1,ENT_QUOTES,$l1['codepage']) );
//strlen( html_entity_decode($n1,ENT_QUOTES,$l2['codepage']) );

//$i=ceil( max(
//(($bukv1/($cols-1))+$n1n),
//(($bukv2/($cols-1))+$n2n)
//));

//$masstr=split("\n",iconv($l1['codepage'],"koi8-r",$n1));
    $masstr = split("\n", html_entity_decode($n1, ENT_QUOTES, $l1['codepage']));
    $i1 = 0;
    foreach ($masstr as $t) {
        $i1++;
        if (strlen($t) >= $cols) {
            $i1 = $i1 + (floor(strlen($t) / $cols));
        }
    }

//$masstr=split("\n",iconv($l1['codepage'],"koi8-r",$n2));
    $masstr = split("\n", html_entity_decode($n2, ENT_QUOTES, $l1['codepage']));
    $i2 = 0;
    foreach ($masstr as $t) {
        $i2++;
        if (strlen($t) >= $cols) {
            $i2 += (floor(strlen($t) / $cols));
        }
    }

    $i = max($i1, $i2);

    $n1 = str_replace("\n", "\n\n", $n1);
    $n2 = str_replace("\n", "\n\n", $n2);


    echo '<tr>';

    $tabl1 = '<textarea name=000000 cols=' . $cols . ' rows=' . $i . " style=\"border: 0px ;\">" . $n1 . '</textarea>';
    $tabl2 = '<textarea name=' . $n . ' cols=' . $cols . ' rows=' . $i . ' style="border: 1px solid #330000;">' . $n2 . '</textarea>';

//if ($n == "password") { $tabl1='<font color=red>your password:</font>'; }
    if ($n === 'email') {
        $tabl1 = '<font color=red>your e-mail:</font>';
    }

    echo '<td>' . $tabl1 . '</td>';
    echo '<td>' . $tabl2 . '</td>';
    echo '</tr>';
}


function hidden_page($n)
{

    global $l2;

    $n2 = trim($l2[$n]);
    $n2 = stripslashes($n2);
    $n2 = str_replace("\n", '*ent*', $n2);

    echo '<input type=hidden name=' . $n . ' value="' . $n2 . '">';
}
