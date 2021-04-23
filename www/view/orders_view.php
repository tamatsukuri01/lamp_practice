<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入履歴</h1>
  <div class="container">

    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <?php if(count($orders) > 0){ ?>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($orders as $order){ ?>
          <tr>
            <td><?php print(h($order['order_number'])); ?></td>
            <td><?php print(h($order['order_datetime'])); ?></td>
            <td><?php print(number_format(h($order['total_price']))); ?>円</td>
            <td>
              <form method="post" action="order_details.php">
                <input type="submit" value="購入明細" class="btn btn-danger delete">
                <input type="hidden" name="order_number" value="<?php print(h($order['order_number'])); ?>">
                <input type="hidden" name="token" value="<?php print $token ?>">
              </form>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      
    <?php } else { ?>
      <p>購入履歴がありません。</p>
    <?php } ?> 
  </div>
  
</body>
</html>