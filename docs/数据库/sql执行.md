
# 原生sql执行与操作

##   执行 SQL 查询
一旦你拥有了 DB Connection 实例，你可以按照下列步骤来执行 SQL 查询：

使用纯SQL查询来创建出 yii\db\Command；
绑定参数 (可选的)；
调用 yii\db\Command 里 SQL 执行方法中的一个。
下列例子展示了几种不同的从数据库取得数据的方法：

// 返回多行. 每行都是列名和值的关联数组.
// 如果该查询没有结果则返回空数组
```
$posts = Yii::$app->db->createCommand('SELECT * FROM post')
            ->queryAll();
```
// 返回一行 (第一行)
// 如果该查询没有结果则返回 false
```
$post = Yii::$app->db->createCommand('SELECT * FROM post WHERE id=1')
           ->queryOne();
```
// 返回一列 (第一列)
// 如果该查询没有结果则返回空数组
```
$titles = Yii::$app->db->createCommand('SELECT title FROM post')
             ->queryColumn();
```
// 返回一个标量值
// 如果该查询没有结果则返回 false
```
$count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM post')
             ->queryScalar();
```
注意： 为了保持精度，即使对应的数据库列类型为数值型， 所有从数据库取得的数据都被表现为字符串。



##   绑定参数
当使用带参数的 SQL 来创建数据库命令时， 你几乎总是应该使用绑定参数的方法来防止 SQL 注入攻击，例如：
```
$post = Yii::$app->db->createCommand('SELECT * FROM post WHERE id=:id AND status=:status')
           ->bindValue(':id', $_GET['id'])
           ->bindValue(':status', 1)
           ->queryOne();
```
在 SQL 语句中，你可以嵌入一个或多个参数占位符(例如，上述例子中的 :id )。 一个参数占位符应该是以冒号开头的字符串。 之后你可以调用下面绑定参数的方法来绑定参数值：

bindValue()：绑定一个参数值
bindValues()：在一次调用中绑定多个参数值
bindParam()：与 bindValue() 相似，但是也支持绑定参数引用。
下面的例子展示了几个可供选择的绑定参数的方法：
```
$params = [':id' => $_GET['id'], ':status' => 1];

$post = Yii::$app->db->createCommand('SELECT * FROM post WHERE id=:id AND status=:status')
           ->bindValues($params)
           ->queryOne();
           
$post = Yii::$app->db->createCommand('SELECT * FROM post WHERE id=:id AND status=:status', $params)
           ->queryOne();
```
绑定参数是通过 预处理语句 实现的。 除了防止 SQL 注入攻击，它也可以通过一次预处理 SQL 语句， 使用不同参数多次执行，来提升性能。例如：
```
$command = Yii::$app->db->createCommand('SELECT * FROM post WHERE id=:id');

$post1 = $command->bindValue(':id', 1)->queryOne();
$post2 = $command->bindValue(':id', 2)->queryOne();
```
// ...
因为 bindParam() 支持通过引用来绑定参数， 上述代码也可以像下面这样写：
```
$command = Yii::$app->db->createCommand('SELECT * FROM post WHERE id=:id')
              ->bindParam(':id', $id);

$id = 1;
$post1 = $command->queryOne();

$id = 2;
$post2 = $command->queryOne();
```
// ...
请注意，在执行语句前你将占位符绑定到 $id 变量， 然后在之后的每次执行前改变变量的值（这通常是用循环来完成的）。 以这种方式执行查询比为每个不同的参数值执行一次新的查询要高效得多得多。

信息： 参数绑定仅用于需要将值插入到包含普通SQL的字符串中的地方。 在 Query Builder 和 Active Record 等更高抽象层的许多地方，您经常会指定一组将被转换为 SQL 的值。 在这些地方，参数绑定是由 Yii 内部完成的，因此不需要手动指定参数。



##   执行非查询语句
上面部分中介绍的 queryXyz() 方法都处理的是从数据库返回数据的查询语句。对于那些不取回数据的语句， 你应该调用的是 yii\db\Command::execute() 方法。例如，
```
Yii::$app->db->createCommand('UPDATE post SET status=1 WHERE id=1')
   ->execute();
yii\db\Command::execute() 方法返回执行 SQL 所影响到的行数。
```



##   INSERT, UPDATE 和 DELETE 语句

对于 INSERT, UPDATE 和 DELETE 语句，不再需要写纯SQL语句了， 你可以直接调用 insert()、update()、delete()， 来构建相应的 SQL 语句。这些方法将正确地引用表和列名称以及绑定参数值。例如,

```
// INSERT (table name, column values)
Yii::$app->db->createCommand()->insert('user', [
    'name' => 'Sam',
    'age' => 30,
])->execute();

// UPDATE (table name, column values, condition)
Yii::$app->db->createCommand()->update('user', ['status' => 1], 'age > 30')->execute();

// DELETE (table name, condition)
Yii::$app->db->createCommand()->delete('user', 'status = 0')->execute();
```
你也可以调用 batchInsert() 来一次插入多行， 这比一次插入一行要高效得多：
```
// table name, column names, column values
Yii::$app->db->createCommand()->batchInsert('user', ['name', 'age'], [
    ['Tom', 30],
    ['Jane', 20],
    ['Linda', 25],
])->execute();
```



##   Upsert语句

    另一个有用的方法是 upsert()。Upsert 是一种原子操作，如果它们不存在（匹配唯一约束），则将行插入到数据库表中， 或者在它们执行时更新它们：

```

Yii::$app->db->createCommand()->upsert('pages', [
    'name' => 'Front page',
    'url' => 'https://example.com/', // url is unique
    'visits' => 0,
], [
    'visits' => new \yii\db\Expression('visits + 1'),
], $params)->execute();

```


    上面的代码将插入一个新的页面记录或自动增加访问计数器。

    请注意，上述的方法只是构建出语句， 你总是需要调用 execute() 来真正地执行它们。


    


## 引用表和列名称
当写与数据库无关的代码时，正确地引用表和列名称总是一件头疼的事， 因为不同的数据库有不同的名称引用规则，为了克服这个问题， 你可以使用下面由 Yii 提出的引用语法。
使用两对方括号来将列名括起来:
```
[[column name]]

```

使用两对大括号来将表名括起来。
```
{{table name}}

```
Yii DAO 将自动地根据数据库的具体语法来将这些结构转化为对应的 被引用的列或者表名称。 在 MySQL 中执行该 SQL : SELECT COUNT(`id`) FROM `employee`,例如

```
$count = Yii::$app->db->createCommand("SELECT COUNT([[id]]) FROM {{employee}}")->queryScalar();

```
