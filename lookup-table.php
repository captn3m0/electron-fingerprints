<?php

$lookup = [
    'darwin-x64' => [],
    'darwin-arm64' => [],
    'linux-x64' => [],
    'linux-arm64' => [],
    'win32-x64' => [],
    'win32-arm64' => [],
];

foreach(glob('hashes/*.json') as $h) {
    $data = json_decode(file_get_contents($h));
    $name = basename($h, '.json');
    list($os, $arch, $version) = explode('-', $name, 3);
    foreach($data as $file=>$hash) {
        // Including locales increases the file size by too much.
        if (strpos($file, '.pak') !== false and strlen(basename($file, '.pak') < 3)) {
            continue;
        }
        $subTable = "$os-$arch";
        if(!isset($lookup[$subTable][$hash])) {
            $lookup[$subTable][$hash] = [];
        }
        $lookup[$subTable][$hash][] = $version;
    }
}

foreach($lookup as $file => $data) {
    $json = json_encode($data);
    file_put_contents("lookup/$file.json", $json);
}
