<?php
    require 'dbconnect.php';
    require 'session.php';

      // SQL文を作成
    $stmt = $db->prepare('select * from Users where u_id = ?');

    //GETはidで送ること
    $stmt->execute([$_GET['id']]);
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
        $club = '未記入';
    }

    if(empty($row['u_comment'])){
        $comment = "未記入";
    }else{
        $comment = $row['u_comment'];
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="none,noindex,nofollow">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/userpage.css">
    <title>TAMARIBA | プロフィール</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="wrapper">
        <h2>プロフィール</h2>
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
    </div>
    <?php include('footer.html'); ?>
</body>
</html>