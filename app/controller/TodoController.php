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
    }

    // detail(詳細)のメソッド作成
    public function detail() {
        // パラメータからgetパラメータであるtodo_idを取得する
        $todo_id = $_GET['todo_id'];
        //findByIdメソッドを新しく追加し、$todo_idをパラメータを引数にいれる渡す
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
}