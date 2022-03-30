<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ajax Put 上传</title>
  <style>
      h1, h2 {
          font-weight: normal;
      }
       #msg {
          margin-top: 10px;
      }
  </style>
</head>
<body>
<h1>Ajax Put 上传</h1>
<input id="fileSelector" type="file">
<input id="submitBtn" type="submit">
<div id="msg"></div>
<script src="https://unpkg.com/cos-js-sdk-v5/demo/common/cos-auth.min.js"></script>
<script>
  (function () {
      // 请求用到的参数
      var Bucket = 'diandu-1307995562';
      var Region = 'ap-hongkong';
      var protocol = location.protocol === 'https:' ? 'https:' : 'http:';
      var prefix = protocol + '//' + Bucket + '.cos.' + Region + '.myqcloud.com/';  // prefix 用于拼接请求 url 的前缀，域名使用存储桶的默认域名
       // 对更多字符编码的 url encode 格式
      var camSafeUrlEncode = function (str) {
          return encodeURIComponent(str)
              .replace(/!/g, '%21')
              .replace(/'/g, '%27')
              .replace(/\(/g, '%28')
              .replace(/\)/g, '%29')
              .replace(/\*/g, '%2A');
      };
       // 计算签名
      var getAuthorization = function (options, callback) {
          // var url = 'http://127.0.0.1:3000/sts-auth' +
        //   var url = '../server/sts.php';
          var url = '/sts';
          var xhr = new XMLHttpRequest();
          xhr.open('GET', url, true);
          xhr.onload = function (e) {
              var credentials;
              try {
                  credentials = (new Function('return ' + xhr.responseText))().credentials;
                //   alert(JSON.encode(credentials));
                console.log(credentials);
              } catch (e) {}
              if (credentials) {
                  callback(null, {
                      SecurityToken: credentials.sessionToken,
                      Authorization: CosAuth({
                          SecretId: credentials.tmpSecretId,
                          SecretKey: credentials.tmpSecretKey,
                          Method: options.Method,
                          Pathname: options.Pathname,
                      })
                  });
              } else {
                  console.error(xhr.responseText);
                  callback('获取签名出错');
              }
          };
          xhr.onerror = function (e) {
              callback('获取签名出错');
          };
          xhr.send();
      };
       // 上传文件
      var uploadFile = function (file, callback) {
          var Key = 'dir/' + file.name; // 这里指定上传目录和文件名
          getAuthorization({Method: 'PUT', Pathname: '/' + Key}, function (err, info) {
               if (err) {
                  alert(err);
                  return;
              }
               var auth = info.Authorization;
              var SecurityToken = info.SecurityToken;
              var url = prefix + camSafeUrlEncode(Key).replace(/%2F/g, '/');
              var xhr = new XMLHttpRequest();
              xhr.open('PUT', url, true);
              xhr.setRequestHeader('Authorization', auth);
              SecurityToken && xhr.setRequestHeader('x-cos-security-token', SecurityToken);
              xhr.upload.onprogress = function (e) {
                  console.log('上传进度 ' + (Math.round(e.loaded / e.total * 10000) / 100) + '%');
              };
              xhr.onload = function () {
                  if (/^2\d\d$/.test('' + xhr.status)) {
                      var ETag = xhr.getResponseHeader('etag');
                      callback(null, {url: url, ETag: ETag});
                  } else {
                      callback('文件 ' + Key + ' 上传失败，状态码：' + xhr.status);
                  }
              };
              xhr.onerror = function () {
                  callback('文件 ' + Key + ' 上传失败，请检查是否没配置 CORS 跨域规则');
              };
              xhr.send(file);
          });
      };
       // 监听表单提交
      document.getElementById('submitBtn').onclick = function (e) {
          var file = document.getElementById('fileSelector').files[0];
          if (!file) {
              document.getElementById('msg').innerText = '未选择上传文件';
              return;
          }
          file && uploadFile(file, function (err, data) {
              console.log(err || data);
              document.getElementById('msg').innerText = err ? err : ('上传成功，ETag=' + data.ETag);
          });
      };
  })();
</script>
</body>
</html>
