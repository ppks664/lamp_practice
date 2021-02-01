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
//データベースにユーザーの情報を接続
$user = get_login_user($db);
//アドミンでlog inを失敗したらログイン画面に戻す。
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//item_idをget_postで受け取り$item_idに入れる
$item_id = get_post('item_id');

//destroy_itemに$item_idとdbを受け取ったら商品を消去する。それ以外はエラー表示。
if(destroy_item($db, $item_id) === true){
  set_message('商品を削除しました。');
} else {
  set_error('商品削除に失敗しました。');
}



redirect_to(ADMIN_URL);