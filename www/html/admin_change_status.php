<?php
//他の所から関数を持ってきて処理をしている。
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

//sessionスタート
session_start();
//log inをしていないまたはできていないならログイン画面に返す
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
$token = get_post('token');
if(is_valid_csrf_token($token) === false){
  redirect_to(LOGIN_URL);
}
unset($_SESSION['csrf_token']);
//データベースに接続する
$db = get_db_connect();
//ユーザーの情報のデータベースに接続
$user = get_login_user($db);
//ユーザーがデーターベースで確認されない場合は、log inページに返す。
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//get_postでitem_idとchange_toを受け取る
$item_id = get_post('item_id');
$changes_to = get_post('changes_to');
//もしopenを受け取ったらステータスを公開にする、closeを受け取ったら非公開にするそれ以外はエラー表示
if($changes_to === 'open'){
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  set_message('ステータスを変更しました。');
}else if($changes_to === 'close'){
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
  set_message('ステータスを変更しました。');
}else {
  set_error('不正なリクエストです。');
}


redirect_to(ADMIN_URL);