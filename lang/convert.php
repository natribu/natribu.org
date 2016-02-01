<?php
$index = json_decode(file_get_contents('./index.json'), true);
$codes = [];
foreach ($index['groups'] as $group) {
    foreach ($group['items'] as $item) {
        $codes[$item['code']] = $item['name'];
    }
}

$fields = ['other','email','headpage','epigraph','media','head','official_site','national_office','oi_chto_eto','zdes_raspolojeno','chto_eto_znachit','vas_poslali','kak_eto_moglo','vot_samye','prichiny','poisk','est_variant','chto_delat','sovetuem','sovety','kak_mne_jit','zapomnite','bottom_vernutsa','bottom_vernut','bottom_izbrannoe','bottom_izbr','bottom_start','bottom_strt','bottom_druga','bottom_drug','about','perevod','perevodchik','lj_zdra','lj_raz','hello_you','hello_noprichina','hello_nosovet','otvetstvenno','post','post_','postprivet','post_name','post_mail','post_html','post_ip','post_button','post_alert','post_hidden','disclamer','lleo','lleo_url','e_head','e_text','e_submit','e_comment'];

$count = '%COUNT%';
$count_post = '%COUNT_POST%';
$poiskovik = '%POISKOVIK%';
$text = '%TEXT%';

foreach (scandir('.') as $filename) {
    print $filename . "\n";
    if (!preg_match('/^(\w{2,4}(_etalon)?)\.php$/i', $filename, $m)) {
        print "-- Мимо\n";
        continue;
    }
    include('./' . $filename);

    $data = [];
    foreach ($fields as $field) {
        if ($$field !== null && $$field !== '') {
            $data[$field] = $$field;
        }
    }

    file_put_contents('./'.$m[1].'.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n");

    foreach ($fields as $field) {
        unset($$field);
    }
}

