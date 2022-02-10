<?php

use yii\helpers\Html;
use common\widgets\MyGridView;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\DdAiMemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firetech-main">

<div class="dd-ai-member-index ">
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>
    <div class="panel panel-default">
        <div class="box-body">
    <?= MyGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'user_id',
            'face_group_id',
            'nickName',
            'face_image'=>[
                'attribute'=>'face_image',
                'format' => ['raw'],
                'value' => function($model){
                        $face_image = $model->face_image;
                        // return $ai_group_status;
                        return Html::img($face_image,['width'=>50,'height'=>50]);
                    }
                ],
           [
                "class" => "common\components\ActionColumn",
                "template" => "{get-xxx}",
                "header" => "操作",
                "buttons" => [
                    "get-xxx" => function ($url, $model, $key) { 
                        return Html::a("选择",'javascript:void(0)',[
                            'onclick'=>'getUsers('.$model->user_id.','.$model->face_group_id.')',
                            'data-dismiss'=>"modal",
                            'data-id'=>$model->user_id,'class'=>'btn btn-xs buttons-users']); 
                    },
                ],
            ],  
        ],
    ]); ?>


</div>
    </div>
</div>
</div>

<?php JSRegister::begin([
    'key' => '344566'
]); ?>
<script>
    function getUsers(user_id,face_group_id) {
        
        $('#ddaifaces-ai_user_id').val(user_id)
        $('#ddaifaces-ai_group_id').val(face_group_id)
            console.log(user_id,)
    }
</script>
<?php JSRegister::end();?>