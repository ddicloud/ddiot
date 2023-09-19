<template>
  <div class="store-main" style="padding:15px">
    <div class="store-search margin-sm">
      <el-input v-model="keywords" placeholder="搜索商户" />
    </div>
    <div class="store-list">

      <el-card
        v-for="(item, index) in list"
        v-show="item.name.toString().indexOf(keywords) >= 0 || !keywords"
        :key="index"
        class="box-card-store"
        :class="{'box-card-active':storeId === item.store_id}"
        :xs="24"
        shadow="hover"
        :body-style="{ padding: '10px' }"
      >
        <div slot="header" class="clearfix">
          <span><el-tag class="margin-right-xs" effect="plain" size="mini"> 总部</el-tag>{{ item.bloc.business_name }}</span>
          <el-button type="primary" style="float: right; padding: 3px;" @click="storeChange(item)">切换</el-button>
        </div>
        <el-row>
          <el-col>
            <el-col :span="24">
              <el-col :span="8">
                <div
                  class="store-logo"
                  :class="{ 'lines-cyan': index % 2 === 0 }"
                >
                  <el-image
                    :src="item.logo"
                    fit="contain"
                  />
                </div>
              </el-col>
              <el-col :span="16">
                <div class="addons-title">
                  {{ item.name }}
                </div>

                <div class="addons-desc">{{ item.address }}</div>

              <!-- <el-col :span="8">
                <el-button
                  type="primary"
                  size="mini"
                  @click="goAddons(item)"
                >使用<i
                  class="fa fa-arrow-circle-right margin-left-xs"
                /></el-button>
              </el-col> -->
              </el-col>
            </el-col>
          </el-col>
        </el-row>
      </el-card>
    </div>

  </div>
</template>

<script>
import {
  mapGetters
} from 'vuex'
import {
  getStorelist
} from 'diandi-admin/lib/api/addons/bloc.js'
import {
  getView
} from 'diandi-admin/lib/api/addons/store.js'
export default {
  name: 'SettingsStore',
  data() {
    return {
      currentDate: new Date(),
      list: [],
      storelist: [],
      keywords: ''
    }
  },
  computed: {
    ...mapGetters(['storeId'])
  },
  mounted: function() {
    this.getList()
  },
  created() {
    const that = this
    that.getList()
  },
  methods: {
    getList() {
      const that = this
      that.listLoading = true
      getStorelist({}).then(response => {
        that.list = response.data
      })
    },
    storeChange(val) {
      this.getStoreList(val)
    },
    getStoreList: function(data) {
      const that = this
      console.log(data)
      getView(data.store_id).then(res => {
        console.log('商户数据', res)
        that.$store.dispatch('elForm/changeHEaders', {
          key: 'store-id',
          value: res.data.store_id
        })
        that.$store.dispatch('elForm/changeHEaders', {
          key: 'bloc-id',
          value: res.data.bloc_id
        })
        that.$store.dispatch('elForm/changeSetting', {
          key: 'attachmentUrl',
          value: res.data.config.attachmentUrl
        })
        that.$store.dispatch('App/setBlocs', res.data)
        this.$nextTick(() => {
          this.$router.replace({
            path: '/redirect' + this.$route.fullPath
          })
          this.showStore = false
          this.$emit('hideStore', {})
        })
      })
    }
  }
}
</script>

<style>
.box-card-store{
  height: 200px !important;
}
.store-main{
  border: 1xp solid #e5e5e5;
}
.box-card{
  margin-bottom: 10px;
  border: 1px solid #ccc;
}
.box-card-active{
  border: 1px solid #1890ff;
}
.store-list{
  height: calc(100vh - 100px);
  overflow-y: scroll;
}

.store-list::-webkit-scrollbar {
     width: 0 !important;
}
/* 设置滚动条的样式 */
.store-list::-webkit-scrollbar {
    width: 5px;
    border-radius: 8px;
}
/* 滚动槽 */
.store-list::-webkit-scrollbar-track {
    /* -webkit-box-shadow: inset006pxrgba(0, 0, 0, 0.5); */
    background-color: #555;
}
/* 滚动条滑块 */
.store-list::-webkit-scrollbar-thumb {
    border-radius: 8px;
    background: #333;
    /* -webkit-box-shadow: inset006pxrgba(0, 0, 0, 0.5); */
}
.store-logo {
    display: grid;
    width: 55px;
    height: 75px;
    border-radius: 30px;
}
</style>
