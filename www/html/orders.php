<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();

$user = get_login_user($db);

if(is_admin($user) === true){
  $orders = get_all_orders($db);
} else {
  $orders = get_user_orders($db,$user['user_id']);  
}
  

  

  

  

  


$token = get_csrf_token();

include_once VIEW_PATH . '/orders_view.php';
