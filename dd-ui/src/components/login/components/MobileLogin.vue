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
      <el-form-item prop="mobile">
        <el-input
          ref="mobile"
          v-model="loginForm.mobile"
          placeholder="请输入手机号"
          name="mobile"
          type="text"
          tabindex="1"
          autocomplete="on"
          class="inputItem"
        >
          <div slot="prefix" style="margin-left:10px">
            +86
            <!-- <svg-icon icon-class="mobile" fill="#fff" /> -->
          </div>
        </el-input>
      </el-form-item>

      <el-form-item
        v-if="is_send_code"
        class="verification-input"
        prop="sms_code"
      >
        <el-input
          ref="sms_code"
          v-model="loginForm.sms_code"
          type="number"
          placeholder="短信验证码"
          name="sms_code"
          tabindex="2"
          class="inputItem"
        >
          <div slot="suffix" class="ver-code" style="line-height:50px" @click="sendSmsCode">
            获取验证码
            <!-- <svg-icon icon-class="mobile" fill="#fff" /> -->
          </div>
          <!-- <template slot="append">
              <el-button size="mini" type="danger" :disabled="disabledCodeBtn" @click="sendSmsCode">
                {{sendText}}
              </el-button>
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
            placeholder="密码"
            label="密码"
            name="password"
            tabindex="2"
            autocomplete="on"
            @keyup.native="checkCapslock"
            @blur="capsTooltip = false"
            @keyup.enter.native="handleLogin"
          >
            <template slot="prepend">
              <svg-icon icon-class="password" fill="#fff" />
            </template>
            <el-button slot="append" @click="showPwd">
              <svg-icon
                :icon-class="passwordType === 'password' ? 'eye' : 'eye-open'"
                fill="#fff"
              />
            </el-button>
          </el-input>
        </el-form-item>
      </el-tooltip>

      <el-button
        :loading="loading"
        class="margin-top-sm"
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
        "
        @click.native.prevent="handleLogin"
      >登录</el-button>

    </el-form>
  </div>
</template>

<script>
import { validMobile } from '@/utils/validate'
import { config } from '@/utils/publicUtil'
import { getView } from 'diandi-admin/lib/api/addons/store.js'
import { sendCode } from 'diandi-admin/lib/api/admin/user.js'

export default {
  name: 'MobileLogin',
  props: ['is_send_code'],
  data() {
    const validatemobile = (rule, value, callback) => {
      if (!validMobile(value)) {
        callback(new Error('请输入正确的手机号'))
      } else {
        callback()
      }
    }
    const validatePassword = (rule, value, callback) => {
      if (value.length < 6) {
        callback(new Error('密码不能小于6位'))
      } else {
        callback()
      }
    }
    return {
      disabledCodeBtn: false,
      loginFormType: 'login',
      sitaName: config.siteName,
      loginForm: {
        type: 2,
        mobile: '',
        sms_code: null,
        password: ''
      },
      sendText: '获取验证码',
      loginRules: {
        mobile: [
          { required: true, trigger: 'blur', validator: validatemobile }
        ],
        password: [
          {
            required: true,
            trigger: 'blur',
            validator: validatePassword
          }
        ]
      },
      passwordType: 'password',
      capsTooltip: false,
      loading: false,
      showDialog: false,
      redirect: undefined,
      otherQuery: {}
    }
  },
  watch: {
    $route: {
      handler: function(route) {
        const query = route.query
        if (query) {
          this.redirect = query.redirect
          this.otherQuery = this.getOtherQuery(query)
        }
      },
      immediate: true
    }
  },
  mounted() {
    if (this.loginForm.mobile === '') {
      this.$refs.mobile.focus()
    } else if (this.loginForm.password === '') {
      this.$refs.password.focus()
    }
  },
  created() {
    console.log('is_send_code', this.is_send_code)
  },
  methods: {
    handleRegister() {
      this.$router.push({ path: '/register' })
    },
    checkCapslock(e) {
      const { key } = e
      this.capsTooltip = key && key.length === 1 && key >= 'A' && key <= 'Z'
    },
    handleForget() {},
    showPwd() {
      if (this.passwordType === 'password') {
        this.passwordType = ''
      } else {
        this.passwordType = 'password'
      }
      this.$nextTick(() => {
        this.$refs.password.focus()
      })
    },
    handleLogin() {
      this.$refs.loginForm.validate((valid) => {
        console.log('登录验证', valid)
        if (valid) {
          this.loading = true
          this.$store
            .dispatch('user/login', this.loginForm)
            .then((response) => {
              console.log('登录成功', response)
              if (response.code === 200) {
                console.log('登录成功')
                if (response.data.addons) {
                  console.log('登录成功有插件')
                  const pathUrl = `/${response.data.addons.module_name}/default/index.vue`
                  this.initStoreList(response.data.addons)
                  this.$router.push({
                    path: pathUrl,
                    query: this.otherQuery
                  })
                  this.loading = false
                  return false
                } else {
                  this.$store.dispatch('permission/setMenuType', 'system')
                }
                const redirect =
                  this.redirect === '/' ? '/dashboard' : this.redirect
                this.$router.push({
                  path: redirect || '/dashboard',
                  query: this.otherQuery
                })
                this.loading = false
              }
            })
            .catch((err) => {
              console.log(err)
              this.loading = false
            })
        } else {
          console.log('error submit!!')
          return false
        }
      })
    },
    getOtherQuery(query) {
      return Object.keys(query).reduce((acc, cur) => {
        if (cur !== 'redirect') {
          acc[cur] = query[cur]
        }
        return acc
      }, {})
    },
    initStoreList: function(data) {
      const that = this
      console.log('登录成功initStoreList')
      this.$store.dispatch('permission/setMenuType', data.module_name)
      if (data.module_info) {
        that.$store.dispatch('settings/setPlugins', data.module_info)
      }
      if (data.store_id) {
        getView(data.store_id).then((res) => {
          that.$store.dispatch('App/setBlocs', res.data)
          that.$store.dispatch('elForm/changeSetting', {
            key: 'attachmentUrl',
            value: res.data.config.attachmentUrl
          })
        })
      }
    },
    sendSmsCode() {
      sendCode({
        mobile: this.loginForm.mobile,
        type: 'login'
      }).then((res) => {
        if (res.code === 200) {
          this.countDown(30)
          this.$message.success(res.message)
        } else {
          this.$message.error(res.message)
        }
      })
    },
    // 倒计时方法
    countDown(time) {
      if (time === 0) {
        this.disabledCodeBtn = false
        this.sendText = '重新发送'
        return
      } else {
        this.disabledCodeBtn = true
        this.sendText = time + 's'
        time--
      }
      setTimeout(() => {
        this.countDown(time)
      }, 1000)
    }
  }
}
</script>

<style scoped>
.ver-code {
  color: #3e6bd4;
  font-size: 12px;
  background-color: #fff;
  height: 40px;
}
.el-form-item__content .el-input-group{
  width: 90%;
}
</style>
