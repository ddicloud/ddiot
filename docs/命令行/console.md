## 代码生成指令
# 生成模型类
php ./yii  gii/model --tableName=dd_diandi_watches_address_book --modelClass=WatchesBook --useTablePrefix=1 --ns=addons\diandi_watches\models --generateLabelsFromComments=1

php ./yii gii/adminapi --controllerClass=addons\bea_cloud\admin\red\FreeController --modelClass=addons\bea_cloud\models\red\BeaFree --searchModelClass=addons\bea_cloud\models\searchs\red\BeaFree