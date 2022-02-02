<?php
const VERSION_EXCLUDE = ['nightly', 'beta', 'alpha'];

// Command to fetch the list of versions from upstream
const FETCH_VERSIONS_COMMAND = "git ls-remote -q --tags https://github.com/electron/electron.git |grep -v '\^{}' |cut -f2 | sed -s 's/refs\/tags\///g' ";

const MISSING_VERSIONS = ["v1.3.11-linux-x64","v1.3.11-darwin-x64","v1.3.11-win32-x64",
    "v1.4.9-linux-x64","v1.4.9-darwin-x64","v1.4.9-win32-x64","v1.8.0-linux-x64",
    "v1.8.0-linux-arm64","v1.8.0-darwin-x64","v1.8.0-win32-x64","v13.6.4-linux-x64",
    "v13.6.4-linux-arm64","v13.6.4-darwin-x64","v13.6.4-darwin-arm64","v13.6.4-win32-x64",
    "v13.6.4-win32-arm64","v13.6.5-linux-x64","v13.6.5-linux-arm64","v13.6.5-darwin-x64",
    "v13.6.5-darwin-arm64","v13.6.5-win32-x64","v13.6.5-win32-arm64","v2.1.0-unsupported-20180809-linux-x64",
    "v2.1.0-unsupported-20180809-linux-arm64","v2.1.0-unsupported-20180809-darwin-x64","v2.1.0-unsupported-20180809-win32-x64",
    "v9.0.6-linux-x64","v9.0.6-linux-arm64","v9.0.6-darwin-x64","v9.0.6-win32-x64","v9.0.6-win32-arm64"
];

// https://stackoverflow.com/a/54325258/368328
function rsearch($dir) {
    $dir = new RecursiveDirectoryIterator($dir);
    $dir->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
    $ite = new RecursiveIteratorIterator($dir);

    foreach($ite as $file) {
         yield $file->getPathName();
    }
}

function known_missing_version($version, $os, $arch) {
    return in_array("$version-$os-$arch", MISSING_VERSIONS);
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
    $versions = [];
    foreach(explode("\n", shell_exec(FETCH_VERSIONS_COMMAND)) as $version) {
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

    return $versions;
}

function release_exists($url) {
    exec("curl --silent -I -o /dev/null -w '%{http_code}' $url", $output);
    if (trim($output[0]) == '404') {
        return false;
    } else {
        return true;
    }
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

                if (known_missing_version($version, $os, $arch)) {
                    continue;
                }

                echo $url . PHP_EOL;

                if (!release_exists($url)) {
                    echo "[DL:404] $url\n";
                } else if (download_release($url, $zipfile)) {
                    extract_release($zipfile, $output);
                    generateFingerprint($version, $output, $hash_file);
                } else {
                    echo "[DL:FAIL] $version\n";
                }
            }
        }
    }
}
