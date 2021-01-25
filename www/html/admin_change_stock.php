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
//データベースと接続
$db = get_db_connect();
//ユーザーのデータを$ユーザーに入れる
$user = get_login_user($db);
//adminユーザーでない場合は、ログイン画面に返す
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}
//item_idとstockをget_postで受け取ったら$item_id、$stockに入れる
$item_id = get_post('item_id');
$stock = get_post('stock');
//$item_idと$stockを受け取ったら在庫数を変更しましたと、表示する。それ以外は、失敗しましたと表示。
if(update_item_stock($db, $item_id, $stock)){
  set_message('在庫数を変更しました。');
} else {
  set_error('在庫数の変更に失敗しました。');
}

redirect_to(ADMIN_URL);