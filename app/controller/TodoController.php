<?php

//クラスを宣言する。
//フレームワークではコマンドにて、生成される
//最初の一文字目は大文字を記入
//require_onceも忘れずに記入する。

require_once ("./../../model/Todo.php");

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
        $todo_list = Todo::findById($todo_id);
        return $todo_list;
    }
}