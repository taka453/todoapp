<?php

//クラスを宣言する。
//フレームワークではコマンドにて、生成される
//最初の一文字目は大文字を記入
//require_onceも忘れずに記入する。

require_once ("./../../model/Todo.php");
require_once ("./../../validation/TodoValidation.php");

// Todoクラスにてメソッドが実行される。
class TodoController {
    // index(一覧)のメソッド作成
    public function index() {
        //Todoクラスを呼び出して、findAllメソッドを呼び出し。
        $todo_list = Todo::findAll();
        return $todo_list;

        //findByIdメソッドを新しく追加し、$todo_idをパラメータを引数にいれて渡す
        $todo = Todo::findById($todo_id);
        //display_statusという新しくキーを作成し、TodoクラスgetDisplayメソッドを通して、画面表示用のステータスを取得する
        $todo['display_status'] = Todo::getDisplayStatus($todo_list['status']);
        return $todo;
    }

    // detail(詳細)のメソッド作成
    public function detail() {
         // パラメータからgetパラメータであるtodo_idを取得する
        $todo_id = $_GET['todo_id'];

        //todoテーブルに登録されていないtodo_idがURLで指定されたら、404.phpに遷移するようにする
        if(!$todo_id) {
            //error
            header("Location: ./../error/404.php");
            return;
        }

        if(Todo::isExistById($todo_id) === false) {
            //getパラメータにtitle,detail情報を取得する?以降のものがパラメータとして取得できる
            //保存が失敗すれば、edit.phpに遷移
            header("Location: ./../error/404.php");
            return;
        }

        //findByIdメソッドを新しく追加し、$todo_idをパラメータを引数にいれて渡す
        $todo = Todo::findById($todo_id);
        //display_statusという新しくキーを作成し、TodoクラスgetDisplayメソッドを通して、画面表示用のステータスを取得する
        $todo['display_status'] = Todo::getDisplayStatus($todo_list['status']);
        return $todo;
    }

    public function new() {
        // $title,$detailをクラスに持たせる必要があるので$dataに配列を格納
        $data = array(
            "title" => $_POST['title'],
            "detail" => $_POST['detail']
        );

        // validationクラスをインスタンス化する
        $validation = new TodoValidation;
        //$dataをインスタンスに渡す必要がるためsetDataメソッドを使う
        $validation->setData($data);

        //checkメソッドのバリデーションがfalseの値で返ってきたら、new.phpに遷移するようになる
        if($validation->check() === false) {
            // $validationをインスタンス化して、validationクラスにメソッドを追加して取得する
            $error_msgs = $validation->getErrorMessages();

            // ブラウザに表示するためにnew.php遷移した時に保持する必要がるためsessionを使う
            session_start();
            // エラーメッセージをセッションに格納
            $_SESSION['error_msgs'] = $error_msgs;

            // パラメータ(get)に入力した値を持たせて、再度new.phpに再遷移
            $params = sprintf("?title=%s&detail=%s", $_POST['title'], $_POST['detail']);
            header(sprintf("Location: ./new.php%s", $params));
        }

        // $validationクラスをインスタンス化する事でバリデーションのデータを取得
        // checkメソッドでバリデーションチェックを行い正常値として、$valid_dataをセットする。
        $valid_data = $validation->getData();

        // まずはnewメソッドにてインタンス化をする。
        $todo = new Todo;
        // 後々使うために関数を準備
        // setTitleにはバリデーションチェック後のものをセット
        $todo->setTitle($valid_data['title']);
        $todo->setDetail($valid_data['detail']);
        // 追加を更新するためsaveメソッドを使う
        // modelsのqueryメソッドに送る
        // saveメソッドの返り値を取得ため$resultに代入する
        $result = $todo->save();
        // queryは動作に失敗したらfalseを返すので、todoクラスがfalseになり返り値がfalseの場合はnew.phpに遷移するようにする

        if($result === false) {
            //getパラメータにtitle,detail情報を取得する?以降のものがパラメータとして取得できる
            $params = sprintf("?title=%s&detail=%s", $valid_data['title'], $valid_data['detail']);
            header(sprintf("Location: ./new.php%s", $params));
            return;
        }
        // 保存が成功し、返り値が戻ってきたら、new.phpからindex.phpに遷移するようにする
        header("Location: ./index.php");
    }

    public function edit() {
        $todo_id = '';
        $params = array();
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            if(isset($_GET['todo_id'])) {
                $todo_id = $_GET['todo_id'];
            }
            if(isset($_GET['title'])) {
                // 編集画面に入力したものを取得
                $params['title'] = $_GET['title'];
            }
            if(isset($_GET['detail'])) {
                // 編集画面に入力したものを取得
                $params['detail'] = $_GET['detail'];
            }
        }

        //todoテーブルに登録されていないtodo_idがURLで指定されたら、404.phpに遷移するようにする
        if(!$todo_id) {
            //error
            header("Location: ./../error/404.php");
            return;
        }

        if(Todo::isExistById($todo_id) === false) {
            //getパラメータにtitle,detail情報を取得する?以降のものがパラメータとして取得できる
            //保存が失敗すれば、edit.phpに遷移
            header("Location: ./../error/404.php");
            return;
        }

        //Todoクラスを取得する。
        $todo = Todo::findById($todo_id);
        // $todoがなければ404ページに遷移
        if(!$todo) {
            header("Location: ./../error/404.php");
            return;
        }

        $data = array(
            "todo" => $todo,
            "params" => $params
        );

        return $data;
    }

    public function update() {
        if(!$_POST['todo_id']) {
            // ブラウザに表示するためにnew.php遷移した時に保持する必要がるためsessionを使う
            session_start();
            // エラーメッセージをセッションに格納
            $_SESSION['error_msgs'] = '指定したIDに該当するデータがありません。';

            header("Location: ./index.php");
            return;
        }

        // Todoクラスにtodo_idに該当するデータがあるかを確認する。
        // todo_idが存在するか確認するためのメソッド、レコードが存在しなければedit.phpに遷移する
        if(Todo::isExistById($_POST['todo_id']) === false) {
            //getパラメータにtitle,detail情報を取得する?以降のものがパラメータとして取得できる
            //保存が失敗すれば、edit.phpに遷移
            $params = sprintf("?todo_id=%s&title=%s&detail=%s",$_POST['todo_id'], $_POST['title'], $_POST['detail']);
            header(sprintf("Location: ./edit.php%s", $params));
            return;
        }

        // $title,$detailをクラスに持たせる必要があるので$dataに配列を格納
        $data = array(
            // updateにtodo_idを指定する必要がある
            "todo_id" => $_POST['todo_id'],
            "title" => $_POST['title'],
            "detail" => $_POST['detail']
        );

        // validationクラスをインスタンス化する
        $validation = new TodoValidation;
        //$dataをインスタンスに渡す必要がるためプロパティにポスト値をセット
        $validation->setData($data);

        //checkメソッドのバリデーションがfalseの値で返ってきたら、edit.phpに遷移するようになる
        if($validation->check() === false) {
            // $validationをインスタンス化して、validationクラスにメソッドを追加して取得する
            $error_msgs = $validation->getErrorMessages();

            // ブラウザに表示するためにnew.php遷移した時に保持する必要がるためsessionを使う
            session_start();
            // エラーメッセージをセッションに格納
            $_SESSION['error_msgs'] = $error_msgs;

            // パラメータ(get)に入力した値を持たせて、再度new.phpに再遷移
            $params = sprintf("?todo_id=%s&title=%s&detail=%s",$_POST['todo_id'], $_POST['title'], $_POST['detail']);
            header(sprintf("Location: ./edit.php%s", $params));
            return;
        }

        // $validationクラスをインスタンス化する事でバリデーションのデータを取得
        // checkメソッドでバリデーションチェックを行い正常値として、$valid_dataをセットする。
        $valid_data = $validation->getData();

        // まずはnewメソッドにてインタンス化をする。
        $todo = new Todo;
        // 後々使うために関数を準備
        // setTitleにはバリデーションチェック後のものをセット
        $todo->setId($valid_data['todo_id']);
        $todo->setTitle($valid_data['title']);
        $todo->setDetail($valid_data['detail']);
        // 追加を更新するためsaveメソッドを使う
        // modelsのqueryメソッドに送る
        // updateメソッド$resultに代入する
        $result = $todo->update();
        // queryは動作に失敗したらfalseを返すので、todoクラスがfalseになり返り値がfalseの場合はnew.phpに遷移するようにする
        if($result === false) {
            //getパラメータにtitle,detail情報を取得する?以降のものがパラメータとして取得できる
            //保存が失敗すれば、edit.phpに遷移
            $params = sprintf("?todo_id=%stitle=%s&detail=%s", $valid_data['id'], $valid_data['title'], $valid_data['detail']);
            header(sprintf("Location: ./edit.php%s", $params));
            return;
        }
        // 保存が成功し、返り値が戻ってきたら、new.phpからindex.phpに遷移するようにする
        header("Location: ./index.php");
    }

    public function delete()
    {
        $todo_id = $_POST['todo_id'];
        if(!$todo_id) {
            error_log(sprintf("[TodoController][delete]todo_id is not found. todo_id: %s", $todo_id));
            return false;
        }

        //レコードチェック、レコードがなければfalse
        if(Todo::isExistById($todo_id) === false) {
            error_log(sprintf("[TodoController][delete]record is not found. todo_id: %s", $todo_id));
            return false;
        }

        // 削除の処理を実行する
        $todo = new Todo;
        $todo->setId($todo_id);
        $result = $todo->delete();

        return $result;
    }
}