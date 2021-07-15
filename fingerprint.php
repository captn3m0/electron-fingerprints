<?php
// https://stackoverflow.com/a/54325258/368328
function rsearch($dir) {
    $dir = new RecursiveDirectoryIterator($dir);
    $dir->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
    $ite = new RecursiveIteratorIterator($dir);

    foreach($ite as $file) {
         yield $file->getPathName();
    }
}

function generateFingerprint($version, $output, $hash_file) {
	$manifest = [];

	$manifest['version'] = $version;
	foreach(rsearch($output) as $file) {
		$path = substr($file, strlen($output) + 1);
		$manifest[$path] = sha1_file($file);
	}
	$json = json_encode($manifest, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
	file_put_contents($hash_file, $json);
}

function download_release($url, $output) {
	@unlink($output);
	system("wget --quiet --max-redirect=5 '$url' -O /dev/shm/test.zip", $ret);

	return ($ret === 0);
}

function extract_release($input, $output) {
	$zip = new ZipArchive();
	if (!$zip->open($input)) {
		die("Download failed?");
	}
	`rm -rf $output`;
	mkdir($output);
	
	if(!$zip->extractTo($output)) {
		die("Failed extraction");
	}

	$zip->close();
}

$archs = ['x64'];
$oses = ['linux', 'darwin', 'win32'];

foreach(file('versions.txt', FILE_IGNORE_NEW_LINES) as $version) {
	foreach($oses as $os) {
		foreach($archs as $arch) {
			$hash_file = "hashes/$os-$arch-$version.json";
			if (!file_exists($hash_file)) {
				$zipfile = '/dev/shm/test.zip';
				$output = '/dev/shm/electron';
				$url = "https://github.com/electron/electron/releases/download/$version/electron-$version-$os-$arch.zip";
				echo $url . PHP_EOL;

				if (download_release($url, $zipfile)) {
					extract_release($zipfile, $output);
					generateFingerprint($version, $output, $hash_file);	
				} else {
					echo "[DL:FAIL] $version\n";
				}
			}			
		}
	}
}
