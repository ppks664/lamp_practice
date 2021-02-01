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
$token = get_post('token');
if(is_valid_csrf_token($token) === false){
  redirect_to(LOGIN_URL);
}
unset($_SESSION['csrf_token']);
//データベースに接続
$db = get_db_connect();
//ユーザーデータベースに接続
$user = get_login_user($db);
//adminでログインができない場合は、ログイン画面に戻す
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//name,price,status,stockをget_postで受けっとたら、$name$price$status$stockのそれぞれに入れる。
$name = get_post('name');
$price = get_post('price');
$status = get_post('status');
$stock = get_post('stock');
//imageをget_postで受け取ったら$imageにいれる
$image = get_file('image');

//$db,$name$price$stock$status$imageをregist_itemで受け取ったら商品を登録しましたと表示、それ以外はエラー表示
if(regist_item($db, $name, $price, $stock, $status, $image)){
  set_message('商品を登録しました。');
}else {
  set_error('商品の登録に失敗しました。');
}


redirect_to(ADMIN_URL);