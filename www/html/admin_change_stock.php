<?php
//定数ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
//userデータ関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
//itemデータ関数ファイル読み込み
require_once MODEL_PATH . 'item.php';
//セッションスタート
session_start();
//ログインチェック関数
if (is_logined() === false) {
  //ログインしていない場合ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
//db接続関数
$db = get_db_connect();

//ログインユーザー情報取得
$user = get_login_user($db);

//管理者チェック
if (is_admin($user) === false) {
  redirect_to(LOGIN_URL);
}

//POSTデータ取得し変数へ
$item_id = get_post('item_id');
$stock = get_post('stock');
$token = get_post('token');

//トークンのチェック関数
if (is_valid_csrf_token($token)) {
  //在庫数の変更処理
  if (update_item_stock($db, $item_id, $stock)) {
    set_message('在庫数を変更しました。');
  } else {
    set_error('在庫数の変更に失敗しました。');
  }
} else {
  set_error('不正な操作が行われました。');
}

redirect_to(ADMIN_URL);
