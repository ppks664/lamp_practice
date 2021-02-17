<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'cart.php';
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
//db接続
$db = get_db_connect();
$order_id = get_post('order_id');

$details = get_detail($db,$order_id);

$created = get_post('created');
$total_price = get_post('total_price');






include_once VIEW_PATH . 'detail_view.php';