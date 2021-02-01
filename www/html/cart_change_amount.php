<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

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
//db接続
$db = get_db_connect();
//ユーザーデータベースに接続
$user = get_login_user($db);
//cart_idをget_postで受け取ったら$cart_idに入れる。
$cart_id = get_post('cart_id');
//amountをget_postで受け取ったら$amountに入れる
$amount = get_post('amount');

//$db$cart_id$amountがupdate_cart_amountに入ったら購入数を更新しましたと表示それ以外は、エラー表示
if(update_cart_amount($db, $cart_id, $amount)){
  set_message('購入数を更新しました。');
} else {
  set_error('購入数の更新に失敗しました。');
}

redirect_to(CART_URL);