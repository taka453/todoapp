<?php
require_once('./../../controller/TodoController.php');

//controllerクラスをインスタンス化
$controller = new TodoController;
//コントロールクラスのdelteメソッドを実行
// $result= $controller->delete();
//配列準備
$response = array();

if($result) {
    $response['result']= 'success';
} else {
    $response['result'] = 'fail';
}

// 配列は文字列にはできないので、json_encodeにて文字列化を行う。
echo json_encode($response);

