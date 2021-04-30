<?php
session_start();
//ログイン済みの場合
if (isset($_SESSION['user_name'])) {
  header('Location: top.php');
  exit;
}

if (isset($_POST['email'])) {
  try {
    $pdo = new PDO('mysql:dbname=hew2020_90031;host=127.0.0.1;charset=utf8','hew2020_90031','');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }

  //POSTのValidate。
  if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo '入力された値が不正です。';
    //return false;
  }
  //パスワードの正規表現
  if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  } else {
    echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
    //return false;
  }

  $name = $_POST['name'];
  $username = $_POST['username'];
  $u_gender = $_POST['u_gender'];
  $u_admission = $_POST['u_admission'];
  $annual = $_POST['u_annual'];
  $u_birthday = $_POST['u_birthday'];
  $s_id = 101;
  $u_pt = 0;
  $date = date("Y/m/d H:i:s");
  //登録処理
  try {
    $stmt = $pdo->prepare("insert into Users(u_name,u_username,u_password,u_mail,u_admission,u_annual,u_pt,u_gender,u_birthday,s_id,u_created_at) value(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name,$username,$password,$email,$u_admission,$annual,$u_pt,$u_gender,$u_birthday,$s_id,$date]);
    header('Location: login.php');
    exit;
  } catch (\Exception $e) {
    echo '登録済みのユーザー名またはメールアドレスです。';
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
   <title>TAMARIBA | 新規登録</title>
 </head>
 <body>
   <div class="wrapper">
     <header>
       <div class="inner_header">
        <h1><a href="index.html"><img src="images/logo.svg" alt="TAMARIBAロゴ"></a></h1>
       </div>
     </header>
     <div class="signUp_wrapper">

       <div class="form_signUp">
         <h2>新規登録</h2>
         <form action="signUp.php" method="post">
           <p>メールアドレス</p>
           <input class="input_mp"  type="email" name="email" required><br>
           <p>パスワード</p>
           <input class="input_mp" style="margin-bottom:6px;" type="password" name="password" required>
           <p class="warning" style="margin-bottom: 24px;">※パスワードは半角英数字をそれぞれ１文字以上<br>含んだ、８文字以上で設定してください。</p>
           <p>実名</p><input class="input_mp"  type="text" name="name" maxlength="50" required>
           <p>ユーザー名<span class="warning">※ユーザーに公開されます</span></p><input class="input_mp"  type="text" name="username" maxlength="50" required>
           <p>性別</p>
           <select class="input_mp"  name="u_gender" required>
             <option disabled selected>選択してください</option>
             <option value="0">男性</option>
             <option value="1">女性</option>
           </select>
           <p>誕生日</p><p><input class="input_mp"  type="date" name="u_birthday" required></p>
           <p>入学日</p><p><input class="input_mp"  type="date" name="u_admission" required></p>
           <p>年制</p><p>
             <select class="input_mp"  name="u_annual" required>
               <option disabled selected>選択してください</option>
               <option value="1">1年制（予備校など）</option>
               <option value="2">2年制（短大・専門）</option>
               <option value="3">3年制（高校）</option>
               <option value="4">4年制（大学・専門）</option>
             </select></p>
             <p>プロフィールの変更及び詳細な設定はマイページから行えます。</p>
             <button type="submit" class="submit">登録</button>

             <p class="link"><a href="login.php">ログイン</a></p>
           </div>
         </form>
       </div>
     </div>
     <footer id="footer">©2020 TAMARIBA</footer>
 </body>
</html>
