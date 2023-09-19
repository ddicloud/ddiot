<template>
  <div>
    <div class="reset-pass">账号注册</div>
    <el-form
      ref="loginForm"
      :model="loginForm"
      :rules="loginRules"
      autocomplete="on"
      label-position="left"
    >
      <el-form-item prop="username">
        <el-input
          ref="username"
          v-model="loginForm.username"
          placeholder="用户名"
          name="username"
          type="text"
          tabindex="1"
          autocomplete="on"
        >
          <template slot="prefix">
            <svg-icon icon-class="user" fill="#fff" />
          </template>
        </el-input>
      </el-form-item>
      <el-form-item prop="email">
        <el-input
          ref="email"
          v-model="loginForm.email"
          placeholder="邮箱"
          name="email"
          type="text"
          tabindex="1"
          autocomplete="on"
        >
          <template slot="prefix">
            <svg-icon icon-class="email" fill="#fff" />
          </template>
        </el-input>
      </el-form-item>
      <el-form-item prop="mobile">
        <el-input
          ref="mobile"
          v-model="loginForm.mobile"
          placeholder="手机号"
          name="mobile"
          type="text"
          tabindex="1"
          autocomplete="on"
        >
          <template slot="prefix">
            <svg-icon icon-class="mobile" fill="#fff" />
          </template>
        </el-input>
      </el-form-item>

      <el-form-item
        class="verification-input"
        prop="sms_code"
        v-if="is_send_code === 1"
      >
        <el-input
          ref="sms_code"
          v-model="loginForm.sms_code"
          type="number"
          placeholder="短信验证码"
          name="sms_code"
          tabindex="2"
          autocomplete="on"
        >
          <template slot="prefix">
            <svg-icon icon-class="verification" fill="#fff" />
          </template>
          <template slot="suffix">
            <div
              class="ver-code"
              :disabled="disabledCodeBtn"
              @click="sendSmsCode"
            >
              {{ sendText }}
            </div>
          </template>
        </el-input>
      </el-form-item>

      <el-form-item prop="invitation_code">
        <el-input
          ref="invitation_code"
          v-model="loginForm.invitation_code"
          placeholder="邀请码"
          name="invitation_code"
          type="text"
          tabindex="1"
          autocomplete="on"
        >
          <template slot="prefix">
            <svg-icon icon-class="invitation" fill="#fff" />
          </template>
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
            placeholder="密码"
            name="password"
            tabindex="2"
            autocomplete="on"
            @keyup.native="checkCapslock"
            @blur="capsTooltip = false"
            @keyup.enter.native="handleRegister"
          >
            <template slot="prefix">
              <svg-icon icon-class="password" fill="#fff" />
            </template>
            <div slot="suffix" @click="showPwd">
              <svg-icon
                :icon-class="passwordType === 'password' ? 'eye' : 'eye-open'"
                fill="#fff"
              />
            </div>
          </el-input>
        </el-form-item>
      </el-tooltip>

      <el-button
        :loading="loading"
        size="medium"
        style="
          width: 100%;
          margin-bottom: 30px;
          background-color: #3e6bd4;
          color: #fff;
        "
        @click.native.prevent="handleRegister"
        >注册</el-button
      >
    </el-form>
    <!-- <div class="back-reg text-pointer" @click="login">登录</div>  -->
  </div>
</template>

<script>
import { validMobile, validEmail } from "@/utils/validate";
import { config } from "@/utils/publicUtil";
import { getView } from "diandi-admin/lib/api/addons/store.js";
import { sendCode, userSignup } from "diandi-admin/lib/api/admin/user.js";
import { getConfig } from "diandi-admin/lib/api/system/website.js";

export default {
  name: "Register",
  data() {
    const validatemobile = (rule, value, callback) => {
      if (!validMobile(value)) {
        callback(new Error("请输入正确的手机号"));
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
    const validateEmail = (rule, value, callback) => {
      if (!validEmail(value)) {
        callback(new Error("请输入正确的邮箱"));
      } else {
        callback();
      }
    };
    return {
      disabledCodeBtn: false,
      loginFormType: "login",
      sitaName: config.siteName,
      is_send_code: 0,
      loginForm: {
        type: 2,
        mobile: "",
        sms_code: null,
        password: "",
        invitation_code: "",
      },
      sendText: "获取验证码",
      loginRules: {
        email: [{ required: true, trigger: "blur", validator: validateEmail }],
        mobile: [
          { required: true, trigger: "blur", validator: validatemobile },
        ],
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
    if (this.loginForm.mobile === "") {
      this.$refs.mobile.focus();
    } else if (this.loginForm.password === "") {
      this.$refs.password.focus();
    }
  },
  created() {
    this.getConfigWebsite();
  },
  methods: {
     login() {
      this.$router.push({ path: "/login" });
    },
    getConfigWebsite() {
      getConfig({}).then((res) => {
        if (res.code === 200) {
          this.is_send_code = Number(res.data.is_send_code);
          console.log("getConfigWebsite", res);
        }
      });
    },
    checkCapslock(e) {
      const { key } = e;
      this.capsTooltip = key && key.length === 1 && key >= "A" && key <= "Z";
    },
    handleForget() {},
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
    handleRegister() {
      this.$refs.loginForm.validate((valid) => {
        if (valid) {
          this.loading = true;
          userSignup(this.loginForm)
            .then((res) => {
              if (res.code === 200) {
                this.loading = false;
                this.$message.success(res.message);
                this.$router.push({ path: "/login" });
              } else {
                this.$message.error(res.message);
              }
            })
            .catch((err) => {
              console.log(err);
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
      console.log("登录成功initStoreList");
      this.$store.dispatch("permission/setMenuType", data.module_name);
      if (data.store_id) {
        getView(data.store_id).then((res) => {
          that.$store.dispatch("App/setBlocs", res.data);
          that.$store.dispatch("elForm/changeSetting", {
            key: "attachmentUrl",
            value: res.data.config.attachmentUrl,
          });
        });
      }
    },
    sendSmsCode() {
      sendCode({
        mobile: this.loginForm.mobile,
        type: "register",
      }).then((res) => {
        if (res.code === 200) {
          this.countDown(30);
          this.$message.success(res.message);
        } else {
          this.$message.error(res.message);
        }
      });
    },
    // 倒计时方法
    countDown(time) {
      if (time === 0) {
        this.disabledCodeBtn = false;
        this.sendText = "重新发送";
        return;
      } else {
        this.disabledCodeBtn = true;
        this.sendText = time + "s";
        time--;
      }
      setTimeout(() => {
        this.countDown(time);
      }, 1000);
    },
  },
};
</script>

<style>
</style>
