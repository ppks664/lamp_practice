<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
//log inが成功したらホーム画面に飛ばす。
if(is_logined() === true){
  redirect_to(HOME_URL);
}
$token = get_csrf_token();
include_once VIEW_PATH . 'signup_view.php';



