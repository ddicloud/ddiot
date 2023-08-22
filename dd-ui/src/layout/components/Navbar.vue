<template>
  <div class="navbar">
    <div class="conent">
      <el-row class="dropdown-userinfo" :gutter="20">
        <el-col :lg="3" :md="4" :sm="5" class="hidden-xs-only" :offset="2">
          <div class="navbar-logo">
            <el-image :src="logo" class="navbar-logo-img" fit="contain" />
          </div>
        </el-col>
        <el-col :lg="14" :md="12" :sm="10" :xs="12">
          <div class="navbar-flex">
            <!-- <el-image
              style="width: 20px; height: 20px"
              :src="require('../../static/img/store.png')"
            /> -->
            <svg-icon
              icon-class="mystore"
              :size="20"
            />
            <div class="navbar-title">我的店铺</div>
          </div>
        </el-col>
        <el-col :lg="5" :md="6" :sm="7" :xs="12">
          <el-dropdown trigger="hover">
            <div class="navbar-flex">
              <div class="flex navbar-img">
                <el-image
                  style="height: 40px;margin: 5px;border-radius: 50%;"
                  class="navbar-img-el"
                  fit="contain"
                  :src="userinfo.avatar"
                />
              </div>
              <div class="flex">
                <div class="navbar-title">{{ userinfo.username }}</div>
              </div>
              <div class="flex">
                <div class="sub-el-icon el-icon-arrow-down" />
              </div>
            </div>
            <!-- <div>
                <el-image
                  style="width: 10px; height: 10px; margin-left: 20px"
                  :src="require('../../static/img/btom.png')"
                />
              </div> -->
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item
                v-permission="['总管理员']"
                @click.native="backSys"
              >超级后台</el-dropdown-item>
              <el-dropdown-item @click.native="goprofile">
                <!-- <router-link to="/profile/index.vue"> -->
                个人资料
                <!-- </router-link> -->
              </el-dropdown-item>

              <!-- <el-dropdown-item>
                <a target="_blank" href="https://www.ddicms.cn/"> 开发手册 </a>
              </el-dropdown-item> -->
              <el-dropdown-item
                v-permission="['总管理员']"
                @click.native="clearCache"
              >清除缓存</el-dropdown-item>
              <el-dropdown-item
                divided
                @click.native="logout"
              ><span style="display: block">退出登陆</span></el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { clearCache } from 'diandi-admin/lib/api/system/system.js'
export default {
  name: 'Navbar',
  components: {},
  data() {
    return {
      userinfo: '',
      logo: ''
    }
  },
  computed: {
    ...mapGetters(['userInfo'])
  },
  created() {
    const that = this
    console.log(that.userInfo)
    that.userinfo = that.userInfo.userInfo
    that.logo = that.userInfo.webSite.blogo
  },
  methods: {
    toggleSideBar() {
      this.$store.dispatch('app/toggleSideBar')
    },
    async logout() {
      await this.$store.dispatch('user/logout')
      this.$router.push(`/login?redirect=${this.$route.fullPath}`)
    },
    // 个人资料
    goprofile() {
      this.$router.push({
        name: 'profile-index'
      })
    },
    clearCache: function() {
      const that = this
      clearCache({
        cache: true,
        template: true
      }).then((res) => {
        const { code } = res
        if (code === 200) {
          that.$message.success('清理成功')
        }
      })
    },
    backSys() {
      this.$store.dispatch('settings/setMenuType', 'system')
      this.$router.push({ name: 'dashboard' })
    }
  }
}
</script>

<style lang="scss" scoped>
.navbar {
  overflow: hidden;
  position: relative;

  .conent {
    margin: auto 0;
    background: #fff;
    line-height: 60px;
    padding-left: 20px;
    padding-right: 20px;
    .navbar-logo {
      display: grid;
      align-items: center;
    }
    .navbar-logo-img {
      margin-top:5px;
      height: 50px;
    }
    .navbar-flex {
      display: flex;
      align-items: center;
      height: 60px;
    }
    .dropdown-userinfo{
      height: 60px;
    }
  }

  .navbar-title {
    font-size: 17px;
    padding: 0 5px;
  }
}
</style>
