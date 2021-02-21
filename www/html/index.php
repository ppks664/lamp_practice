<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();
//log inしていないのならログイン画面に戻す
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

//get通信で送信された選択した値を取得する
$change = get_get('change');
//get_open_items
if($change === ''){
  $change = '新着順';
}
//db接続
$db = get_db_connect();
//ユーザーデータベースに接続
$user = get_login_user($db);
//商品のデータベースに接続
$items = get_open_items($db,$change);
$token = get_csrf_token();
include_once VIEW_PATH . 'index_view.php';