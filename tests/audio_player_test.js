const fs = require('fs');
const vm = require('vm');

let clickHandler = null;
let pauses = 0;
let plays = 0;
const audio = {
    currentTime: 23,
    pause() {
        pauses += 1;
    },
    play() {
        plays += 1;
        return Promise.resolve();
    }
};
const button = {
    addEventListener(event, handler) {
        if (event === 'click') {
            clickHandler = handler;
        }
    }
};
const document = {
    getElementById(id) {
        return id === 'page_audio' ? audio : button;
    }
};

vm.runInNewContext(
    fs.readFileSync(__dirname + '/../audio_player.js', 'utf8'),
    { document, Promise }
);

if (plays !== 1 || pauses !== 1 || audio.currentTime !== 0) {
    throw new Error('The page sound was not attempted once from the start on load');
}
if (typeof clickHandler !== 'function') {
    throw new Error('The animated player does not handle clicks');
}

audio.currentTime = 12;
clickHandler();

if (plays !== 2 || pauses !== 2 || audio.currentTime !== 0) {
    throw new Error('A click did not replay the page sound from the start');
}

console.log('Audio player tests passed.');
