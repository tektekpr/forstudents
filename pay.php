<?php
  require 'session.php';
  require 'dbconnect.php';
  $data = [];
  $total = 0;


    if (isset($_POST['total'])) {
      if ($_POST['total']!=0) {
        if (isset($_SESSION['carts'])) {
          $cart = $_SESSION['carts'];
    
          foreach ($cart as $id) {
            $sql = "SELECT * FROM stamp WHERE st_id = $id";
            $stamp = $db->query($sql);
            $datas = $stamp->fetchAll();
            $data[] = $datas;
          }
        }
      $total = $_POST['total'];
      }else{
        header('Location: shopcart.php');
        $_SESSION['s_error'] = "購入するアイテムを選択してください";
      }

    }else{
        header('Location: shophome.php');
    }
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
    <title>TAMARIBA | 決済画面</title>
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="wrapper">
      <div class="title_menu">
          <h2>決済画面</h2>
          <p><a href="shophome.php">戻る</a></p>
      </div>
      <main>
        <div class="cart">
        <?php 
        if (isset($_SESSION['s_error'])) {
          echo '<p>'.$_SESSION['s_error'].'</p>';
          $_SESSION['s_error'] = '';
        }        
        foreach($data as $datas){ 
          echo '<div class="stamp_box">
                  <div class="stamp_img">
                    <img src="'.$datas[0][2].'" alt="スタンプイメージ">
                  </div>
                  <h3 class="stamp_title">'.$datas[0][1].'</h3>
                  <p class="stamp_price1">'.$datas[0][3].'pt</p>
                </div>';
        } 
        
        echo "</div><div class='pay pay1'><h3>支払い手続き</h3><div class='total'><p>合計</p><p class='num'>".$total."円(pt)</p></div>"; ?>
        <form class="form" action="paying.php" method="post">
          <div>
          <p>カード番号<br><input type="text" name="card" maxlength="12" value="123456789012" required></p>
          <p>期限<br><input type="text" name="date" maxlength="4" value="0123" required></p>
          <p>セキュリティコード<br><input type="text" name="sec" maxlength="3" value="012" required></p>
          </div>
          
          <button type="submit" name="total" value="<?php echo $total; ?>">注文を確定</button>
        </form>
        </div>
      </main>      
    </div>
    <?php include('footer.html') ?>
  </body>
</html>