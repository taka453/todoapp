<?php

//DB接続の記述
//hostはmysqlコンテナに入って記述を確認する必要あり。
$dsn='mysql:host=c77868a2fbb8;dbname=common;charset=utf8';
$user='takano';
$password='takano';

//PDOクラスで記入,コンストラクタに対して$dsn,$user,$password情報を渡す
$pdo = new PDO($dsn, $user, $password);

//queryメソッドの引数にsql文を足す事によりsqlを実行できる
//返り値は連想配列ではかえってこない
//statementクラスは引数にかいたクラス

$stmh = $pdo->query("select * from todos");

//prepareで準備して、executeで実行する。
// $stmh = $pdo->prepare("select * from todos");
// $stmh->execute();

//fetchallはすべての結果を配列で返す。
//FECH_ASSOCは定数。結果を連想配列で返す指定をしている。
$todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- foreachでループで取得する、fetchAllにより連想配列にて返されている -->
    <ul>
        <?php foreach($todo_list as $todo): ?>
            <li><?php echo $todo["title"]; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

