<template>
  <div>
    <div class="reset-pass">重设密码</div>
    <el-form
      ref="loginForm"
      :model="loginForm"
      :rules="loginRules"
      autocomplete="on"
      label-position="left"
      label-width="30px"
    >
      <el-form-item prop="mobile">
        <el-input
          ref="mobile"
          v-model="loginForm.mobile"
          placeholder="手机号"
          name="mobile"
          type="text"
          tabindex="1"
          autocomplete="on"
           class="inputItem"
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
           class="inputItem"
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
            class="inputItem"
          >
            <div slot="prefix">
              <svg-icon icon-class="password" fill="#fff" />
            </div>
            <div slot="suffix" @click="showPwd">
              <svg-icon
                :icon-class="passwordType === 'password' ? 'eye' : 'eye-open'"
                fill="#fff"
              />
            </div>
          </el-input>
        </el-form-item>
      </el-tooltip>

      <el-tooltip
        v-model="capsTooltip"
        content="Caps lock is On"
        placement="right"
        manual
      >
        <el-form-item prop="repassword">
          <el-input
            :key="passwordType"
            ref="password"
            v-model="loginForm.repassword"
            :type="passwordType"
            placeholder="确认密码密码"
            name="password"
            tabindex="2"
            autocomplete="on"
            @keyup.native="checkCapslock"
            @blur="capsTooltip = false"
            @keyup.enter.native="handleRegister"
             class="inputItem"
          >
            <div slot="prefix">
              <svg-icon icon-class="password" fill="#fff" />
            </div>
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
          width: 366px;
          height: 48px;
          background: #12A9A4;
          border-radius: 10px 10px 10px 10px;
          border:none;
          color:#fff;
          position: relative;
          left:50%;
           transform: translateX(-50%);
           margin-bottom:20px
        "
        @click.native.prevent="handleForgetpass"
        >找回密码</el-button
      >
    </el-form>
      <div class="back-reg" @click="backlogin">返回密码登录</div>
  </div>
</template>

<script>
import { validMobile, validEmail } from "@/utils/validate";
import { config } from "@/utils/publicUtil";
import { getView } from "diandi-admin/lib/api/addons/store.js";
import { sendCode, userForgetpass } from "diandi-admin/lib/api/admin/user.js";
import { getConfig } from "diandi-admin/lib/api/system/website.js";

export default {
  name: "Forget",
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

    const validateRePassword = (rule, value, callback) => {
      if (value !== this.loginForm.password) {
        callback(new Error("两次输入的密码不同"));
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
        repassword: "",
      },
      sendText: "获取验证码",
      loginRules: {
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
        repassword: [
          {
            required: true,
            trigger: "blur",
            validator: validateRePassword,
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
    getConfigWebsite() {
      getConfig({}).then((res) => {
        if (res.code === 200) {
          this.is_send_code = Number(res.data.is_send_code);
          console.log("getConfigWebsite", res);
        }
      });
    },
    backlogin() {
      this.$router.push({ path: "/login" });
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
    handleForgetpass() {
      this.$refs.loginForm.validate((valid) => {
        if (valid) {
          this.loading = true;
          userForgetpass(this.loginForm)
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
          that.$store.dispatch("app/setBlocs", res.data);
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
        type: "forgetpass",
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
.ver-code {
  color:rgb(18, 169, 164);
  font-size: 12px;
}
.back-reg {
  text-align: center;
  color:rgb(18, 169, 164);
  font-size: 15px;
}
.reset-pass {
  font-size: 15px;
  font-weight: bold;
  /* color: #3e6bd4; */
  color:rgb(18, 169, 164);
  text-align: center;
  margin-bottom: 30px;
}
</style>