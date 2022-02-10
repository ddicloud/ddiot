<template>
 <div class="navMenu">
  <label v-for="(navMenu,index) in navMenus" :key="index">
   <el-menu-item v-if="navMenu.children==null"
          :key="navMenu.id" :data="navMenu" :index="navMenu.text" :route="navMenu.value"
          disabled="">
    <i :class="navMenu.icon"></i>
    <span slot="title">{{navMenu.text}}</span>
   </el-menu-item>
 
   <el-submenu v-if="navMenu.childs&&navMenu.entity&&navMenu.entity.state==='ENABLE'"
         :key="navMenu.id" :data="navMenu" :index="navMenu.text">
    <template slot="title">
     <i :class="navMenu.icon"></i>
     <span> {{navMenu.text}}</span>
    </template>
    <NavMenu :navMenus="navMenu.children"></NavMenu>
   </el-submenu>
  </label>
 
 </div>
</template>
 
<script>
 export default {
  name: 'NavMenu',
  props: ['navMenus'],
  data() {
   return {}
  },
  methods: {}
 }
</script>
 
<style scoped>
 
</style>
