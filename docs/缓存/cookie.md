# cookie

# 获取cookie
```
public function actionReadCookies() { 
   // 从request组件获取cookie对象
   $cookies = Yii::$app->request->cookies; 
   
   // 如果language不存在，则赋默认值
   $language = $cookies->getValue('language', 'Chinese'); 

   // cookie对象也可以当数组使用
   if (isset($cookies['language'])) { 
      $language = $cookies['language']->value; 
   } 
   // check if there is a "language" cookie 
   //检测是否含有language cookie
   if ($cookies->has('language')) echo "当前语言为: $language"; 
}
```
# 设置cookie
```
public function actionSendCookies() { 
   // 从response组件获取cookie对象
   $cookies = Yii::$app->response->cookies; 
   // 添加cookie
   $cookies->add(new \yii\web\Cookie([ 
      'name' => 'language', 
      'value' => 'Chinese', 
   ])); 
   $cookies->add(new \yii\web\Cookie([
      'name' => 'username', 
      'value' => 'Hippo', 
   ])); 
   $cookies->add(new \yii\web\Cookie([ 
      'name' => 'country', 
      'value' => 'China', 
   ])); 
} 
```
# 删除cookie
```
public function actionDeleteCookies() { 
   \Yii::$app->response->cookies->remove('language');
} 
```