<?php

// require_onceでDB接続情報を呼び出す
require_once ("./../../config/db.php");

//PDOクラスで記入,コンストラクタに対して$dsn,$user,$password情報を渡す
$pdo = new PDO(DSN, USERNAME, PASSWORD);

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

$todo_list = array();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- データの条件分岐を記入 -->
    <?php if($todo_list): ?>
        <!-- foreachでループで取得する、fetchAllにより連想配列にて返されている -->
        <ul>
            <?php foreach($todo_list as $todo): ?>
                <li><?php echo $todo["title"]; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>データなし</p>
    <?php endif; ?>
</body>
</html>

