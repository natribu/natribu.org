<?php

$index = file_get_contents(dirname(__DIR__) . '/index.php');
$failures = [];

foreach (
    [
        "? \$mp3 : 'na.mp3'" => 'Missing default audio for languages without their own recording',
        'id="page_audio_button"' => 'Missing animated audio button',
        'src="/media/nah.gif"' => 'Missing shared animation',
        'id="page_audio"' => 'Missing reusable audio element',
        'src="/audio_player.js"' => 'Missing audio player behavior',
    ] as $needle => $message
) {
    if (strpos($index, $needle) === false) {
        $failures[] = $message;
    }
}

if ($failures) {
    fwrite(STDERR, implode("\n", $failures) . "\n");
    exit(1);
}

echo "Audio markup tests passed.\n";
