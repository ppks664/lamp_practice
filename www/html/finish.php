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
//$userにセットするuser_idと$dbをget_user_cartsで受けとったら、$cartsに入れる
$carts = get_user_carts($db, $user['user_id']);
//トランザクションを開始
$db->beginTransaction();
//$cartと$dbをpuchase_cartsで受け取れないかった場合は、商品を購入できませんでした。と表示そして、カート画面に返す
if(purchase_carts($db, $carts) === false){
  set_error('商品が購入できませんでした。');
  //rollback
  $db->rollback();
  redirect_to(CART_URL);
} 

$total_price = sum_carts($carts);

//購入履歴の追加
  if(add_history($db,$user['user_id'],$total_price) === false){
    //失敗したらエラーをセットエラー
    set_error('購入履歴の追加が出来ませんでした。');
    //rollback
    $db->rollback();
    //redirect
    redirect_to(CART_URL);
  }
  $oder_id = $db->lastInsertId();

//購入詳細の追加
if(add_detail($db,$oder_id,$carts) === false){
  //失敗したらエラーをセットエラー
  set_error('購入詳細の追加が出来ませんでした。');
  //rollback
  $db->rollback();
  //redirect
  redirect_to(CART_URL);
}
//commit
  $db->commit();


include_once '../view/finish_view.php';