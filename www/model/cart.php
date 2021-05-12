<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function get_user_carts($db, $user_id)
{
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = ?
  ";
  return fetch_all_query($db, $sql, [$user_id]);
}

function get_user_cart($db, $user_id, $item_id)
{
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = ?
    AND
      items.item_id = ?
  ";

  return fetch_query($db, $sql, [$user_id, $item_id]);
}

function add_cart($db, $user_id, $item_id)
{
  $cart = get_user_cart($db, $user_id, $item_id);
  if ($cart === false) {
    return insert_cart($db, $user_id, $item_id);
  }
  return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1);
}

function insert_cart($db, $user_id, $item_id, $amount = 1)
{
  $sql = "
    INSERT INTO
      carts(
        item_id  ,
        user_id ,
        amount 
      )
    VALUES(?,?,?)
  ";

  return execute_query($db, $sql, [$item_id, $user_id, $amount]);
}

function update_cart_amount($db, $cart_id, $amount)
{
  $sql = "
    UPDATE
      carts
    SET
      amount = ?
    WHERE
      cart_id = ?
    LIMIT 1
  ";
  return execute_query($db, $sql, [$amount, $cart_id]);
}

function delete_cart($db, $cart_id)
{
  $sql = "
    DELETE FROM
      carts
    WHERE
      cart_id = ?
    LIMIT 1
  ";

  return execute_query($db, $sql, [$cart_id]);
}

function get_orders($db,$user_id = null)
{
  $sql = "
    SELECT 
    orders.order_number ,
    user_id , 
    order_datetime, 
    sum(amount * price) as total_price
    FROM orders
    INNER JOIN order_details 
    on orders.order_number = order_details.order_number
  ";
  if($user_id !== null) {
    $sql .= "
      WHERE 
        user_id = ?";
  }
    $sql .= "
      GROUP BY orders.order_number
      ORDER BY orders.order_number DESC
      ";
  if($user_id !== null) {
    return fetch_all_query($db,$sql,[$user_id]); 
  }
    return fetch_all_query($db,$sql);
}


function get_order_details($db,$order_number,$user_id=null) {
  $sql = "
    SELECT 
    name ,
    user_id,
    orders.order_number,
    order_details.price ,
    order_details.amount 
    FROM order_details 
    INNER JOIN items
    on order_details.item_id = items.item_id
    INNER JOIN orders
    on order_details.order_number = orders.order_number
    WHERE order_details.order_number = ?
    ";
    if($user_id !== null) {
      $sql .="
      AND user_id = ?
      ";
      return fetch_all_query($db,$sql,[$order_number,$user_id]);
    }
      return fetch_all_query($db,$sql,[$order_number]);
}

function get_order_record($db,$order_number,$user_id = null) {
  $sql = "
    SELECT 
    orders.order_number ,
    user_id,
    order_datetime , 
    sum(amount * price) as total_price
    FROM order_details
    INNER JOIN orders 
    on orders.order_number = order_details.order_number
    WHERE orders.order_number = ?
    ";
    if($user_id !== null) {
      $sql .= "
      AND user_id = ?
      ";  
    }
    $sql .= "
    GROUP BY orders.order_number
    ";
    if($user_id !== null) {
      return fetch_all_query($db,$sql,[$order_number,$user_id]);
    }
    return fetch_all_query($db,$sql,[$order_number]);
  
}


function purchase_carts($db, $carts)
{
  if (validate_cart_purchase($carts) === false) {
    return false;
  }
  //トランザクション開始
  $db->beginTransaction();
    foreach ($carts as $cart) {
      //在庫数更新処理
      if (update_item_stock(
        $db,
        $cart['item_id'],
        $cart['stock'] - $cart['amount']
      ) === false) {
        set_error($cart['name'] . 'の購入に失敗しました。');
      }
    }
    if(register_orders($db,$carts) === false) {
      set_error( '購入に失敗しました。');
    }
    //カート内アイテム削除
    if(delete_user_carts($db, $carts[0]['user_id']) === false) {
      set_error('購入に失敗しました。');
    }
    if(has_error() !== true) {
      $db->commit();
      return true;
    }
      $db->rollback();
      return false; 
}

function register_orders($db,$carts) {
  //購入履歴インサート関数
  if(insert_orders($db, $carts[0]['user_id']) === false) {
    set_error('購入履歴の作成に失敗しました。');
    return false;
  }
  //上記でインサートしたオーダーナンバー取得
  $order_number = $db->lastInsertId('order_number');
  foreach ($carts as $cart) {
    //購入明細インサート関数
    if(insert_order_details(
      $db, $order_number,
      $cart['item_id'], $cart['amount'], $cart['price']) === false) {
        set_error($cart['name'].'の購入明細の作成に失敗しました。');
      }
  }
  if(has_error() === true) {
    return false;
  }
  return true;
}

//購入履歴インサート関数
function insert_orders($db, $user_id)
{
  $sql = "
    INSERT INTO
      orders(
        user_id ,
        order_datetime
      )
    VALUES(?, now())
    ";

  return execute_query($db, $sql, [$user_id]);
}
//購入明細のインサート関数
function insert_order_details($db, $order_number, $item_id, $amount, $price)
{
  $sql = "
  INSERT INTO
    order_details(
      order_number ,
      item_id ,
      amount ,
      price
    )
  VALUES(?,?,?,?)
  ";
  return execute_query($db, $sql, [$order_number, $item_id, $amount, $price]);
}

function delete_user_carts($db, $user_id)
{
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = ?
  ";

  execute_query($db, $sql, [$user_id]);
}


function sum_carts($carts)
{
  $total_price = 0;
  foreach ($carts as $cart) {
    $total_price += $cart['price'] * $cart['amount'];
  }
  return $total_price;
}

function validate_cart_purchase($carts)
{
  if (count($carts) === 0) {
    set_error('カートに商品が入っていません。');
    return false;
  }
  foreach ($carts as $cart) {
    if (is_open($cart) === false) {
      set_error($cart['name'] . 'は現在購入できません。');
    }
    if ($cart['stock'] - $cart['amount'] < 0) {
      set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']);
    }
  }
  if (has_error() === true) {
    return false;
  }
  return true;
}
