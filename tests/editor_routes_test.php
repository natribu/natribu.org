<?php

require_once __DIR__ . '/../editor_routes.php';

$route_cases = [
    '/editor/' => 'ru',
    '/editor' => 'ru',
    '/editor/ru/' => 'ru',
    '/editor/ru' => 'ru',
    '/editor/en/' => 'en',
    '/editor/en?from=main' => 'en',
    '/editor.php' => 'ru',
    '/editor.php/en/' => 'en',
    '/editor//en/' => null,
    '/editor/en/more/' => null,
    '/not-editor/en/' => null,
];

foreach ($route_cases as $request_uri => $expected) {
    $actual = editor_language_from_request_uri($request_uri);
    if ($actual !== $expected) {
        fwrite(STDERR, sprintf(
            "Route %s: expected %s, got %s\n",
            $request_uri,
            var_export($expected, true),
            var_export($actual, true)
        ));
        exit(1);
    }
}

$url_cases = [
    'ru' => '/editor/',
    'en' => '/editor/en/',
    'ru2' => '/editor/ru2/',
];

foreach ($url_cases as $lang => $expected) {
    $actual = editor_url($lang);
    if ($actual !== $expected) {
        fwrite(STDERR, sprintf(
            "Language %s: expected %s, got %s\n",
            $lang,
            $expected,
            $actual
        ));
        exit(1);
    }
}

$redirect_cases = [
    ['/editor/', 'ru', null],
    ['/editor/?from=main', 'ru', null],
    ['/editor', 'ru', '/editor/'],
    ['/editor/ru/', 'ru', '/editor/'],
    ['/editor/en/', 'en', null],
    ['/editor/en', 'en', '/editor/en/'],
    ['/editor.php/en/', 'en', '/editor/en/'],
];

foreach ($redirect_cases as [$request_uri, $lang, $expected]) {
    $actual = editor_canonical_redirect_url($request_uri, $lang);
    if ($actual !== $expected) {
        fwrite(STDERR, sprintf(
            "Redirect for %s: expected %s, got %s\n",
            $request_uri,
            var_export($expected, true),
            var_export($actual, true)
        ));
        exit(1);
    }
}

echo "Editor route tests passed.\n";
