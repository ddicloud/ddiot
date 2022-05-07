/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-12 14:21:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-13 20:57:10
 */
module.exports = `<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="icon" href="<%= BASE_URL %>favicon.ico" />
    <title>店滴云</title>
  </head>
  <body>
    <noscript>
      <strong
        >We're sorry but biyi-framework-web doesn't work properly without
        JavaScript enabled. Please enable it to continue.</strong
      >
    </noscript>
    <div id="app"></div>
    <script src="<%= BASE_URL %>configs/config.js"></script>
    <script src="<%= BASE_URL %>configs/micro-service-config.js"></script>
    <!-- built files will be auto injected -->
  </body>
</html>
`
