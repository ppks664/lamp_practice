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
//db接続
$db = get_db_connect();
//ユーザーデータベースに接続
$user = get_login_user($db);
//商品のデータベースに接続
$items = get_open_items($db);

include_once VIEW_PATH . 'index_view.php';