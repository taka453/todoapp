<?php

// todo_idを取得
$todo_id = $_POST['todo_id'];
// 配列の準備
$response = array();
// todo_id配列を追加
$response['todo_id'] = $todo_id;
// 配列は文字列にはできないので、json_encodeにて文字列化を行う。
echo json_encode($response);

