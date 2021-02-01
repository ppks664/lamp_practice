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

//item_idをget_postで受け取ったら$item_idに入れる
$item_id = get_post('item_id');

//$item_idとuser_idがセットされた$userと$dbがadd_cartで受け取った場合、カートに商品を追加しましたと表示それ以外は、エラー
if(add_cart($db,$user['user_id'], $item_id)){
  set_message('カートに商品を追加しました。');
} else {
  set_error('カートの更新に失敗しました。');
}
//ホーム画面に戻す
redirect_to(HOME_URL);