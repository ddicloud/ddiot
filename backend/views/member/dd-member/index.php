<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-02 02:15:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-21 12:26:47
 */

use common\components\backend\VueBackendAsset;
use yii\helpers\Html;
use common\widgets\MyGridView;
VueBackendAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\DdMemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_tab') ?>
                
<div class="firetech-main" >
    <div class="dd-member-index " id="dd-member-index">
            
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div class="row">
      <div class="list-operation">
        <el-button-group>
              <el-button
                  :loading="downloadLoading"  size="small"
                  icon="el-icon-refresh" class="margin-xs"  type="primary" @click="getList">
                  刷新
              </el-button>
              <el-button
                  :loading="downloadLoading"  size="small"
                  icon="el-icon-document" class="margin-xs"  type="primary" @click="handleDownload">
                  导出
              </el-button>
              <el-button icon="el-icon-delete" size="small" class="margin-xs" type="danger" @click="handleDelete">
                  删除
              </el-button>
        </el-button-group>
      </div>
      
      
    </div>
    
    <div class="table-container">
    <el-table
      ref="tableSort"
      v-loading="listLoading"
      :data="list"
      :element-loading-text="elementLoadingText"
      :height="height"
      @selection-change="setSelectRows"
      @sort-change="tableSortChange"
      style="width: 100%"
      header-row-class-name="list-header" 
    >
      <el-table-column
        show-overflow-tooltip
        type="selection"
        width="55"
      ></el-table-column>
      <!-- 序号start -->
      <!-- <el-table-column show-overflow-tooltip label="序号" width="95" fixed>
        <template #default="scope">
          {{ scope.$index + 1 }}
        </template>
      </el-table-column> -->
      <!-- 序号end -->

      <el-table-column
        show-overflow-tooltip
        prop="member_id"
        label="会员ID"
      ></el-table-column>
      <el-table-column show-overflow-tooltip label="头像">
        <template #default="{ row }">
          <el-image
            v-if="imgShow"
            :preview-src-list="imageList"
            :src="row.avatar"
          ></el-image>
        </template>
      </el-table-column>
      
      <el-table-column
        show-overflow-tooltip
        label="用户名"
        prop="username"
      ></el-table-column>
     
      <el-table-column
        show-overflow-tooltip
        label="手机号"
        prop="mobile"
        sortable
      ></el-table-column>
      <el-table-column show-overflow-tooltip label="状态">
        <template #default="{ row }">
          <el-tooltip
            :content="row.status"
            class="item"
            effect="dark"
            placement="top-start"
          >
            <el-tag :type="row.status | statusFilter">
              {{ row.status }}
            </el-tag>
          </el-tooltip>
        </template>
      </el-table-column>
      <el-table-column
        show-overflow-tooltip
        label="时间"
        prop="create_time"
        width="200"
      ></el-table-column>
      <el-table-column show-overflow-tooltip label="操作" width="280px" >
        <template #default="{ row }">
          <el-button type="text" @click="handleView(row)">查看</el-button>
          <el-button type="text" @click="handleEdit(row)">编辑</el-button>
          <el-button type="text" @click="handleDelete(row)">删除</el-button>
          <el-button type="text" @click="editPassword(row)">修改密码</el-button>
        </template>
      </el-table-column>
    </el-table>
    
    <div class="row">
            <div class="text-center padding">
                <el-pagination
                :background="background"
                :current-page="queryForm.pageNo"
                :pager-count="3"
                :layout="layout"
                :page-size="queryForm.pageSize"
                :total="total"
                @current-change="handleCurrentChange"
                @size-change="handleSizeChange"
                ></el-pagination>
            </div>
    </div>
  </div>



  <el-dialog title="修改密码" :visible.sync="dialogFormVisible">
      <el-form :model="form">
        <el-form-item label="登录密码" :label-width="formLabelWidth">
          <el-input v-model="form.password" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="passwordSubmit">确 定</el-button>
      </div>
    </el-dialog>
  
               
                
            </div>
        </div>
    </div>
</div>