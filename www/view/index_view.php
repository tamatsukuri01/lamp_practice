<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

  <div class="container">
    <div class="col-12 clearfix">
      <h1 class="float-left">商品一覧</h1>
      <form action="index.php" method="get" class="float-right">
        <select name="sort">
          <option value="new" <?php if((isset($sort)) && $sort === "new") {echo 'selected' ;} ?>>新着順</option>
          <option value="cheap" <?php if((isset($sort)) && $sort === "cheap") {echo 'selected' ;} ?>>価格が安い順</option>
          <option value="high" <?php if((isset($sort)) && $sort === "high") {echo 'selected' ;} ?>>価格が高い順</option>
        </select>
        <input type="submit" value="並べ替え">
      </form>
    </div>

    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    
    <div class="card-deck">
      <div class="row">
      <?php foreach($items as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print(h($item['name'])); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print(IMAGE_PATH . h($item['image'])); ?>">
              <figcaption>
                <?php print(number_format(h($item['price']))); ?>円
                <?php if(h($item['stock']) > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <input type="hidden" name="item_id" value="<?php print(h($item['item_id'])); ?>">
                    <input type="hidden" name="token" value="<?php print $token ?>">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>

    <table class="table table-bordered">
      <h2>人気ランキング</h2>
      <thead class="thead-light">
        <tr>
          <th>順位</th>
          <th>商品名</th>
          <th>価格</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rankings as $key => $ranking){ ?>
          <tr>
            <td><?php print(h($key+1)); ?>位</td>
            <td><?php print(h($ranking['name'])); ?></td>
            <td><?php print(number_format(h($ranking['price']))); ?>円</td>
            <td>
              <?php if(h($ranking['stock']) > 0){ ?>
                <form action="index_add_cart.php" method="post">
                  <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                  <input type="hidden" name="item_id" value="<?php print(h($ranking['item_id'])); ?>">
                  <input type="hidden" name="token" value="<?php print $token ?>">
                </form>
              <?php } else { ?>
                <p class="text-danger">現在売り切れです。</p>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  
</body>
</html>