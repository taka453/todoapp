<?php

// クラスを書いていく
require_once ("./../../config/db.php");

class Todo {
    // 定数を作成
    // 未完了の定数
    const STATUS_INCOMPLETE = 0;
    // 完了の定数
    const STATUS_COMPLETED = 1;

    // 表示するための定数
    // 未完了の定数
    const STATUS_INCOMPLETE_TXT = "未完了";
    // 完了の定数
    const STATUS_COMPLETED_TXT = "完了";

    // publicでプロパティ宣言
    public $id;
    public $title;
    public $detail;
    public $status;

      // プロパティに対して、titleメソッド、titleを返す
    public function getId() {
        return $this->id;
    }

    // titleをセットするようメソッド
    public function setId($id) {
        $this->id = $id;
    }

    // プロパティに対して、titleメソッド、titleを返す
    public function getTitle() {
        return $this->title;
    }

    // titleをセットするようメソッド
    public function setTitle($title) {
        $this->title = $title;
    }

    // プロパティに対して、getメソッド、detailを返す
    public function getDetail() {
        return $this->detail;
    }

    // detailをセットするようメソッド
    public function setDetail($detail) {
        $this->detail = $detail;
    }

    // プロパティに対して、statusメソッド、statusを返す
    public function getStatus() {
        return $this->status;
    }

    // statusをセットするようメソッド
    public function setStatus($status) {
        $this->status = $status;
    }

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
            //fetchは結果セットの1行を返す。
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

    public static function getDisplayStatus($status) {
        if($status == self::STATUS_INCOMPLETE) {
            return self::STATUS_INCOMPLETE_TXT;
        } else if($status == self::STATUS_COMPLETED){
            return self::STATUS_COMPLETED_TXT;
        }
        return "";
    }

    public function save() {
        // insert時にエラーが発生した時にエラー画面が表示しないようにする
        try {
            // 保存処理を入力する。
            // 文字列置換するために%sで記入。statusはデフォルトが未完成のため0を保存する
            $query = sprintf("INSERT INTO `todos` (`title`, `detail`, `status`, `created_at`, `updated_at`)
            VALUES ('%s', '%s', 0, NOW(), NOW())",
                $this->title,
                $this->detail
            );
            //PDOクラスで記入,コンストラクタに対して$dsn,$user,$password情報を渡す
            $pdo = new PDO(DSN, USERNAME, PASSWORD);
            //queryメソッドにてデータベースに情報を渡す
            $result = $pdo->query($query);
            //エラーが発生するとエラーをキャッチする。
        } catch(Exception $e) {
            // エラーメッセージを表示させる
            error_log("新規作成に失敗しました。");
            // エラーのログを残す。getMessageを取得する事でエラーメッセージを取得する
            error_log($e->getMessage());
            // スタックトレース（エラーメッセージ）を文字列で取得できる
            error_log($e->getTraceAsString());
            // returnをfalseでかえす。
            return false;
        }

        return $result;
    }

    public function update() {
        // insert時にエラーが発生した時にエラー画面が表示しないようにする
        try {
            // 更新処理を入力する。
            // 文字列置換するために%sで記入。
            // updateは値を指定する際は''で囲む。
            // where句でidを指定しないと全体が更新されてしまうので注意
            $query = sprintf("UPDATE `todos` SET `title` = '%s', `detail` = '%s', `updated_at` = '%s' WHERE id = %s",
                $this->title,
                $this->detail,
                date("Y-m-d H:i:s"),
                $this->id
            );

            error_log($query);
            //PDOクラスで記入,コンストラクタに対して$dsn,$user,$password情報を渡す
            $pdo = new PDO(DSN, USERNAME, PASSWORD);
            $pdo->beginTransaction();
            //queryメソッドにてデータベースに情報を渡す
            $result = $pdo->query($query);
            //エラーが発生するとエラーをキャッチする。
            $pdo->commit();
        } catch(Exception $e) {
            // エラーメッセージを表示させる
            error_log("更新に失敗しました。");
            // エラーのログを残す。getMessageを取得する事でエラーメッセージを取得する
            error_log($e->getMessage());
            // スタックトレース（エラーメッセージ）を文字列で取得できる
            error_log($e->getTraceAsString());
            $pdo->rollBack;
            // returnをfalseでかえす。
            return false;
        }
        return $result;
    }

    public static function isExistById($todo_id) {
        $pdo = new PDO(DSN, USERNAME, PASSWORD);

        //queryの引数にmysqlのコードを記入する
        //文字列置換をするためにsprintfを使う
        //todosテーブルからqueryの引数から渡ってきたtodo_idに該当するレコードを取得する
        $stmh = $pdo->query(sprintf("select * from todos where id = %s;", $todo_id));

        // 失敗した場合の処理として、queryの情報が間違っていれば、空の配列がかえる
        // todosにtodo_idレコードが存在すれば、true、存在していなければ、falseになる。
        if($stmh) {
            //fetchは結果セットの1行を返す。
            //FECH_ASSOCは定数。結果を連想配列で返す指定をしている。
            $todo = $stmh->fetch(PDO::FETCH_ASSOC);
            //prepareで準備して、executeで実行する。
            // $stmh = $pdo->prepare("select * from todos");
            // $stmh->execute();
        } else {
            $todo = array();
        }

        if($todo) {
            //viewファイルに返す
            return true;
        }
        return false;
    }
}