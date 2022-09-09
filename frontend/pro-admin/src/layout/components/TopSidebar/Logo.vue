<template>
  <div class="sidebar-logo-container" :class="{ collapse: collapse }">
    <transition name="sidebarLogoFade">
      <router-link v-if="collapse" key="collapse" class="sidebar-logo-link" to="/">
        <div class="sidebar-logo">
          <el-image
            v-if="webSite.blogo"
            style="width: 35px; height: 35px"
            :src="webSite.blogo"
            fit="scale-down"
          />
          <!-- <img v-if="webSite.blogo" :src="webSite.blogo"> -->
        </div>
        <div class="top-website-title">
          <h5 class="sidebar-title">{{ webSite.name }}</h5>
          <h5 class="sidebar-store">{{ storeName || '工作台' }}</h5>
        </div>
      </router-link>
      <router-link v-else key="expand" class="sidebar-logo-link" to="/">
        <div class="sidebar-logo">
          <el-image
            v-if="webSite.blogo"
            style="width: 35px; height: 35px"
            :src="webSite.blogo"
            fit="scale-down"
          />
        </div>
        <div class="top-website-title">
          <h5 class="sidebar-title">{{ webSite.name }}</h5>
          <h5 class="sidebar-store">{{ storeName || '工作台' }}</h5>
        </div>
      </router-link>
    </transition>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { config } from '@/utils/publicUtil'

export default {
  name: 'SidebarLogo',
  props: {
    collapse: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      title: 'Vue Element Admin',
      siteName: config.siteName,
      logo: 'https://wpimg.wallstcn.com/69a1c46c-eb1c-4b46-8bd4-e9e686ef5251.png'
    }
  },
  computed: {
    ...mapGetters(['webSite', 'Layout', 'storeName'])
  }
}
</script>

<style lang="scss" scoped>
.sidebarLogoFade-enter-active {
	transition: opacity 1.5s;
}

.sidebarLogoFade-enter,
.sidebarLogoFade-leave-to {
	opacity: 0;
}

.sidebar-logo-container {
	position: relative;
	width: 150px;
	height: 60px;
	// line-height: 60px;
	background: #2b2f3a;
	// text-align: center;
	overflow: hidden;
	display: flex;
	& .sidebar-logo-link {
		height: 100%;
		width: 100%;
		display: flex;
		& .sidebar-logo {
			vertical-align: middle;
			margin-right: 12px;
			display: grid;
    		align-items: center;
			img{
				width: 32px;
				height: 32px;
			}
		}
		& .top-website-title{
			height: 60px;
			text-align: center;
    		width: 100%;
			& .sidebar-title {
				height: 40px;
				line-height: 40px;
				width: 100%;
				margin: 0;
				color: #fff;
				font-weight: 600;
				font-size: 14px;
				font-family: Avenir, Helvetica Neue, Arial, Helvetica, sans-serif;
				vertical-align: middle;
			}
			& .sidebar-store{
				height: 20px;
				line-height: 20px;
				width: 100%;
				color: #f5f7fa;
				font-weight: 400;
				font-size: 12px;
				margin: 0;
			}
		}

	}

	&.collapse {
		.sidebar-logo {
			margin-right: 0px;
		}
	}
}
</style>
