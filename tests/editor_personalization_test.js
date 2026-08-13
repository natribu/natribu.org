const fs = require('fs');
const vm = require('vm');

vm.runInThisContext(fs.readFileSync(__dirname + '/../base64.js', 'utf8'));
vm.runInThisContext(fs.readFileSync(__dirname + '/../personalization.js', 'utf8'));

function assert(condition, message) {
  if (!condition) {
    throw new Error(message);
  }
}

function assertFields(actual, expected, message) {
  assert(JSON.stringify(actual) === JSON.stringify(expected), message + ': ' + JSON.stringify(actual));
}

function createDocument() {
  const elements = {};
  [
    'custom_name_block',
    'custom_name',
    'custom_how_block',
    'custom_how',
    'custom_what_block',
    'custom_what',
    'custom_disclaimer'
  ].forEach(function (id) {
    elements[id] = {style: {display: 'none'}, textContent: ''};
  });

  return {
    elements: elements,
    getElementById: function (id) {
      return elements[id];
    }
  };
}

assert(base64_decode('4pyTIMOgIGxhIG1vZGU=') === '✓ à la mode', 'UTF-8 Base64 decoding must remain compatible');

const russianLink = personalization_link(
  {origin: 'https://natribu.org', protocol: 'https:', host: 'natribu.org'},
  '/',
  ['Имя', '', '']
);
assert(russianLink.indexOf('https://natribu.org/#') === 0, 'Russian links must use the current HTTPS origin and root path');

const localLink = personalization_link(
  {protocol: 'http:', host: 'localhost:8080'},
  '/en/',
  ['', 'Reason', '']
);
assert(localLink.indexOf('http://localhost:8080/en/#') === 0, 'Links must preserve the current local origin and locale path');

const combinations = [
  ['', '', ''],
  ['Имя', '', ''],
  ['', 'Причина', ''],
  ['', '', 'Совет'],
  ['Имя', 'Причина', ''],
  ['Имя', '', 'Совет'],
  ['', 'Причина', 'Совет'],
  ['Имя', 'Причина', 'Совет']
];

combinations.forEach(function (fields) {
  const payload = personalization_payload(fields);
  const encoded = base64_encode(payload).replace(/=/g, '').replace(/\//g, '-');
  const decoded = personalization_decode(encoded);
  const restored = personalization_fields_from_payload(decoded);
  const documentMock = createDocument();
  const displayed = personalization_display(documentMock, restored);

  assertFields(restored, fields, 'Round-trip must preserve every field combination');
  assert(displayed === personalization_has_content(fields), 'Display result must match content presence');
  assert(documentMock.elements.custom_name_block.style.display === (fields[0] ? 'inline' : 'none'), 'Name visibility must match its value');
  assert(documentMock.elements.custom_how_block.style.display === (fields[1] ? 'list-item' : 'none'), 'Reason visibility must match its value');
  assert(documentMock.elements.custom_what_block.style.display === (fields[2] ? 'list-item' : 'none'), 'Advice visibility must match its value');
  assert(documentMock.elements.custom_disclaimer.style.display === (displayed ? 'block' : 'none'), 'Disclaimer visibility must match displayed fields');
});

assertFields(
  personalization_fields(['  Имя  ', '\tПричина\n', '   ']),
  ['Имя', 'Причина', ''],
  'Outer whitespace must not create phantom content'
);

const documentMock = createDocument();
personalization_display(documentMock, ['<img src=x onerror=alert(1)>', '', '']);
assert(documentMock.elements.custom_name.textContent === '<img src=x onerror=alert(1)>', 'Custom text must be assigned as textContent');

const legacyEncoded = fs.readFileSync(__dirname + '/fixtures/legacy_personalization_cp1251.txt', 'utf8').trim();
const legacyUrl = new URL('https://natribu.org/?' + legacyEncoded);
assert(legacyUrl.pathname === '/', 'Legacy fixture must cover a root URL without a language');
const legacyFields = personalization_fields_from_payload(personalization_decode(legacyUrl.search.slice(1)));
assertFields(legacyFields, [
  'старший менеджер Егор Потихонько!',
  'ты дико задолбал нашу Анечку попытками положить руку ей на коленку. Она тебе сказать стесняется, а мне отсюда все видно.',
  'остань от Ани немедленно и отодвинь свой стол на метр! Иначе я спущусь в зал и ты получишь по морде факсом прямо на глазах у клиентов.'
], 'Legacy CP1251 query link must remain readable');

assert(personalization_cp1251_decode('\xA8\xB8\xC0\xFF') === 'ЁёАя', 'CP1251 edge characters must decode correctly');

let invalidPayloadRejected = false;
try {
  personalization_decode('censorship_mode=on');
} catch (error) {
  invalidPayloadRejected = true;
}
assert(invalidPayloadRejected, 'Ordinary query parameters must not be treated as personalization');

let incompleteFieldsRejected = false;
try {
  personalization_fields_from_payload(personalization_decode('Zm9v'));
} catch (error) {
  incompleteFieldsRejected = true;
}
assert(incompleteFieldsRejected, 'Base64 without three personalization fields must not be displayed');

console.log('Editor personalization tests passed.');
