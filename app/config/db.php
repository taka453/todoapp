<?php

//DB接続の記述
//hostはmysqlコンテナに入って記述を確認する必要あり。
//定数に変更、定数は大文字で記入、値の再代入ができないので注意
//ホスト名が変わると毎回設定を変更する必要があるため、mysqlに変更する。
const DSN='mysql:host=mysql;dbname=common;charset=utf8';
const USERNAME ='takano';
const PASSWORD ='takano';