<?php

//クラスを宣言する。
//フレームワークではコマンドにて、生成される
//最初の一文字目は大文字を記入
//require_onceも忘れずに記入する。

// Todoクラスにてメソッドが実行される。
class TodoController {
    // まずはindex(一覧)のメソッドを作成
    public function index() {
        //Todoクラスを呼び出して、findAllメソッドを呼び出し。
        $todo_list = Todo::findAll();
        return $todo_list;
    }
}