<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-02 18:00:21
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-28 19:56:31
 */
 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\searchs\SearchFields */
/* @var $form yii\widgets\ActiveForm */
?>

<el-form :inline="true" :model="SearchFields" class="demo-form-inline">
    <el-form-item label="会员ID">
        <el-input v-model="SearchFields.member_id" placeholder="会员ID"></el-input>
    </el-form-item>
    <el-form-item label="会员编码">
        <el-input v-model="SearchFields.invitation_code" placeholder="会员编码"></el-input>
    </el-form-item>
    <el-form-item label="openid">
        <el-input v-model="SearchFields.openid" placeholder="openid"></el-input>
    </el-form-item>
    <el-form-item label="手机号">
        <el-input v-model="SearchFields.mobile" placeholder="手机号"></el-input>
    </el-form-item>
    <el-form-item label="用户名">
        <el-input v-model="SearchFields.username" placeholder="用户名"></el-input>
    </el-form-item>
    <el-form-item label="状态">
        <el-select v-model="SearchFields.status" placeholder="状态">
        <el-option label="正常" value="0"></el-option>
        <el-option label="拉黑" value="1"></el-option>
        </el-select>
    </el-form-item>
    <el-form-item label="会员组">
        <el-select v-model="SearchFields.group_id" placeholder="会员组">
        <el-option   v-for="item in groups"
            :key="item.group_id"
            :label="item.item_name"
            :value="item.group_id"></el-option>
        </el-select>
    </el-form-item>
    
    <el-form-item>
        <el-button type="primary" @click="onSearch"  size="small">查询</el-button>
    </el-form-item>
</el-form>
        