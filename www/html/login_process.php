<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();
//log inしていないのならログイン画面に戻す
if(is_logined() === true){
  redirect_to(HOME_URL);
}
//nameとpasswordをget_postで受け取ったら$name$passwordに入れる
$name = get_post('name');
$password = get_post('password');
//db接続
$db = get_db_connect();

//
$user = login_as($db, $name, $password);
//$userが間違っていれば、log in失敗と表示そして、ログイン画面に戻す。
if( $user === false){
  set_error('ログインに失敗しました。');
  redirect_to(LOGIN_URL);
}

set_message('ログインしました。');
//
if ($user['type'] === USER_TYPE_ADMIN){
  redirect_to(ADMIN_URL);
}
redirect_to(HOME_URL);