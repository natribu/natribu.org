(function () {
    'use strict';

    var audio = document.getElementById('page_audio');
    var button = document.getElementById('page_audio_button');
    if (!audio || !button) {
        return;
    }

    function playPageSound() {
        audio.pause();
        try {
            audio.currentTime = 0;
        } catch (e) {}

        var playback = audio.play();
        if (playback && typeof playback.catch === 'function') {
            playback.catch(function () {});
        }
    }

    button.addEventListener('click', playPageSound);
    playPageSound();
}());
