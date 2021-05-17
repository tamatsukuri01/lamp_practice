<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$sort = get_get('sort');

if(get_get('page_id')) {
  $now_page = (int)$_GET['page_id'];
} else {
  $now_page = 1;
}

$offset = ($now_page - 1) * MAX_VIEW;

$count = get_all_count_items($db);

$total_pages = ceil($count / MAX_VIEW);

$items = get_open_items($db,$offset,$sort);

$page_first = ($offset +1);
$page_last = min($count, $now_page * MAX_VIEW);

$rankings = get_ranking_item($db);

$token = get_csrf_token();

include_once VIEW_PATH . 'index_view.php';