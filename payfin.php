<?php
  require 'session.php';
  require 'dbconnect.php';
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="none,noindex,nofollow">

    <link rel="stylesheet" href="css/style.css">
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
        <p style="font-weight: bold;">お買い上げありがとうございます!</p>
      </main>      
    </div>
    <?php include('footer.html') ?>
  </body>
</html>