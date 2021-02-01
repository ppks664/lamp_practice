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
//$userに入っているuser_idと$dbをget_user_cartsそれを$cartsに入れる
$carts = get_user_carts($db, $user['user_id']);
//$cartsをsum_cartsで受け取ったら$total_priceに入れる
$total_price = sum_carts($carts);
//トークンの受け取り
$token = get_csrf_token();

include_once VIEW_PATH . 'cart_view.php';