const L = require(".");
const assert = require("assert");
const fs = require("fs");
const semver = require("semver");

function get_versions(arch) {
  return fs
    .readdirSync("hashes/")
    .filter((x) => {
      return x.startsWith(arch);
    })
    .map((x) => {
      return x.substring(arch.length + 1, x.length - 5);
    });
}

function get_versions_in_range(arch, min, max) {
  versions = get_versions(arch);
  return versions.filter((v) => {
    return semver.compare(v, min) - semver.compare(v, max);
  });
}

function get_highest_major_version(arch, major) {
  versions = get_versions(arch);
  return versions.reduce((prev, current) => {
    if (semver.gt(current, prev) && semver.major(current) == major) {
      return current;
    } else {
      return prev;
    }
  });
}

// ffmpeg.dll
assert.deepEqual(
  L["win32-x64"]["baf786083f482c1f035e50e105b5f7475af1e00b"],
  get_versions_in_range("win32-x64", "v1.4.3", "v1.4.5")
);

// libEGL.dylib
assert.deepEqual(
  L["darwin-x64"]["b904574843c22f7b39e986253b0c798548d2f01d"],
  get_versions_in_range("darwin-x64", "v12.0.2", "v12.2.3")
);

// chrome_100_percent.pak
assert.deepEqual(
  L["linux-arm64"]["942e5f5414a24a1aa1769b9f8614ff8fbf40dba3"],
  get_versions_in_range("linux-arm64", "v12.0.0", "v12.2.3")
);

// snapshot_blob.bin
assert.deepEqual(
  L["linux-x64"]["3fc441bcbacac544ba4af18dcd2b084694ae9409"],
  get_versions_in_range("linux-arm64", "v12.0.5", "v12.2.3")
);

// libGLESv2.dll
assert.deepEqual(L["win32-arm64"]["21f751ea45147f9e0b7107b8129ae4dd2fd1ccd6"], [
  "v12.0.15",
]);

// d3dcompiler_47.dll
assert.deepEqual(
  L["win32-x64"]["2256644f69435ff2fee76deb04d918083960d1eb"],
  get_versions_in_range("win32-arm64", "v10.0.0", "v16.99.99")
);
