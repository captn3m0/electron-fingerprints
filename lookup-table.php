<?php

$lookup = [
	'win32-x64' => [],
	'linux-x64' => [],
	'darwin-x64' => []
];

foreach(glob('hashes/*.json') as $h) {
	$data = json_decode(file_get_contents($h));
	$name = basename($h, '.json');
	list($os, $arch, $version) = explode('-', $name, 3);
	foreach($data as $file=>$hash) {
		$subTable = "$os-$arch";
		if(!isset($lookup[$subTable][$hash])) {
			$lookup[$subTable][$hash] = [];
		}
		$lookup[$subTable][$hash][] = $version;
	}
}

$json = json_encode($lookup);
file_put_contents('lookup.json', $json);