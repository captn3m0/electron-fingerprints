# [electron-fingerprints](https://www.npmjs.com/package/electron-fingerprints) ![npm bundle size](https://img.shields.io/bundlephobia/minzip/electron-fingerprints) ![npm](https://img.shields.io/npm/v/electron-fingerprints) ![NPM](https://img.shields.io/npm/l/electron-fingerprints) ![Zero Dependencies](https://img.shields.io/badge/Dependencies-Zero-blue)

Generates fingerprints for electron version detection by downloading electron releases and generating checksums of the files contained in each release.

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

## license

Released under WTFPL.

[we]: https://github.com/captn3m0/which-electron