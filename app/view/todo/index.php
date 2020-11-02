<?php

// require_onceでDB接続情報を呼び出す
require_once ("./../../model/Todo.php");

// TodoクラスのfindByQueryメソッドを呼び出す。
// findByQueryの引数がqueryとなり、引数に書かれたものがmodelのTodoクラスにわたす
$todo_list = Todo::findAll();

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

