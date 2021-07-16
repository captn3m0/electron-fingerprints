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
const lookup = require('electron-fingerprints')
// baf786083f482c1f035e50e105b5f7475af1e00b = sha1(ffmpeg.dll)
lookup['win32-x64']['baf786083f482c1f035e50e105b5f7475af1e00b']
// ["v1.4.3", "v1.4.4", "v1.4.5"]
```

You can sort or filter the returned versions if needed.

## supported releases

All Stable electron releases for the following architectures are fingerprinted:

- linux-x64
- darwin-x64 (Mac OS)
- win32-x64 (Windows)

A list of release fingerprints is under the `hashes` directory.

## todo

- [ ] Add support for darwin-arm

## which files are present?

Here's a count of file extensions present across all releases:

```
      9 framework/Frameworks
      9 Frameworks
     13 app/Contents/MacOS/crash_report_sender
     13 crash_report_sender
     13 framework/Versions/A/Libraries/Libraries
     13 framework/Versions/A/Resources/Inspector
     13 Inspector
     14 htaccess
     15 npmignore
     15 txt
     26 1
     26 strings
     30 yml
     45 markdown
     50 framework/ReactiveObjC
     50 framework/Versions/A/ReactiveObjC
     59 4
     70 11
     72 app/Contents/MacOS/Electron Helper (GPU)
     72 app/Contents/MacOS/Electron Helper (Plugin)
     72 app/Contents/MacOS/Electron Helper (Renderer)
     72 framework/Helpers
     72 framework/Versions/A/Helpers/chrome_crashpad_handler
     94 chrome_crashpad_handler
     94 Helpers
    100 ReactiveObjC
    171 (GPU)
    171 (Plugin)
    171 (Renderer)
    185 chrome-sandbox
    223 app/Contents/MacOS/Electron Helper EH
    223 app/Contents/MacOS/Electron Helper NP
    223 EH
    223 NP
    230 framework/Versions/A/Resources/crashpad_handler
    238 svg
    262 framework/ReactiveCocoa
    262 framework/Versions/A/ReactiveCocoa
    312 app/Contents/MacOS/Electron
    312 app/Contents/MacOS/Electron Helper
    312 DS_Store
    312 framework/Electron Framework
    312 framework/Libraries
    312 framework/Mantle
    312 framework/Squirrel
    312 framework/Versions/A/Electron Framework
    312 framework/Versions/A/Mantle
    312 framework/Versions/A/Resources/ShipIt
    312 framework/Versions/A/Squirrel
    357 crashpad_handler
    436 electron
    436 exe
    436 ShipIt
    449 Libraries
    745 json
    772 ReactiveCocoa
    773 nib
    774 icns
    786 framework/Headers
    786 framework/Modules
    872 Framework
    872 Mantle
    872 Squirrel
   1120 png
   1158 Headers
   1158 Modules
   1248 framework/Resources
   1248 framework/Versions/Current
   1299 app/Contents/PkgInfo
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

## license

Released under WTFPL.

[we]: https://github.com/captn3m0/which-electron