<?php
const VERSION_EXCLUDE = ['nightly', 'beta', 'alpha'];

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

$archs = ['x64', 'arm64'];
$oses = ['linux', 'darwin', 'win32'];

/**
 * We skip over unstable and atom-shell releases
 */
function get_versions() {
    `rm -rf electron-src`;
    `git clone https://github.com/electron/electron.git electron-src`;
    chdir("electron-src");

    $versions = [];
    foreach(explode("\n", shell_exec("git tag -l")) as $version) {
        foreach(VERSION_EXCLUDE as $needle) {
            if (stripos($version, $needle) !== false) {
                continue 2;
            }
        }
        // Atom shell was renamed to electron in this release (17th April 2015)
        if (version_compare($version, 'v0.24.0', '<')) {
            continue;
        }

        $versions[] = $version;
    }

    chdir("..");
    `rm -rf electron-src`;

    return $versions;
}

foreach(get_versions() as $version) {
    foreach($oses as $os) {
        foreach($archs as $arch) {

            // No releases were made for these combinations
            // Apple Silicon support added in v11: https://www.electronjs.org/blog/apple-silicon
            if (version_compare($version, 'v11.0.0', '<') and $os=='darwin' and $arch=='arm64') {
                continue;
            }

            // https://github.com/electron/electron/pull/10219
            // v1.8.0 was the first arm64 release
            if (version_compare($version, 'v1.8.0', '<') and $os=='linux' and $arch=='arm64') {
                continue;
            }

            // 6.0.9 was the first ARM64 windows release (backport)
            // https://github.com/electron/electron/pull/20260
            if (version_compare($version, 'v6.0.9', '<') and $os=='win32' and $arch=='arm64') {
                continue;
            }

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
