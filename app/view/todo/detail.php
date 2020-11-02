<?php

require_once ("./../../controller/TodoController.php");

//TodoControllerから情報を取得
$controller = new TodoController;
$todo = $controller->detail();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo</title>
</head>
<body>
    <h1>詳細</h1>
    <div>
        <p>タイトル</p>
        <p><?php echo $todo['title']; ?></p>
    </div>
    <div>
        <p>詳細</p>
        <p><?php echo $todo['detail']; ?></p>
    </div>
    <div>
        <a href="./index.php">戻る</a>
    </div>
</body>
</html>