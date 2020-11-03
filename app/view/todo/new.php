<?php
    require_once "./../../controller/TodoController.php";

    //formよりpostメソッドが送られてるので、取得する必要がある。
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //オブジェクトで送られてくるので、インスタンス化する。
        $controller = new TodoController();
        //controllerのnewメソッドを出力する
        $controller->new();
        exit;
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規作成</title>
</head>
<body>
    <div>
        // nameに書かれたtitle,detailはcontrollerにて取得される
        <h1>新規作成</h1>
        <form action="./new.php" method="post">
            <div>
                <p>タイトル</p>
                <input name="title" type="text">
            </div>
            <div>
                <p>詳細</p>
                <textarea name="detail"></textarea>
            </div>
            <button type="submit">登録</button>
        </form>
    </div>
</body>
</html>