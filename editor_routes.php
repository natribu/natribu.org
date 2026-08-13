<?php

if (isset($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === __FILE__) {
    header('Location: /');
    exit();
}

function editor_language_from_request_uri($request_uri)
{
    $path = parse_url($request_uri, PHP_URL_PATH);
    if (!is_string($path)) {
        return null;
    }

    if (preg_match('~^/(?:editor|editor\.php)/?$~', $path)) {
        return 'ru';
    }

    if (preg_match('~^/(?:editor|editor\.php)/([^/]+)/?$~', $path, $matches)) {
        return $matches[1];
    }

    return null;
}

function editor_url($lang)
{
    if ($lang === 'ru') {
        return '/editor/';
    }

    return '/editor/' . $lang . '/';
}

function editor_canonical_redirect_url($request_uri, $lang)
{
    $path = parse_url($request_uri, PHP_URL_PATH);
    $canonical_url = editor_url($lang);

    if ($path === $canonical_url) {
        return null;
    }

    return $canonical_url;
}
