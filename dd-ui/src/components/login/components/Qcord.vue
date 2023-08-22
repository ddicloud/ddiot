<template>
  <div class="qcord">
    <!-- <div class="qcord-login text-pointer" @click="qcordLog">用户登录</div> -->
    <!-- <div class="qcord-img">微信扫码登录</div> -->
    <div class="qcord-border" id="login_container">
      <!-- <el-image
        style="width: 200px; height: 200px"
        :src="require('@/static/common/loginbg.png')"
      /> -->
    </div>
    <!-- <div class="back-qcord" @click="handleRegister">微信扫码登录点滴云</div> -->
    <!-- <div class="back-reg" @click="handleRegister">没有账号，立即注册</div> -->
  </div>
</template>
<script>
export default {
  name: "Qcord",
  data() {
    return {};
  },
  mounted() {
    this.get_wx_qrcode();
  },
  methods: {
    get_wx_qrcode() {
      var obj = new WxLogin({
        self_redirect: false,
        id: "login_container",
        appid: "wx632d1154ca878ee1",
        scope: "snsapi_login",
        redirect_uri: encodeURIComponent(
          "https://www.dandicloud.com/admin/#/bea_cloud/default/index.vue"
        ),
        // state: Math.random(),
        style: "black",
        href: "data:text/css;base64,LmltcG93ZXJCb3ggLnFyY29kZSB7d2lkdGg6IDIwMHB4O30KLmltcG93ZXJCb3ggLnRpdGxlIHtkaXNwbGF5OiBub25lO30KLmltcG93ZXJCb3ggLmluZm8ge3dpZHRoOiAyMDBweDt9Ci5zdGF0dXNfaWNvbiB7ZGlzcGxheTpub25lfQouaW1wb3dlckJveCAuc3RhdHVzIHt0ZXh0LWFsaWduOiBjZW50ZXI7fQ==",
      });
    },
    handleRegister() {
      this.$router.push({ path: "/register" });
    },
    qcordLog() {
      this.$router.push({ path: "/login" });
    },
  },
};
</script>

<style>
.back-reg {
  text-align: center;
  color: #3e6bd4;
  font-size: 7px;
  /* margin-top: 20px; */
}
.qcord-img {
  font-size: 15px;
  font-weight: bold;
  color: #3e6bd4;
  text-align: center;
  padding-top: 60px;
}
.back-qcord {
  font-size: 9px;
  font-weight: bold;
  color: #afafb4;
  text-align: center;
  margin-top: -40px;
}
.qcord-border {
  /* width: 300px; */
  /* padding: 7px; */
  /* border-top: 1px solid; */
  /* border: 1px solid #e1e1e1; */
  /* margin: 0 auto; */
}
.qcord-login {
  margin-right: 20px;
}
</style>