<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'user.php';


session_start();
//log inしていないのならログイン画面に戻す
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
//db接続
$db = get_db_connect();
$user = get_login_user($db);
$histories = get_history($db,$user['user_id']);

if(is_admin($user) === true){
$histories = all_histories($db);
}
$token = get_csrf_token();






include_once VIEW_PATH . 'history_view.php';