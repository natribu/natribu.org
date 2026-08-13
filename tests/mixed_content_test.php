<?php

$root = dirname(__DIR__);
$extensions = ['css', 'html', 'js', 'json', 'php', 'shtml', 'txt', 'wml'];
$failures = [];
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    $path = $file->getPathname();
    $relative_path = substr($path, strlen($root) + 1);
    if (
        strpos($relative_path, '.git/') === 0
        || strpos($relative_path, '_docs/') === 0
        || strpos($relative_path, 'tests/') === 0
        || !in_array(strtolower($file->getExtension()), $extensions, true)
    ) {
        continue;
    }

    $contents = file_get_contents($path);
    $patterns = [
        '/(?:src|background|data|codebase|poster)\s*=\s*\\?\s*["\']?http:\/\//i',
        '/url\(\s*["\']?http:\/\//i',
        '/@import\s+(?:url\()?\s*["\']?http:\/\//i',
        '/http:\/\/(?:www\.)?natribu\.org/i',
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $contents, $match, PREG_OFFSET_CAPTURE)) {
            $line = substr_count(substr($contents, 0, $match[0][1]), "\n") + 1;
            $failures[] = $relative_path . ':' . $line . ' ' . $match[0][0];
        }
    }
}

if ($failures) {
    fwrite(STDERR, "Insecure public URL references found:\n" . implode("\n", $failures) . "\n");
    exit(1);
}

echo "Mixed content tests passed.\n";
