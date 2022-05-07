<template>
  <div id="app">
    <router-view />
  </div>
</template>

<style lang="scss">
/*每个页面公共css uParse为优化版本*/
@import "./styles/iconfont/iconfont.css";
</style>
<script>
import { mapState } from 'vuex'
export default {
  name: 'App',
  provide() {
    return {
      reload: this.reload
    }
  },
  computed: {
    ...mapState({
      accessToken: (state) => state.user.access_token,
      blocId: (state) => state.app.blocId,
      storeId: (state) => state.app.storeId
    })
  },
  watch: {
    accessToken(val) {
      console.log('accessToken', val)
      if (val) {
        this.$store.dispatch('settings/changeSetting', {
          key: 'uploadConf',
          value: {
            headers: {
              'access-token': this.accessToken,
              'bloc-id': this.blocId,
              'store-id': this.storeId
            }
          }
        })

        this.$upEleConf = function() {
          return {
            'access-token': this.accessToken,
            'bloc-id': this.blocId,
            'store-id': this.storeId
          }
        }
      }
    },
    blocId(val) {
      if (val) {
        this.$store.dispatch('settings/changeSetting', {
          key: 'uploadConf',
          value: {
            headers: {
              'access-token': this.accessToken,
              'bloc-id': this.blocId,
              'store-id': this.storeId
            }
          }
        })
        this.$upEleConf = function() {
          return {
            'access-token': this.accessToken,
            'bloc-id': this.blocId,
            'store-id': this.storeId
          }
        }
      }
    },
    storeId(val) {
      console.log('storeId', val)
      if (val) {
        this.$store.dispatch('settings/changeSetting', {
          key: 'uploadConf',
          value: {
            headers: {
              'access-token': this.accessToken,
              'bloc-id': this.blocId,
              'store-id': this.storeId
            }
          }
        })
        this.$upEleConf = function() {
          return {
            'access-token': this.accessToken,
            'bloc-id': this.blocId,
            'store-id': this.storeId
          }
        }
      }
    }
  },
  mounted() {
    this.innerWidth = window.innerWidth
  },
  methods: {
    // 通过声明reload方法，控制router-view的显示或隐藏，从而控制页面的再次加载
    reload() {
      this.isRouterAlive = false
      console.log()
      this.$nextTick(function() {
        this.isRouterAlive = true
      })
    }
  }
}
</script>
