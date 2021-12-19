# [electron-fingerprints](https://www.npmjs.com/package/electron-fingerprints) ![npm bundle size](https://img.shields.io/bundlephobia/minzip/electron-fingerprints) ![npm](https://img.shields.io/npm/v/electron-fingerprints) ![NPM](https://img.shields.io/npm/l/electron-fingerprints) ![Zero Dependencies](https://img.shields.io/badge/Dependencies-Zero-blue)

Generates fingerprints for electron version detection by downloading electron releases and generating checksums (sha1 hashes) of the files contained in each release. Published as a lookup table on NPM.

## why

You can use this to guess which electron version is being used in a given application.
A given electron version is (almost always) tightly bound to a node and chrome release as well, so
you get a better sense of what the application is running.

Written as the backend for [`which-electon`][we].

## install

```shell
npm install electron-fingerprints
```

## usage

This is just the raw data files, see [which-electron][we] for a usable package. The `lookup.json` file is published as the `electron-fingerprints` package on NPM. Programmatic usage is still possible:

```javascript
const lookup = require("electron-fingerprints");
// baf786083f482c1f035e50e105b5f7475af1e00b = sha1(ffmpeg.dll)
lookup["win32-x64"]["baf786083f482c1f035e50e105b5f7475af1e00b"];
// ["v1.4.3", "v1.4.4", "v1.4.5"]
```

You can sort or filter the returned versions if needed. If you'd like to access the raw data, see `HACKING.md` for a schema description.

## supported releases

All _Stable_ electron releases for the following architectures are fingerprinted:

- linux-x64
- linux-arm64
- darwin-x64 (Mac OS)
- win32-x64 (Windows)
- win32-arm64 (Windows)
- darwin-arm64 (Apple Silicon)

A list of release fingerprints is under the `hashes` directory. Releases made when Electron was still called `atom-shell` are not supported (Before April 2015).

## versioning

Starting from 2021.12.19 release, releases are versioned by YYYY.MM.DD format.

## which files are present?

Here's a count of the most common extensions present across all releases:

```
   1620 dat
   1620 version
   1650 LICENSE
   1744 Current
   1744 Resources
   1762 so
   1830 html
   1844 PkgInfo
   1944 modulemap
   2202 dylib
   2354 js
   2437 asar
   3237 bin
   4272 Helper
   6142 plist
   6224 dll
  34235 Electron
  45360 h
  84596 pak
```

`.pak` files are currently excluded from the lookup table, but the other files should be easily usable. While lookup up, try to get hashes from the following extensions:

```
.h
.dll
.plust
.Helper
.bin
.asar
.dylib
.so
.plist
Electron Framework
Electron Helper
Electron Helper (GPU)
Electron Helper (Plugin)
Electron Helper (Renderer)
electron
(GPU)
(Plugin)
(Renderer)
```

`which-electron` uses the following extensions and filenames to fingerprint:

- `.h`, `.dll`, `.bin`, `.asar`, `.dylib`, `.so`, `.exe`
- `electron framework`, `squirrel`, `electron`, `electron helper`, `chrome_100_percent`, `chrome_200_percent`

## license

Released under WTFPL.

[we]: https://github.com/captn3m0/which-electron
