<template>
  <div class="navbar">
    <div class="conent">
      <el-row type="flex" :gutter="10">
        <el-col :lg="6" :md="8" :sm="12" :xs="10" class="justify-start flex-l">
          <div class="bloc-top">
            <hamburger
              id="hamburger-container"
              :is-active="sidebar.opened"
              class="hamburger-container"
              @toggleClick="toggleSideBar"
            />
          </div>
          <search id="header-search" class="search-input-menu hidden-xs-only" />
        </el-col>
        <el-col :lg="18" :md="16" :sm="12" :xs="14" class="user-right-main">
          <div class="flex-l justify-end align-center padding-right">
            <!-- 业务开始 -->
            <el-dropdown class="right-nav" trigger="hover">
              <div class="user-right  text-pointer">
                <div class="navbar-addons">
                  <svg-icon
                    icon-class="sys-top-business"
                    :size="16"
                  />
                </div>
              </div>

              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item
                  v-for="(item,index) in addons"
                  :key="index"
                  @click.native="goAddons(item)"
                >{{ item.title }}</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
            <!-- 业务结束 -->
            <el-dropdown class="right-nav">
              <div class="user-right" v-if="num > 0">
                <el-badge :value="num" class="item">
                  <div class="navbar-notic text-pointer">
                    <svg-icon
                      icon-class="sys-top-message"
                      :size="16"
                    />
                  </div>
                </el-badge>
              </div>

              <div
                v-else
                class="navbar-notic user-right text-pointer"
              >
                <svg-icon
                  icon-class="sys-top-message"
                  :size="16"
                />
              </div>

              <el-dropdown-menu slot="dropdown" style="width: 280px">
                <el-dropdown-item>
                  <div class="center">
                    <div>消息中心</div>
                    <!-- <div class="icon" @click="delectRow">
                      <i class="el-icon-delete" />
                    </div> -->
                  </div>
                </el-dropdown-item>
                <el-dropdown-item divided>
                  <div
                    v-if="messageist"
                    style="color: #b4b4b4; font-size: 11px"
                  >
                    {{ messageist.title }}
                  </div>
                  <div v-if="messageist" style="font-size: 9px">
                    {{ messageist.content }}
                  </div>
                  <div v-if="!messageist" class="text-center">暂无消息</div>
                </el-dropdown-item>
                <el-dropdown-item divided @click.native="checkall">
                  <div class="all text-center">查看全部</div>
                  <!-- <router-link to="/system/notification.vue">
                    <el-dropdown-item>查看全部</el-dropdown-item>
                  </router-link> -->
                </el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
            <el-dropdown class="right-nav" trigger="hover">
              <div class="user-right">
                <div class="flex user-right-img">
                  <el-image
                    class="navbar-img text-pointer"
                    fit="contain"
                    :src="userinfo.avatar?userinfo.avatar: headImg"
                  />
                </div>
                <div class="flex">
                  <div class="sub-el-icon el-icon-arrow-down" />
                </div>
              </div>

              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item
                  v-permission="['总管理员']"
                  @click.native="backSys"
                >超级后台</el-dropdown-item>
                <!-- <router-link to="/profile/index.vue" /> -->
                <el-dropdown-item @click.native="goprofile">
                  个人资料</el-dropdown-item>
                <el-dropdown-item
                  v-permission="['总管理员']"
                  @click.native="clearCache"
                >清除缓存</el-dropdown-item>
                <el-dropdown-item
                  divided
                  @click.native="logout"
                ><span
                  style="display: block"
                >退出登陆</span></el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </div>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
import headImg from '@/static/img/head.png'
import Search from '@/components/HeaderSearch'
import { fetchList } from 'diandi-admin/lib/api/addons/addons.js'
import {
  clearCache,
  getMessagesList,
  getmeaasgenum
} from 'diandi-admin/lib/api/system/system.js'
import { mapGetters } from 'vuex'
import Hamburger from '@/components/Hamburger'
import { messagelistDelete } from 'diandi-admin/lib/api/admin/message.js'
export default {
  name: 'NavbarTop',
  components: {
    Search,
    Hamburger
  },
  data() {
    return {
      userinfo: '',
      input1: '',
      messageist: {},
      num: 0,
      headImg: headImg,
      addons: []
    }
  },
  computed: {
    ...mapGetters(['sidebar', 'userInfo', 'userBloc', 'device', 'webSite'])
  },
  created() {
    const that = this
    console.log('that.userInfo', that.userInfo)
    that.userinfo = that.userInfo.userInfo
    that.logo = that.userInfo.webSite.blogo
    this.getMessage()
    this.getMessagenum()
    this.getAddons()
  },
  methods: {
    getAddons() {
      fetchList().then((res) => {
        this.addons = res.data.dataProvider.allModels.filter(item => item.identifie !== 'diandi_cloud' && item.identifie !== 'diandi_hub')
      })
    },
    // 获取消息
    getMessage() {
      getMessagesList().then((res) => {
        this.messageist = res.data.dataProvider.allModels[0]
      })
    },
    // 获取未读消息数量
    getMessagenum() {
      getmeaasgenum().then((res) => {
        this.num = res.data.unread
      })
    },
    toggleSideBar() {
      this.$store.dispatch('app/toggleSideBar')
    },
    async logout() {
      await this.$store.dispatch('user/logout')
      this.$router.push(`/login?redirect=${this.$route.fullPath}`)
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
    },
    // 消息中心
    checkall() {
      this.$router.push({
        name: 'system-notification-index'
      })
    },
    // 账号设置
    setaccount() {
      this.$router.push({
        name: 'system-account-index'
      })
    },
    // 个人资料
    goprofile() {
      this.$router.push({
        name: 'profile-index'
      })
    },
    // 切换店铺
    changestore() {
      this.$router.push({
        name: 'system-store-index'
      })
    },
    // 删除
    delectRow() {
      const that = this
      messagelistDelete(that.messageist.id).then((response) => {
        if (response.code === 200) {
          that.getMessage()
          that.$message.success(response.message)
        } else {
          that.$message.error(response.message)
        }
      })
    },
    goAddons: function(item) {
      const menuType = item.identifie
      this.$store.dispatch('settings/setMenuType', menuType)
      this.$store.dispatch('settings/setPlugins', item)
      const path = '/' + menuType + '/default/index.vue'
      console.log('path', path, item)

      this.$router.push({ path: path })
    }
  }
}
</script>

<style lang="scss" scoped>
.navbar {
  overflow: hidden;
  position: relative;
  .bloc-top {
    display: flex;
    padding-left: 5px;
    .bloc-logo {
      width: 45px;
      height: 60px;
      display: grid;
      align-items: center;
      .el-image {
        width: 35px;
        height: 35px;
        border-radius: 4px;
      }
    }
  }
  .user-right-main {
    align-items: center;
    justify-content: right;
    display: grid;
    .user-right{
      display: flex;
      // margin: 0 16px;
      &-img {
        margin-right: 8px;
      }
    }
    .right-nav:nth-child(2) {
      margin: 0 32px;
    }
    // .user-right:last-child {
    //   margin: 5px;
    // }

  }

  .flex {
    display: flex;
  }

  .flex-l{
    display: flex;
  }

  .conent {
    margin: auto 0;
    height: 64px;
    line-height: 64px;
    background: #fff;

    .navbar-img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
    }
    .navbar-notic {
      line-height: initial;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #FFFFFF;
      opacity: 1;
      align-items: center;
      border: 1px solid #DDDDDD;
      display: grid;
      justify-content: center;
      &:hover {
        color: #fff;
        background: #00AFC7;
        .svg-icon {
          color: #FFFFFF;
        }
      }
      .svg-icon {
          color: #141414;
      }
    }
    .navbar-addons{
      line-height: initial;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      opacity: 1;
      align-items: center;
      background: #FFFFFF;
      border: 1px solid #DDDDDD;
      display: grid;
      justify-content: center;
      &:hover {
        color: #fff;
        background: #00AFC7;
        .svg-icon {
          color: #FFFFFF;
        }
      }
      .svg-icon {
          color: #141414;
      }
    }
  }
  .icon {
    margin: auto 0;
    font-size: 4px;
  }
  .navbar-title {
    font-size: 16px;
  }
}
.all {
  color: #646464;
  font-size: 11px;
}
.center {
  display: inline-flex;
  justify-content: space-between;
  width: 250px;
}
.search-input-menu {
  flex-direction: row-reverse;
}
.hamburger-container {
  float: left;
  cursor: pointer;
  transition: background 0.3s;
  -webkit-tap-highlight-color: transparent;

  &:hover {
    background: rgba(0, 0, 0, 0.025);
  }
}
</style>
