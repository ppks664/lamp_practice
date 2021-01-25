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
//db接続
$db = get_db_connect();
//ユーザーデータベースに接続
$user = get_login_user($db);
//cart_idをget_postに受け取ったら$cart_idにいれる
$cart_id = get_post('cart_id');
//$db$cart_idがdelete_cartに入ったら、カートを削除しましたと表示。それ以外は、カートの削除に失敗しましたと表示
if(delete_cart($db, $cart_id)){
  set_message('カートを削除しました。');
} else {
  set_error('カートの削除に失敗しました。');
}

redirect_to(CART_URL);