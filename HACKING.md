# HACKING

There's two scripts:

## `fingerprint.php`

This downloads the relevant releases from GitHub, and generates hashes of all files contained within each release.

This includes all releases that were not:

1. nightly releases
2. beta releases
3. older than 0.24.0 (electron was called atom-shell before that)

All generated hashes are kept in `hashes/$version.json`. A sample snippet for the JSON structure:

```json
{
    "LICENSE": "10bfa95a2f25df14dfe6a55a9e73d9fa5becdb60",
    "LICENSES.chromium.html": "fa5b9f95d12b0044d6ae8dbf303ad46d43edea76",
    "version": "0e2ef13d37fb9a81b63ab1babfa39635722366a3",
    "Electron.app/Contents/PkgInfo": "9f9eea0cfe2d65f2c3d6b092e375b40782d08f31",
}
```

## `lookup-table.php`

This generates an inverted-lookup-table from all the hashes. So you can pass a hash and get a list of releases that specific hash was found in.
These are stored in the following architecture specific files:

- `lookup/darwin-arm64.json`
- `lookup/darwin-x64.json`
- `lookup/linux-arm64.json`
- `lookup/linux-x64.json`
- `lookup/win32-arm64.json`
- `lookup/win32-x64.json`

The schema for these files is fairly intuitive:

```json
{
  "sha1_hash": ["list", "of", "versions"],
  "sha1_hash": ["list", "of", "versions"]
}
```

