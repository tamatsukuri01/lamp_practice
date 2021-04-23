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
$order_number = get_post('order_number');
$token = get_post('token');

if (is_valid_csrf_token($token)) {

  if(is_admin($user) === true) {
  if(get_order_details($db,$order_number) === false) {
     set_error('購入明細の取得に失敗しました');
   } else {
    $details = get_order_details($db,$order_number);
   }
  if(get_order_record($db,$order_number) === false) {
      set_error('購入履歴の取得に失敗しました');
    } else {
      $records = get_order_record($db,$order_number);
    }
    
  } else {
    if(get_order_details($db,$order_number,$user['user_id']) === false) {
      set_error('購入明細の取得に失敗しました');
    } else {
      $details = get_order_details($db,$order_number,$user['user_id']);
    }
    if(get_order_record($db,$order_number,$user['user_id']) === false) {
      set_error('購入履歴の取得に失敗しました');
    } else {
      $records = get_order_record($db,$order_number,$user['user_id']);
    }
  }

} else {
  set_error('不正な操作が行われました。');
  redirect_to(ORDERS_URL);
}



include_once VIEW_PATH . '/order_details_view.php';
