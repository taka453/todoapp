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

    //GETメソッドがきていれば、条件式にて情報が渡ってきていれば、変数title,detailに情報を格納する。
    //もしif文が通らなければ、ifの外で変数がないとundefinedになってしまうので、変数は取得する。
    $title = '';
    $detail = '';
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['title'])) {
            $title = $_GET['title'];
        }
        if(isset($_GET['detail'])) {
            $detail = $_GET['detail'];
        }
    }

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
    <title>編集</title>
</head>
<body>
    <div>
        <!-- nameに書かれたtitle,detailはcontrollerにて取得される -->
        <h1>編集</h1>
        <form action="./new.php" method="post">
            <div>
                <p>タイトル</p>
                <!-- 取得したgetパラメータより取得したtitleをvalue値にてphpを入力する -->
                <input name="title" type="text" value="<?php echo $title; ?>">
            </div>
            <div>
                <p>詳細</p>
                <!-- 取得したgetパラメータより取得したdetailをvalue値にてphpを入力する -->
                <textarea name="detail"><?php echo $detail; ?></textarea>
            </div>
            <button type="submit">登録</button>
        </form>
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
    </div>
</body>
</html>