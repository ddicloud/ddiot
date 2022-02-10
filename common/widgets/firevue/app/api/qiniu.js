export function getToken() {
  let that = this;
  that.$http.get('/backend/qiniu/upload/token', {a:1}).then((response) => {
      //响应成功回调
      if (response.data.code == 200) {
        
      }
  }, (response) => {
      //响应错误回调
      console.log(response)
  });

  return [];
}
