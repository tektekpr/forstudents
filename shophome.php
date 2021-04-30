<?php
  require 'session.php';
  require 'dbconnect.php';

  $sql = "SELECT * FROM stamp WHERE st_deleted_at IS NULL";
  $stamp = $db->query($sql);
  $data = $stamp->fetchAll();

  //print_r($data);
  //print_r($_SESSION['carts']);
  //$_SESSION['carts'] = '';
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="none,noindex,nofollow">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/shophome.css">
    <title>TAMARIBA | ストア</title>
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="wrapper">
      <div class="title_menu">
          <h2>ストア</h2>
          <p><a href="shopcart.php">カート</a></p>
      </div>
      <main>
        <form class="" action="add_cart.php">
        <?php
        for($i=0;$i<count($data);$i++){
          echo '<div class="stamp_box"><div class="stamp_img"><img src="'.$data[$i][2].'" alt="スタンプイメージ"></div><div class="inner_stamp_box"><p class="stamp_title">'.$data[$i][1].'<p><p class="stamp_price">'.$data[$i][3].'pt</p><button type="submit" name="select" value="'.$data[$i][0].'">カートに入れる</button></div></div>';
        }
        ?>
        </form>
      </main>      
    </div>
    <?php include('footer.html') ?>
  </body>
</html>
