# [electron-fingerprints](https://github.com/captn3m0/electron-fingerprints/packages/1337118) ![Zero Dependencies](https://img.shields.io/badge/Dependencies-Zero-blue) ![GitHub release (latest by date)](https://img.shields.io/github/v/release/captn3m0/electron-fingerprints) ![GitHub tag (latest SemVer)](https://img.shields.io/github/v/tag/captn3m0/electron-fingerprints) ![GitHub repo size](https://img.shields.io/github/repo-size/captn3m0/electron-fingerprints)

Generates fingerprints for electron version detection by downloading electron releases and generating checksums (sha1 hashes) of the files contained in each release. Published as a lookup table on the GitHub NPM Registry.

## why

You can use this to guess which electron version is being used in a given application.
A given electron version is (almost always) tightly bound to a node and chrome release as well, so
you get a better sense of what the application is running.

Written as the backend for [`which-electon`][we].

## install

See [the GitHub documentation](https://docs.github.com/en/packages/working-with-a-github-packages-registry/working-with-the-npm-registry#installing-a-package) to configure the GitHub Packages NPM Registry.

Install from the command line:

```shell
npm install @captn3m0/electron-fingerprints
```

Install via package.json:

```json
"@captn3m0/electron-fingerprints": "*"
```

## usage

This repository only contains the raw data files, see [which-electron][we] for a usable package. The `lookup.json` files are published as the `@captn3m0/electron-fingerprints` package on the GitHub NPM Package Registry as well as on [GitHub Releases][releases]. Programmatic usage is still possible:

```javascript
const lookup = require("@captn3m0/electron-fingerprints");
// baf786083f482c1f035e50e105b5f7475af1e00b = sha1(ffmpeg.dll)
lookup["win32-x64"]["baf786083f482c1f035e50e105b5f7475af1e00b"];
// ["v1.4.3", "v1.4.4", "v1.4.5"]
```

You can sort or filter the returned versions if needed. If you'd like to access the raw data, see `HACKING.md` for a schema description. If you'd like to use this in a project that doesn't use NPM, you can use this repository as a git submodule and track the `main` branch for updates.

## supported releases

All _Stable_ electron releases for the following architectures are fingerprinted:

- `linux-x64`
- `linux-arm64`
- `darwin-x64` (Mac OS)
- `win32-x64` (Windows)
- `win32-arm64` (Windows)
- `darwin-arm64` (Apple Silicon)

A list of release fingerprints is under the `hashes` directory. Releases made when Electron was still called `atom-shell` are not supported (Before April 2015).

## versioning

Releases are versioned by the date on which they were made (as per UTC).

## license

Released under WTFPL.

[we]: https://github.com/captn3m0/which-electron
[releases]: https://github.com/captn3m0/electron-fingerprints/releases
