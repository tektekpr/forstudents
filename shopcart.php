<?php
  require 'session.php';
  require 'dbconnect.php';
  $data = [];
    if (isset($_SESSION['carts'])) {
      $cart = $_SESSION['carts'];

      foreach ($cart as $id) {
        $sql = "SELECT * FROM stamp WHERE st_id = $id";
        $stamp = $db->query($sql);
        $datas = $stamp->fetchAll();
        $data[] = $datas;
      }  
    }

    $total = 0;
  //print_r($data);
  //print_r($_SESSION['carts']);
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="none,noindex,nofollow">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/shopcart.css">
    <!-- <link rel="stylesheet" href="../css/shophome.css"> -->
    <title>TAMARIBA | カート画面</title>
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="wrapper">
      <div class="title_menu">
          <h2>カート画面</h2>
          <p><a href="shophome.php">ショップ画面</a></p>
      </div>
      <main>
        <div class="cart">
        <?php
        if (isset($_SESSION['s_error'])) {
          echo '<p>'.$_SESSION['s_error'].'</p>';
          $_SESSION['s_error'] = '';
        }
        if(!empty($_SESSION['carts'])){
          foreach($data as $datas){
            echo '<div class="stamp_box">
                    <div class="stamp_img">
                      <img src="'.$datas[0][2].'" alt="スタンプイメージ">
                    </div>
                    <h3 class="stamp_title">'.$datas[0][1].'</h3>
                    <p class="stamp_price">'.$datas[0][3].'pt</p>
                    <div class="remove">
                      <a href="remove_cart.php?sid='.$datas[0][0].'">削除</a>
                    </div>
                  </div>';
            $total += $datas[0][3];
          } 
        }else{
          echo "<p>カート内に商品がありません</p>";
        }
        
        
        echo "</div><div class='pay'><h3>会計</h3><div class='total'><p>合計</p><p class='num'>".$total."pt</p></div>"; ?>
        <form action="pay.php" method="post">
          <button type="submit" name="total" value="<?php echo $total; ?>">決済画面へ</button>
        </form>
      </div>
      </main>      
    </div>
    <?php include('footer.html') ?>
  </body>
</html>