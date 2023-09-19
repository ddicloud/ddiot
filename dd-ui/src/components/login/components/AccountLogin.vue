<template>
  <div>
    <el-form
      ref="loginForm"
      :model="loginForm"
      :rules="loginRules"
      autocomplete="on"
       label-width="40px"
       style="padding-bottom:40px"
    >
      <el-form-item prop="username">
        <el-input
          ref="username"
          v-model="loginForm.username"
          placeholder="请输入用户名/手机号"
          name="username"
          type="text"
          tabindex="1"
          autocomplete="on"
          class="inputItem"
        >
          <svg-icon slot="prefix" icon-class="zhanghu_de" fill="#fff" :size='40'/>

          <!-- <template slot="prepend">
            <svg-icon icon-class="user" fill="#fff" />
          </template> -->
        </el-input>
      </el-form-item>

      <el-tooltip
        v-model="capsTooltip"
        content="Caps lock is On"
        placement="right"
        manual
      >
        <el-form-item prop="password">
          <el-input
            :key="passwordType"
            ref="password"
            v-model="loginForm.password"
            :type="passwordType"
            placeholder="请输入登录密码"
            name="password"
            tabindex="2"
            autocomplete="on"
            @keyup.native="checkCapslock"
            @blur="capsTooltip = false"
            @keyup.enter.native="handleLogin"
             class="inputItem"
          >
            <svg-icon slot="prefix" icon-class="mima" fill="#fff" :size='36'/>

            <div slot="suffix" @click="showPwd" class="suffix">
              <svg-icon
                :icon-class="passwordType === 'password' ? 'eye' : 'eye-open'"
                fill="#fff"
              />
            </div>
          </el-input>
        </el-form-item>
      </el-tooltip>

       <el-row :gutter="20">
              <el-col :span="12" :offset="0" style="display:flex;align-items: center; margin-bottom: 38px;padding-left:49px">
                <div style="width: 20px;
height: 20px;
background: #FFFFFF;
border-radius: 5px;
opacity: 1;
margin-right:10px;
  display: flex;
  justify-content: center;
  align-items: center;
"  @click="showBingoFn">
                <img src="@/static/img/bingo.png" alt="" v-show="showBingo" width="12px">
                </div>
                <el-button
                  type="text"
                  style="color: #9b9b9b; font-size: 18px；cursor:none;"
                  >记住密码</el-button
                >
              </el-col>
              <el-col :span="12" :offset="0" class="text-right" style="padding-right:49px">
                <el-button
                  type="text"
                  style="color: #12A9A4; font-size: 18px"
                  @click.native.prevent="handleForget"
                  >忘记密码?</el-button
                >
              </el-col>
            </el-row>

      <el-button
        :loading="loading"
        class="margin-top-sm"
        style="
          width: 366px;
          height: 48px;
          background: #12A9A4;
          border-radius: 10px 10px 10px 10px;
          border:none;
          color:#fff;
          position: relative;
          left:50%;
           transform: translateX(-50%);
        "
        @click.native.prevent="handleLogin"
        >登录</el-button
      >
    </el-form>
  </div>
</template>

<script>
import { validUsername } from "@/utils/validate";
import { config } from "@/utils/publicUtil";
const { modeType, siteName, store_id, bloc_id } = config;
import { getView } from "diandi-admin/lib/api/addons/store.js";
import { Message } from "element-ui";
export default {
  name: "AccountLogin",
  data() {
    const validateUsername = (rule, value, callback) => {
      if (!validUsername(value)) {
        callback(new Error("请输入正确的用户名"));
      } else {
        callback();
      }
    };
    const validatePassword = (rule, value, callback) => {
      if (value.length < 6) {
        callback(new Error("密码不能小于6位"));
      } else {
        callback();
      }
    };
    return {
      showBingo:false,
      loginFormType: "login",
      sitaName: siteName,
      loginForm: {
        type: 1,
        username: "",
        password: "",
      },
      loginRules: {
        password: [
          {
            required: true,
            trigger: "blur",
            validator: validatePassword,
          },
        ],
      },
      passwordType: "password",
      capsTooltip: false,
      loading: false,
      showDialog: false,
      redirect: undefined,
      otherQuery: {},
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
  mounted() {
    if (this.loginForm.username === "") {
      this.$refs.username.focus();
    } else if (this.loginForm.password === "") {
      this.$refs.password.focus();
    }
  },
  methods: {
    // handleRegister() {
    //   this.$router.push({ path: "/register" });
    // },
    showBingoFn(){
      this.showBingo = !this.showBingo
    },
    handleForget() {
      console.log('forget');
      this.$router.push({ path: "/forget" });
    },
    checkCapslock(e) {
      const { key } = e;
      this.capsTooltip = key && key.length === 1 && key >= "A" && key <= "Z";
    },
    showPwd() {
      if (this.passwordType === "password") {
        this.passwordType = "";
      } else {
        this.passwordType = "password";
      }
      this.$nextTick(() => {
        this.$refs.password.focus();
      });
    },
    handleLogin() {
      this.$refs.loginForm.validate((valid) => {
        if (valid) {
          this.loading = true;
          this.$store
            .dispatch("user/login", this.loginForm)
            .then((response) => {
              if (response.code === 200) {
                if (response.data.addons) {
                  let pathUrl = `/${response.data.addons.module_name}/default/index.vue`;
                  this.initStoreList(response.data.addons);
                  console.log("initStoreList", {
                    path: pathUrl,
                    query: this.otherQuery,
                  });
                  this.$router.push({
                    path: pathUrl,
                    query: this.otherQuery,
                  });
                  this.loading = false;
                  return false;
                } else {
                  this.$store.dispatch("settings/setMenuType", "system");
                }
                // const redirect = this.redirect === '/'?"/dashboard":this.redirect
                const redirect =
                  this.redirect === "/" ? "/bea_cloud/default/index.vue" : this.redirect;
                this.$router.push({
                  path: redirect || "/bea_cloud/default/index.vue",
                  // path: redirect || "/dashboard",
                  query: this.otherQuery,
                });
                this.loading = false;
              }
            })
            .catch(() => {
              this.loading = false;
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
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
      this.$store.dispatch("settings/setMenuType", data.module_name);
      if (data.module_info) {
        that.$store.dispatch("settings/setPlugins", data.module_info);
      }
      if (data.store_id) {
        getView(data.store_id).then((res) => {
          that.$store.dispatch("App/setBlocs", res.data);
          that.$store.dispatch("elForm/changeSetting", {
            key: "attachmentUrl",
            value: res.data.config.attachmentUrl,
          });
        });
      } else {
        // 如果是单商户模式
        // 提醒他后台需要设置默认的商户权限
        if (modeType === "unit") {
          that.$store.dispatch("App/setBlocs", {
            store_id: store_id,
            bloc_id: bloc_id,
            name: siteName,
          });
        }
        // else {
        //   // 如果是多商户模式
        //   // 提醒他切换到对应的商户后操作
        //   Message({
        //     message: "切换到对应的商户后操作",
        //     type: "error",
        //     duration: 5 * 1000,
        //   });
        // }
      }
    },
  },
};
</script>

<style scoped>
span.svg-container {
  font-size: 16px;
  padding: 15px;
  background: #e5e5e5;
  border-radius: 4px 0px 0px 4px;
}
.account-reg{
  float: right;
  color: #3161D1;
  font-size:7px;

}
.suffix{
    line-height: 50px;
  }
input:-webkit-autofill {
        box-shadow: 0 0 0px 1000px rgba(54,71,130,0.1) inset !important;
        -webkit-text-fill-color: #fff !important;
        -webkit-background-clip:text;
      }
</style>
