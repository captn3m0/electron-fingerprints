# electron-fingerprints

Generates fingerprints for electron version detection by downloading electron releases and generating checksums of the files contained in each release.

## why

You can use this to guess which electron version is being used in a given application. 
A given electron version is (almost always) tightly bound to a node and chrome release as well, so
you get a better sense of what the application is running.

Written as the backend for [`which-electon`][we].

## usage

This is just the raw data files, see [which-electron][we] for a usable package.

## LICENSE

Released under WTFPL.

[we]: https://github.com/captn3m0/which-electron