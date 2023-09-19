<template>
  <div class="login-containerw">
    <el-row type="flex" justify="center" :gutter="20">
      <el-col :lg="12" :md="12" :xs="0">
        <div class="left_msg">
          <div class="left_msg_top">酒店公寓管理系统</div>
          <div class="left_line" />
          <div class="left_msg_msg">智慧管理服务平台</div>
          <div class="left_msg_msg" />
        </div>
      </el-col>

      <el-col :lg="12" :md="12" :xs="24">
        <div class="login-form">
          <div class="login-right">
            <div class="title-container">
              <!-- <img src="@/static/img/logo1.png" alt=""> -->
              <span class="title">酒店公寓管理系统</span>
            </div>
            <div class="login-form-item">
              <!-- <el-tabs  v-model="loginFormType" @tab-click="handleTypeClick"> -->
              <!-- <el-tab-pane name="AccountLogin">
                    <span slot="label" class="svg_st">
                      <svg-icon icon-class="zhanghu_se" fill="#fff" :size='36'/>
                      账户</span>
                </el-tab-pane> -->
              <account-login class="margin-top-sm" />
              <!-- <el-tab-pane name="MobileLogin">
                  <span slot="label" class="svg_st">
                     <svg-icon icon-class="shouji_se" fill="#fff" :size='36'/>
                    手机</span>
                  <mobile-login
                    :is_send_code="is_send_code"
                    class="margin-top-sm"
                  />
                </el-tab-pane>
                <el-tab-pane name="qcordLog">
                  <span slot="label" class="svg_st">
                     <svg-icon icon-class="wechat_se" fill="#fff" :size='36' class="icon"/>
                    微信
                  </span>
                    <Qcord style="margin-left:10px"/>
                </el-tab-pane> -->
              <!-- <el-tab-pane label="快捷登录" name="FastLogin">角色管理</el-tab-pane> -->
              <!-- </el-tabs> -->
            </div>

            <!-- <el-row :gutter="20" class="padding-lr-sm">
              <el-col :span="12" :offset="0">
                <el-button
                  type="text"
                  style="color: #9b9b9b; font-size: 8px"
                  @click.native.prevent="handleRegister"
                  >免费注册</el-button
                >
              </el-col>
              <el-col :span="12" :offset="0" class="text-right">
                <el-button
                  type="text"
                  style="color: #9b9b9b; font-size: 8px"
                  @click.native.prevent="handleForget"
                  >忘记密码</el-button
                >
              </el-col>
            </el-row> -->
          </div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { validUsername } from '@/utils/validate'
import SocialSign from './components/SocialSignin'
import AccountLogin from './components/AccountLogin'
import MobileLogin from './components/MobileLogin'
import { config } from '@/utils/publicUtil'
import { getConfig } from 'diandi-admin/lib/api/system/website.js'
import Qcord from './components/Qcord'
import { getView } from 'diandi-admin/lib/api/addons/store.js'
import { mapGetters } from 'vuex'

export default {
  name: 'Login',
  components: {
    SocialSign,
    Qcord,
    AccountLogin,
    MobileLogin
  },
  computed: {
    ...mapGetters(['size'])
  },
  data() {
    return {
      loginFormType: 'AccountLogin',
      sitaName: config.siteName,
      showDialog: false,
      is_send_code: false,
      website: {}
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
  created() {
    console.log('size', this.size)
    this.getConfigWebsite()

    // window.addEventListener('storage', this.afterQRScan)
  },
  destroyed() {
    // window.removeEventListener('storage', this.afterQRScan)
  },
  methods: {
    getConfigWebsite() {
      getConfig({}).then((res) => {
        if (res.code === 200) {
          this.is_send_code = Number(res.data.is_send_code)
          this.website = res.data
          console.log('getConfigWebsite', res)
        }
      })
    },
    checkCapslock(e) {
      const { key } = e
      this.capsTooltip = key && key.length === 1 && key >= 'A' && key <= 'Z'
    },
    handleTypeClick(tab, event) {
      if (this.loginFormType === 'AccountLogin') {
      }
      console.log(tab, event, this.loginFormType)
    },
    qcordLog() {
      console.log('login')
      this.$router.push({ path: '/qcord' })
    },
    handleRegister() {
      this.$router.push({ path: '/register' })
    },
    handleForget() {
      this.$router.push({ path: '/forget' })
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
      this.$store.dispatch('settings/setMenuType', data.module_name)
      if (data.store_id) {
        getView(data.store_id).then((res) => {
          that.$store.dispatch('App/setBlocs', res.data)
          that.$store.dispatch('elForm/changeSetting', {
            key: 'attachmentUrl',
            value: res.data.config.attachmentUrl
          })
        })
      }
    }
  }
}
</script>
<style lang="scss" scoped>
@import "./style/login.scss";
.svg_st{
  display: flex;
  .svg-icon{
    margin-left: 14px;
    transform: translateY(-1px) translateX(7px);
  }
  .icon{
     transform: translateY(2px) translateX(3px);
  }
}
.el-tabs.el-tabs--top{
  height: 414px;
}
</style>
