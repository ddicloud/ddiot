## 代码生成指令
# 生成模型类
```dockerignore
 php ./yii  gii/model --tableName=dd_weih_exhibition_service_provider --modelClass=WeihExhibitionServiceProvider --useTablePrefix=1 --ns=addons\weih_exhibition\models    --queryNs=addons\weih_exhib
ition\models --generateLabelsFromComments=1

```
### 生成后台接口与vue页面
```
php ./yii gii/adminapi --controllerClass=addons\bea_cloud\admin\red\FreeController --modelClass=addons\bea_cloud\models\red\BeaFree --searchModelClass=addons\bea_cloud\models\searchs\red\BeaFree
```

### 生成uniapp项目的api文件

```dockerignore
 php ./yii addons/createapi --addons=diandi_hotel

```
