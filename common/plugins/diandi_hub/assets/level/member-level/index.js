/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-11 02:00:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-07-11 23:27:27
 */
new Vue({
    el: '#hub-member-level-index',
    data() {
        return {
            page:1,
            list: [],
            count:0,
            pageSize:20,
            multipleSelection: []
        }
    },
    created: function () {
        let that = this;
        console.log('全局设置是否可以',window.sysinfo)
        that.init();
    },
    methods: {
      init(){
        let that = this;
        that.getMember()
      },
      getMember(){
        let that = this;
        that.$http.get('member', {
            page:that.page,
            pageSize:that.pageSize
        }).then((response) => {
            console.log(response)
            //响应成功回调
            if (response.data.code == 200) {
                let data = response.data.data
                that.list = data.list.list
                that.count = data.count
                
                console.log(data)
            }
            return false;
        }, (response) => {
            //响应错误回调
            console.log(response)
        });
      },
      statusUpdate(status){
        let that = this;
        that.$http.post('statusupdate', {
            status:status,
            member_ids:that.multipleSelection
        }).then((response) => {
            console.log(response)
            //响应成功回调
            if (response.data.code == 200) {
                that.$message({
                    message: response.data.message,
                    type: 'success'
                  });
            }else{
                that.$message.error(response.data.message);
            }
        }, (response) => {
            //响应错误回调
            console.log(response)
        });
      },
      toggleSelection(rows) {
        if (rows) {
          rows.forEach(row => {
            this.$refs.multipleTable.toggleRowSelection(row);
          });
        } else {
          this.$refs.multipleTable.clearSelection();
        }
      },
      handleSelectionChange(val) {
        this.multipleSelection = val;
        console.log('选中',val)
      },
      viewClick(row) {
        console.log(row);
        
      },
      editClick(row) {
        console.log(row);
      },
      handleSizeChange(val) {
        let that = this;
          
        console.log(`每页 ${val} 条`);
        this.pageSize = val
        that.getMember();
      },
      handleCurrentChange(val) {
        let that = this;

        console.log(`当前页: ${val}`);
        this.page = val
        that.getMember();
        
      },
      setItem(val){
          console.log(this.level1_numVal)
        var elInput = document.getElementById('condition-input'); //根据id选择器选中对象
        var startPos = elInput.selectionStart;// input 第0个字符到选中的字符
        var endPos = elInput.selectionEnd;// 选中的字符到最后的字符
        if (startPos === undefined || endPos === undefined) return
        var txt = elInput.value;
        // 将表情添加到选中的光标位置
        var result = txt.substring(0, startPos) + val + txt.substring(endPos)
        elInput.value = result;// 赋值给input的value
        // 重新定义光标位置
        elInput.focus();
        elInput.selectionStart = startPos + val.length;
        elInput.selectionEnd = startPos + val.length;
         
        console.log(event)
        this.condition = result
      },
      submitForm(){
        let that = this;
        that.$http.post('update', {
            id:that.id,
            levelname:that.levelname,
            levelnum:that.levelnum,
            level1_num:that.level1_numVal,
            level2_num:that.level2_numVal,
            level1_saletotal:that.level1_saletotalVal,
            level2_saletotal:that.level2_saletotalVal,
            condition:that.condition,
        }).then((response) => {
            console.log(response)
            //响应成功回调
            if (response.data.code == 200) {
                that.$message({
                    message: response.data.message,
                    type: 'success'
                });
            }
            return false;
        }, (response) => {
            //响应错误回调
            console.log(response)
        });
      }
}
})
