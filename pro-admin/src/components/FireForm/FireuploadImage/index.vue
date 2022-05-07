<template>
  <div>
    <el-input v-model="value">
      <template slot="append">
        <el-button @click="handleUpload"> 上传图片 </el-button>
      </template>
    </el-input>
    <el-upload
      ref="upload"
      v-loading="isShowLoading"
      class="avatar-uploader margin-top-xs"
      :action="uploadUrl"
      :headers="headerObj"
      :show-file-list="false"
      :on-success="handleAvatarSuccess"
      :before-upload="beforeAvatarUpload"
    >
      <img v-if="imageUrl" :src="imageUrl" class="avatar">
      <i v-else class="el-icon-plus avatar-uploader-icon" />
    </el-upload>
  </div>
</template>
<script>
import { config } from '@/utils/publicUtil'
import formMixin from 'diandi-ele-form/lib/mixins/formMixin'
export default {
  name: 'ImageUploader',
  mixins: [formMixin],
  props: {
    // desc是此组件的描述, 结构为
    // { style: {}, class: {}, on: {}, attrs: {} }
    // value 是传递过来的值
    value: {
      type: String,
      default() {
        return ''
      }
    }
  }, // 必须引入mixin
  data() {
    return {
      imageUrl: '',
      isShowLoading: false,
      uploadUrl: '',
      attachment: '',
      headerObj: {}
    }
  },
  watch: {
    value: {
      handler(newVal) {
        if (newVal) {
          this.imageUrl = config.siteUrl + '/attachment/' + newVal
        }
      },
      immediate: true,
      deep: true
    }
  },
  created() {
    this.attachment = this.value
    this.uploadUrl = this.$store.state.settings.uploadUrl
    this.headerObj = {
      'access-token': this.$store.getters.accessToken,
      'bloc-id': this.$store.getters.blocId,
      'store-id': this.$store.getters.storeId
    }
  },
  methods: {
    handleUpload() {
      console.log(this.$refs['upload'])
      this.$refs['upload'].$children[0].$refs.input.click()
      // this.$refs.upload.submit();
      // this.$refs['upload']
    },
    handleAvatarSuccess(res, file) {
      this.isShowLoading = false
      console.log('上传成功', res, file, res.code)

      if (res.code === 200) {
        this.attachment = res.attachment
        this.imageUrl = res.url
        // this.value= res.url;
        console.log('上传成功后', this.imageUrl)

        this.$emit('input', res.attachment)
      } else if (res.code === 400) {
        this.$message.error(res.message)
      } else if (res.code === 402) {
        this.$router.push({ path: `/login?redirect=${this.$router.name}` })
      }
    },
    beforeAvatarUpload(file) {
      const isJPG = file.type === 'image/jpeg' || 'image/png'
      const isLt2M = file.size / 1024 / 1024 < 2

      if (!isJPG) {
        this.$message.error('上传头像图片只能是 JPG 格式!')
      }
      if (!isLt2M) {
        this.$message.error('上传头像图片大小不能超过 2MB!')
      }
      this.isShowLoading = true
      return isJPG && isLt2M
    }
  }
}
</script>

<style>
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  margin-left: 0px;
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 150px;
  height: 150px;
  line-height: 150px;
  text-align: center;
}
.avatar {
  width: 150px;
  height: 150px;
  display: block;
}
</style>
