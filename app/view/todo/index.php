<?php

// require_onceでDB接続情報を呼び出す
require_once ("./../../controller/TodoController.php");

// TodoクラスのfindByQueryメソッドを呼び出す。
// findByQueryの引数がqueryとなり、引数に書かれたものがmodelのTodoクラスにわたす
// $todo_list = Todo::findAll();

//controllerを呼ぶ出す記述に変更
//インスタンス生成するためにnewキーワードを指定する、よってオブジェクトが常に生成される。
$controller = new TodoController();
$todo_list = $controller->index();

session_start();
// コントローラで保持しているエラーメッセージを格納
$error_msgs = $_SESSION['error_msgs'];
//  格納が済めばセッションを削除する
unset($_SESSION['error_msgs']);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Todoアプリ</h1>
    <div><a href="./new.php">新規作成</a></div>
    <!-- データの条件分岐を記入 -->
    <?php if($todo_list): ?>
        <!-- foreachでループで取得する、fetchAllにより連想配列にて返されている -->
        <ul>
            <?php foreach($todo_list as $todo): ?>
                <!-- 詳細ページに遷移するためにaタグを実装 -->
                <!-- パラメータを付与する事でデータを詳細ページされるようにする -->
                <!-- 配列の$todoのidをパラメータを付与する -->
                <!-- ?以降はパラメータとしてデータを付与する事ができる -->
                <li><a href="./detail.php?todo_id=<?php echo $todo['id']; ?>"><?php echo $todo['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>データなし</p>
    <?php endif; ?>
    <!-- エラーメッセージがあれば表示させるという条件式 -->
    <?php if($error_msgs): ?>
        <div>
            <ul>
                <!-- エラーメッセージを取得し、表示するためにforeachで繰り返し処理を行う -->
                <?php foreach($error_msgs as $error_msg):?>
                    <li><?php echo $error_msg; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</body>
</html>

