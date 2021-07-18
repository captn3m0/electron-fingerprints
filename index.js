module.exports = {
  "linux-x64": require('./lookup/linux-x64'),
  "linux-arm64": require('./lookup/linux-arm64'),
  "darwin-x64": require('./lookup/darwin-x64'),
  "darwin-arm64": require('./lookup/darwin-arm64'),
  "win32-x64": require('./lookup/win32-x64'),
  "win32-arm64": require('./lookup/win32-arm64'),
}
