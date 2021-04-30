<?php
  require 'dbconnect.php';
  require 'session.php';

  // SQL文を作成
  $stmt = $db->prepare('select * from Users where u_username = ?');
  $stmt->execute([$_SESSION['user_name']]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  /*日付データの分解*/
  $birth_date = $row['u_birthday'];
  $birth = explode('-', $birth_date);
  
  /*性別の取得*/
  if($row['u_gender'] == 0){
    $gender = '男性';
  }else{
    $gender = '女性';
  }

  if(isset($row['u_club'])){
    $club = $row['u_club'];
  }else{
    $club = "未記入";
  }

  if(empty($row['u_comment'])){
    $comment = "未記入";
  }else{
    $comment = $row['u_comment'];
  }

  //Warning: Use of undefined constant 　 - assumed '　' (this will throw an Error in a future version of PHP) in C:\xampp\htdocs\HEW\mypage.php on line 24
?>
<script>
  function withdrawal(){
    var res = confirm('この処理は退会処理です。\nこの処理を実行すると同一メールアドレスによるログイン、および登録ができなくなります。\n本当によろしいですか？');
    if(res == true){
      window.location = './withdrawal.php';
    }else{
      alert("キャンセルされました");
    }
  }

</script>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="none,noindex,nofollow">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mypage.css">
    <title>TAMARIBA | マイページ</title>
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="wrapper">
      <h2>マイページ</h2>
      <div class="my_user_data">
        <p class="icon_image"><img src="images/usericon.svg" alt="icon"></p>
        <div class="inner_user_data">
          <p class="user_data_name"><?php echo $row['u_username'];?></p>
          <p><?php echo $gender?></p>
          <p><?php echo $birth[1]."月".$birth[2]."日生まれ";?></p>
          <p><?php echo $club?></p>
          <p style="margin-top: 6px;"><?php echo $comment;?></p>
        </div>
        
      </div>
      <div class="my_menu">
        <p class="a_button"><a href="change_user_data.php">登録情報・プロフィールの変更</a></p>
        <p class="a_button"><a href="owned.php">ストア購入履歴</a></p>
        <p class="a_button"><a href="gc_list.php">グループ管理</a></p>
        <p class="a_button"><a href="test_list.php">テスト管理</a></p>
        <p class="a_button"><a href="qa_list.php">質問管理</a></p>
        <p class="a_button"><a href="support.php">サポートへの連絡</a></p>
        <p class="a_button"><a href="logout.php">ログアウト</a></p>
        <p class="a_button"><a href="#" onclick="withdrawal()">退会</a></p>
      </div>
    </div>
    <?php include('footer.html'); ?>
  </body>
</html>

