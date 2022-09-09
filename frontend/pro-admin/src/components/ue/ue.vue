<template>
  <div>
    <script :id="id" type="text/plain" />
  </div>
</template>
<script>
export default {
  name: 'UE',
  props: {
    defaultMsg: {
      type: String
    },
    config: {
      type: Object
    },
    id: {
      type: String
    }
  },
  data() {
    return {
      editor: null
    }
  },
  mounted() {
    const _this = this
    this.editor = UE.getEditor(this.id, this.config) // 初始化UE
    this.editor.addListener('ready', function() {
      // 延时 lkw20190307 添加, 防止页面加载富文本编辑器来不及赋值/或网络延时加载不上
      setTimeout(function() {
        _this.editor.setContent(_this.defaultMsg) // 确保UE加载完成后，放入内容。
      }, 300)
    })
    console.log('上传这堆错误不用理会，上传接口需自行开发配置')
  },
  destroyed() {
    this.editor.destroy()
  },
  methods: {
    getUEContent() { // 获取内容方法
      return this.editor.getContent()
    },
    getUEContentTxt() { // 获取纯文本内容方法
      return this.editor.getContentTxt()
    }
  }
}
</script>

