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
//$userにセットするuser_idと$dbをget_user_cartsで受けとったら、$cartsに入れる
$carts = get_user_carts($db, $user['user_id']);
//$cartと$dbをpuchase_cartsで受け取れないかった場合は、商品を購入できませんでした。と表示そして、カート画面に返す
if(purchase_carts($db, $carts) === false){
  set_error('商品が購入できませんでした。');
  redirect_to(CART_URL);
} 

$total_price = sum_carts($carts);

include_once '../view/finish_view.php';