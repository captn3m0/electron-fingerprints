# electron-fingerprints ![npm bundle size](https://img.shields.io/bundlephobia/minzip/electron-fingerprints) ![npm](https://img.shields.io/npm/v/electron-fingerprints) ![NPM](https://img.shields.io/npm/l/electron-fingerprints) ![Zero Dependencies](https://img.shields.io/badge/Dependencies-Zero-blue)

Generates fingerprints for electron version detection by downloading electron releases and generating checksums of the files contained in each release.

## why

You can use this to guess which electron version is being used in a given application. 
A given electron version is (almost always) tightly bound to a node and chrome release as well, so
you get a better sense of what the application is running.

Written as the backend for [`which-electon`][we].

## usage

This is just the raw data files, see [which-electron][we] for a usable package. The `lookup.json` file is published as the `electron-fingerprints` package on NPM.

## supported releases

All Stable electron releases for the following architectures are fingerprinted:

- linux-x64
- darwin-x64 (Mac OS)
- win32-x64 (Windows)

A list of release fingerprints is under the `hashes` directory.

## LICENSE

Released under WTFPL.

[we]: https://github.com/captn3m0/which-electron