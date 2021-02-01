<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();
//log inに成功したらホーム画面に進む
if(is_logined() === true){
  redirect_to(HOME_URL);
}
$token = get_post('token');
if(is_valid_csrf_token($token) === false){
  redirect_to(LOGIN_URL);
}
unset($_SESSION['csrf_token']);
//nameをget_postで受け取ったら$nameにいれる
$name = get_post('name');
//passwordをget_postで受け取ったら$password
$password = get_post('password');
//password_confirmationをget_postで受け取ったら$password_confirmationに入れる
$password_confirmation = get_post('password_confirmation');
//db接続
$db = get_db_connect();

//ユーザー登録　
try{
  $result = regist_user($db, $name, $password, $password_confirmation);
  //$resultが違った場合は、登録失敗、サインアップ画面に戻す
  if( $result=== false){
    set_error('ユーザー登録に失敗しました。');
    redirect_to(SIGNUP_URL);
  }
  //エラー処理
}catch(PDOException $e){
  set_error('ユーザー登録に失敗しました。');
  redirect_to(SIGNUP_URL);
}
//
set_message('ユーザー登録が完了しました。');
login_as($db, $name, $password);
redirect_to(HOME_URL);