<?php

// クラスを書いていく
require_once ("./../../config/db.php");

class Todo {
    public static function findByQuery($query) {
        //PDOクラスで記入,コンストラクタに対して$dsn,$user,$password情報を渡す
        $pdo = new PDO(DSN, USERNAME, PASSWORD);

        //queryメソッドの引数にsql文を足す事によりsqlを実行できる
        //返り値は連想配列ではかえってこない
        //statementクラスは引数にかいたクラス

        $stmh = $pdo->query($query);

        // 失敗した場合の処理として、queryの情報が間違っていれば、空の配列がかえる

        if($stmh) {
            //fetchallはすべての結果を配列で返す。
            //FECH_ASSOCは定数。結果を連想配列で返す指定をしている。
            $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);
            //prepareで準備して、executeで実行する。
            // $stmh = $pdo->prepare("select * from todos");
            // $stmh->execute();
        } else {
            $todo_list = array();
        }
        //findByQueryからviewファイルに返す
        return $todo_list;
    }

    //すべてのユーザー情報を呼び出す
    //引数にはqueryをすべてを取得するため渡さない。
    public static function findAll() {
        //PDOクラスで記入,コンストラクタに対して$dsn,$user,$password情報を渡す
        $pdo = new PDO(DSN, USERNAME, PASSWORD);

        //queryの引数にmysqlのコードを記入する
        $stmh = $pdo->query("select * from todos;");

        // 失敗した場合の処理として、queryの情報が間違っていれば、空の配列がかえる

        if($stmh) {
            //fetchallはすべての結果を配列で返す。
            //FECH_ASSOCは定数。結果を連想配列で返す指定をしている。
            $todo_list = $stmh->fetchAll(PDO::FETCH_ASSOC);
            //prepareで準備して、executeで実行する。
            // $stmh = $pdo->prepare("select * from todos");
            // $stmh->execute();
        } else {
            $todo_list = array();
        }
        //findAllからviewファイルに返す
        return $todo_list;
    }

    //findByIdメソッドを作成し、$todo_idを付与
    public static function findById($todo_id) {
        $pdo = new PDO(DSN, USERNAME, PASSWORD);

        //queryの引数にmysqlのコードを記入する
        //文字列置換をするためにsprintfを使う
        //todosテーブルからqueryの引数から渡ってきたtodo_idに該当するレコードを取得する
        $stmh = $pdo->query(sprintf("select * from todos where id = %s;", $todo_id));

        // 失敗した場合の処理として、queryの情報が間違っていれば、空の配列がかえる
        if($stmh) {
            //fetchallはすべての結果を配列で返す。
            //FECH_ASSOCは定数。結果を連想配列で返す指定をしている。
            $todo = $stmh->fetch(PDO::FETCH_ASSOC);
            //prepareで準備して、executeで実行する。
            // $stmh = $pdo->prepare("select * from todos");
            // $stmh->execute();
        } else {
            $todo = array();
        }
        //findAllからviewファイルに返す
        return $todo;
    }
}