<?php
function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start();
//ログイン済みの場合
if (isset($_SESSION['user_name'])) {
  header('Location: top.php');
  exit;
}
$error = '';
if (isset($_POST['email'])) {
  require 'dbconnect.php';
  //POSTのvalidate
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $error = '入力された値が不正です。';
    //return false;
  }
  //DB内でPOSTされたメールアドレスを検索
    $stmt = $db->prepare('select * from Users where u_mail = ? AND u_deleted_at IS NULL');
    $stmt->execute([$_POST['email']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

  //emailがDB内に存在しているか確認してパスワード照合
  if (isset($row['u_mail'])) {
    if (password_verify($_POST['password'], $row['u_password'])) {
      session_regenerate_id(true); //session_idを新しく生成し、置き換える
      $_SESSION['user_name'] = $row['u_username'];
      $_SESSION['u_ID'] = $row['u_ID'];
      header('Location: top.php');
      exit;
    } else {
      $error = 'メールアドレス又はパスワードが間違っています。';
    }
  }else{
    $error =  'メールアドレス又はパスワードが間違っています。';
  }
}

 ?>

<!DOCTYPE html>
<html lang="ja">
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <meta name="robots" content="none,noindex,nofollow">

   <link rel="stylesheet" href="css/form.css">
   <script type="text/javascript" src="./js/jquery-3.5.1.min.js"></script>
   <script type="text/javascript" src="./js/footerFixed.js"></script>
   <title>Login</title>
 </head>
 <body>
   <div class="wrapper">
     <header>
       <div class="inner_header">
         <h1><a href="index.html"><img src="images/logo.svg" alt="TAMARIBAロゴ"></a></h1>
       </div>
     </header>
     <div class="form_login">
       <h2>ログイン</h2>
       <form  action="login.php" method="post">
         <p>メールアドレス</p>
         <input class="input_mp" type="email" name="email"><br>
         <p>パスワード</p>
         <input class="input_mp" type="password" name="password"><br>
         <?php
          echo "<p class='error'>".$error."</p>"
          ?>
         <button type="submit" class="submit">ログイン</button>
       </form>
       <p class="link">
         <a href="signUp.php">新規登録</a>
       </p>
     </div>

    <footer id="footer">©2020 TAMARIBA</footer>

   </div>
    </body>
</html>
