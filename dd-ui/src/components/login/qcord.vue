<template>
  <div class="login-containerw">
    <el-row type="flex" justify="center" :gutter="20">
      <el-col>
        <div class="login-form">
          <div class="login-right">
            <qcord />
          </div>
        </div>
      </el-col>
    </el-row>

    <el-dialog
      :close-on-click-modal="false"
      title="Or connect with"
      :visible.sync="showDialog"
    >
      Can not be simulated on local, so please combine you own business
      simulation! ! !
      <br />
      <br />
      <br />
      <social-sign />
    </el-dialog>
  </div>
</template>

<script>
import { validUsername } from "@/utils/validate";
import SocialSign from "./components/SocialSignin";
import Qcord from "./components/Qcord";
import { config } from "@/utils/publicUtil";

import { getView } from "diandi-admin/lib/api/addons/store.js";

export default {
  components: {
    SocialSign,
    Qcord,
  },
  data() {
    return {
      loginFormType: "AccountLogin",
      sitaName: config.siteName,
      showDialog: false,
    };
  },
  watch: {
    $route: {
      handler: function (route) {
        const query = route.query;
        if (query) {
          this.redirect = query.redirect;
          this.otherQuery = this.getOtherQuery(query);
        }
      },
      immediate: true,
    },
  },
  created() {
    // window.addEventListener('storage', this.afterQRScan)
  },
  destroyed() {
    // window.removeEventListener('storage', this.afterQRScan)
  },
  methods: {
    checkCapslock(e) {
      const { key } = e;
      this.capsTooltip = key && key.length === 1 && key >= "A" && key <= "Z";
    },
    handleLogin() {
      this.$router.push({ path: "/login" });
    },
    handleTypeClick(tab, event) {
      if (this.loginFormType === "AccountLogin") {
      }
      console.log(tab, event, this.loginFormType);
    },
    handleRegister() {
      this.$router.push({ path: "/register" });
    },
    handleQcord() {
      this.$router.push({ path: "/forget" });
    },
    getOtherQuery(query) {
      return Object.keys(query).reduce((acc, cur) => {
        if (cur !== "redirect") {
          acc[cur] = query[cur];
        }
        return acc;
      }, {});
    },
    initStoreList: function (data) {
      const that = this;
      console.log("登录成功initStoreList");
      this.$store.dispatch("permission/setMenuType", data.module_name);
      if (data.store_id) {
        getView(data.store_id).then((res) => {
          that.$store.dispatch("app/setBlocs", res.data);
          that.$store.dispatch("elForm/changeSetting", {
            key: "attachmentUrl",
            value: res.data.config.attachmentUrl,
          });
        });
      }
    },
    // afterQRScan() {
    //   if (e.key === 'x-admin-oauth-code') {
    //     const code = getQueryObject(e.newValue)
    //     const codeMap = {
    //       wechat: 'code',
    //       tencent: 'code'
    //     }
    //     const type = codeMap[this.auth_type]
    //     const codeName = code[type]
    //     if (codeName) {
    //       this.$store.dispatch('LoginByThirdparty', codeName).then(() => {
    //         this.$router.push({ path: this.redirect || '/' })
    //       })
    //     } else {
    //       alert('第三方登录失败')
    //     }
    //   }
    // }
  },
};
</script>
<style lang="scss" scoped>
@import './style/login.scss';
</style>