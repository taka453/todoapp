<?php
    require_once "./../../controller/TodoController.php";

    //formよりpostメソッドが送られてるので、取得する必要がある。
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //オブジェクトで送られてくるので、インスタンス化する。
        $controller = new TodoController();
        //controllerのeditメソッドを呼ぶ
        $controller->update();
        exit;
    }

    //GETメソッドがきていれば、条件式にて情報が渡ってきていれば、変数title,detail,todo_idに情報を格納する。
    //todo_idは更新の際に取得が必要になる。
    //もしif文が通らなければ、ifの外で変数がないとundefinedになってしまうので、空を変数に格納する。
    $controller = new TodoController();
    //controllerのeditメソッドを呼ぶ
    $data = $controller->edit();

    $todo = $data['todo'];
    $params = $data['params'];

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
        <form action="./edit.php" method="post">
            <div>
                <p>タイトル</p>
                <!-- 取得したgetパラメータより取得したtitleをvalue値にてphpを入力する -->
                <!-- パラメータにタイトルがあればパラメータのタイトルが表示され、なければ保存されているデータを表示する -->
                <input name="title" type="text" value="<?php if(isset($params['title'])): ?><?php echo $params['title']; ?><?php else: ?><?php echo $todo['title']; ?><?php endif; ?>">
            </div>
            <div>
                <p>詳細</p>
                <!-- 取得したgetパラメータより取得したdetailをvalue値にてphpを入力する -->
                <textarea name="detail"><?php if(isset($params['detail'])): ?><?php echo $params['detail']; ?><?php else: ?><?php echo $todo['detail']; ?><?php endif; ?></textarea>
            </div>
            <!-- todo_idをinputのhiddenで渡し、情報を保持する。 -->
            <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
            <button type="submit">更新</button>
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