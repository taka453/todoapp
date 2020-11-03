<?php

class TodoValidation {
    public $data = array();
    public $error_msgs = array();

    // setDataメソッドを実装。コントローラより引数$data遅れてくるので、取得する
    public function setData($data) {
        $this->data =  $data;
    }
    // getDataメソッドを作成
    public function getData() {
        return $this->data;
    }

    //getErrorMessagesを通して、error_msgsプロパティを返す
    public function getErrorMessages() {
        return $this->error_msgs;
    }

    public function check() {
        // postパラメータから情報がわたってきているか確認する
        // プロパティにアクセスするので、$thisをつかう
        // $data配列にtitle配列があるか、dataが空ではないかを確認
        if(isset($this->data['title']) && empty($this->data['title'])) {
            // $error_msgsはプロパティにしたので、プロパティを参照するために$thisを使う
            $this->error_msgs[] = 'タイトルが空です。';
        }
        // プロパティにアクセスするので、$thisをつかう
        // data配列にdetail配列があるか、dataが空ではないかを確認
        if(isset($this->data['detail']) && empty($this->data['detail'])) {
            // $error_msgsはプロパティにしたので、プロパティを参照するために$thisを使う
            $this->error_msgs[] = '詳細が空です。';
        }

        //エラーメッセージ(配列がある)が入っておれば、結果はfalseを返す
        //$error_msgsはプロパティにしたので、プロパティを参照するために$thisを使う

        if(count($this->error_msgs) > 0) {
            return false;
        }
        //エラーメッセージ(配列がある)が入っていなければ、結果はtrueを返す。
        return true;
    }
}