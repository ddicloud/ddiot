# 用户端接口



### 接口配置

控制器定义
```
controller：模块名称/控制器名称
```
是否支持复数
```
pluralize： 支持设置为true ，否则为false  一般不支持，设置为支持，接口请求过程中不区分actionName和actionNames
```
请求方式
```
	'GET,POST,DELEET,POST,PUT 请求名称' => '映射名称（actionName中的‘name’）',
```
```
return [
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => ['diandi_distribution/ceshi'],
		'pluralize' => false,
		'extraPatterns' => [
			'GET dongjie' => 'dongjie',
			'GET sms' => 'sms',
		],
	],
```