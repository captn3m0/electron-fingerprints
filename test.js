const L = require(".");
const assert = require("assert");

// ffmpeg.dll
assert.deepEqual(L["win32-x64"]["baf786083f482c1f035e50e105b5f7475af1e00b"], [
  "v1.4.3",
  "v1.4.4",
  "v1.4.5",
]);

// libEGL.dylib
assert.deepEqual(L["darwin-x64"]["b904574843c22f7b39e986253b0c798548d2f01d"], [
  "v12.0.10",
  "v12.0.11",
  "v12.0.12",
  "v12.0.13",
  "v12.0.14",
  "v12.0.15",
  "v12.0.2",
  "v12.0.3",
  "v12.0.4",
  "v12.0.5",
  "v12.0.6",
  "v12.0.7",
  "v12.0.8",
  "v12.0.9",
]);

// chrome_100_percent.pak
assert.deepEqual(L["linux-arm64"]["942e5f5414a24a1aa1769b9f8614ff8fbf40dba3"], [
  "v12.0.0",
  "v12.0.1",
  "v12.0.10",
  "v12.0.11",
  "v12.0.12",
  "v12.0.13",
  "v12.0.14",
  "v12.0.15",
  "v12.0.2",
  "v12.0.3",
  "v12.0.4",
  "v12.0.5",
  "v12.0.6",
  "v12.0.7",
  "v12.0.8",
  "v12.0.9",
]);

// snapshot_blob.bin
assert.deepEqual(L["linux-x64"]["3fc441bcbacac544ba4af18dcd2b084694ae9409"], [
  "v12.0.10",
  "v12.0.11",
  "v12.0.12",
  "v12.0.13",
  "v12.0.14",
  "v12.0.15",
  "v12.0.5",
  "v12.0.6",
  "v12.0.7",
  "v12.0.8",
  "v12.0.9",
]);

// libGLESv2.dll
assert.deepEqual(L["win32-arm64"]["21f751ea45147f9e0b7107b8129ae4dd2fd1ccd6"], [
  "v12.0.15",
]);

// d3dcompiler_47.dll
assert.deepEqual(L["win32-x64"]["2256644f69435ff2fee76deb04d918083960d1eb"], [
  "v10.0.0",
  "v10.0.1",
  "v10.1.0",
  "v10.1.1",
  "v10.1.2",
  "v10.1.3",
  "v10.1.4",
  "v10.1.5",
  "v10.1.6",
  "v10.1.7",
  "v10.2.0",
  "v10.3.0",
  "v10.3.1",
  "v10.3.2",
  "v10.4.0",
  "v10.4.1",
  "v10.4.2",
  "v10.4.3",
  "v10.4.4",
  "v10.4.5",
  "v10.4.6",
  "v10.4.7",
  "v11.0.0",
  "v11.0.1",
  "v11.0.2",
  "v11.0.3",
  "v11.0.4",
  "v11.0.5",
  "v11.1.0",
  "v11.1.1",
  "v11.2.0",
  "v11.2.1",
  "v11.2.2",
  "v11.2.3",
  "v11.3.0",
  "v11.4.0",
  "v11.4.1",
  "v11.4.10",
  "v11.4.2",
  "v11.4.3",
  "v11.4.4",
  "v11.4.5",
  "v11.4.6",
  "v11.4.7",
  "v11.4.8",
  "v11.4.9",
  "v12.0.0",
  "v12.0.1",
  "v12.0.10",
  "v12.0.11",
  "v12.0.12",
  "v12.0.13",
  "v12.0.14",
  "v12.0.15",
  "v12.0.2",
  "v12.0.3",
  "v12.0.4",
  "v12.0.5",
  "v12.0.6",
  "v12.0.7",
  "v12.0.8",
  "v12.0.9",
  "v13.0.0",
  "v13.0.1",
  "v13.1.0",
  "v13.1.1",
  "v13.1.2",
  "v13.1.3",
  "v13.1.4",
  "v13.1.5",
  "v13.1.6",
  "v13.1.7",
]);