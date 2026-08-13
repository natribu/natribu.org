function personalization_fields(values) {
  var fields = [];
  var i;

  for (i = 0; i < 3; i++) {
    fields[i] = String(values[i] || '').replace(/^\s+|\s+$/g, '');
  }

  return fields;
}

function personalization_has_content(fields) {
  fields = personalization_fields(fields);
  return !!(fields[0] || fields[1] || fields[2]);
}

function personalization_payload(fields) {
  return personalization_fields(fields).join(' % ');
}

function personalization_link(current_location, page_path, fields) {
  var origin = current_location.origin || (current_location.protocol + '//' + current_location.host);
  var encoded = base64_encode(personalization_payload(fields)).replace(/=/g, '').replace(/\//g, '-');

  return origin + page_path + '#' + encoded;
}

function personalization_fields_from_payload(payload) {
  var values = String(payload || '').split(/\s*%\s*/);

  if (values.length < 3) {
    throw new Error('Invalid personalization fields');
  }

  return personalization_fields(values);
}

function personalization_cp1251_decode(binary) {
  var extended_characters = [
    '\u0402', '\u0403', '\u201A', '\u0453', '\u201E', '\u2026', '\u2020', '\u2021',
    '\u20AC', '\u2030', '\u0409', '\u2039', '\u040A', '\u040C', '\u040B', '\u040F',
    '\u0452', '\u2018', '\u2019', '\u201C', '\u201D', '\u2022', '\u2013', '\u2014',
    '\uFFFD', '\u2122', '\u0459', '\u203A', '\u045A', '\u045C', '\u045B', '\u045F',
    '\u00A0', '\u040E', '\u045E', '\u0408', '\u00A4', '\u0490', '\u00A6', '\u00A7',
    '\u0401', '\u00A9', '\u0404', '\u00AB', '\u00AC', '\u00AD', '\u00AE', '\u0407',
    '\u00B0', '\u00B1', '\u0406', '\u0456', '\u0491', '\u00B5', '\u00B6', '\u00B7',
    '\u0451', '\u2116', '\u0454', '\u00BB', '\u0458', '\u0405', '\u0455', '\u0457'
  ];
  var decoded = '';
  var code;
  var i;

  for (i = 0; i < binary.length; i++) {
    code = binary.charCodeAt(i);
    if (code < 128) {
      decoded += String.fromCharCode(code);
    } else if (code >= 192) {
      decoded += String.fromCharCode(1040 + code - 192);
    } else {
      decoded += extended_characters[code - 128];
    }
  }

  return decoded;
}

function personalization_decode(encoded) {
  var normalized = String(encoded || '').replace(/-/g, '/');
  var binary;

  if (!normalized || !/^[A-Za-z0-9+/]+={0,2}$/.test(normalized) || normalized.length % 4 === 1) {
    throw new Error('Invalid personalization payload');
  }

  binary = base64_decode_binary(normalized);

  try {
    return decodeURIComponent(escape(binary));
  } catch (error) {
    return personalization_cp1251_decode(binary);
  }
}

function personalization_display(document_root, fields) {
  var field_config = [
    ['custom_name_block', 'custom_name', 'inline'],
    ['custom_how_block', 'custom_how', 'list-item'],
    ['custom_what_block', 'custom_what', 'list-item']
  ];
  var has_content = false;
  var i;
  var block;
  var value;

  fields = personalization_fields(fields);

  for (i = 0; i < field_config.length; i++) {
    block = document_root.getElementById(field_config[i][0]);
    value = document_root.getElementById(field_config[i][1]);
    value.textContent = fields[i];
    block.style.display = fields[i] ? field_config[i][2] : 'none';
    has_content = has_content || !!fields[i];
  }

  document_root.getElementById('custom_disclaimer').style.display = has_content ? 'block' : 'none';
  return has_content;
}
