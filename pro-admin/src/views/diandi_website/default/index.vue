<template>
  <div>
    <component :is="currentRole" />
  </div>
</template>
<script>
// 插件首页通用
import blocDashboard from 'diandi-admin/lib/system-page/dashboard/bloc/index.vue'
export default {
  name: 'Dashboard',
  components: { blocDashboard },
  data() {
    return {
      currentRole: 'blocDashboard'
    }
  }
}
</script>
