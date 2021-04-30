<?php
    require 'dbconnect.php';
    require 'session.php';
    $data = [];

    if (isset($_SESSION['u_ID'])) {
        $id = $_SESSION['u_ID'];
        $sql = "SELECT * FROM ownedstamp WHERE u_id = $id AND st_deleted_at IS NULL";
        $gcs = $db->query($sql);
        $data = $gcs->fetchAll();

    }else{
        header('Location: mypage.php');
    }
    //print_r($data);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="none,noindex,nofollow">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/owned.css">
    <title>TAMARIBA | 購入履歴</title>
</head>
<body>
    <?php include('header.php'); ?>
        <div class="wrapper">
            <div class="title_menu">
                <h2>購入履歴</h2>
                <p><a href="mypage.php">マイページ</a></p>
                <p style="right:160px;"><a href="shophome.php">ショップ</a></p>
            </div>
            <main>
                <?php
                    if(!empty($data)){
                        foreach($data as $datas){
                            $datau = $datas['st_id'];
                            $sql = "SELECT * FROM stamp WHERE st_id = $datau AND st_deleted_at IS NULL";
                            $gcs = $db->query($sql);
                            $datam = $gcs->fetch();
                            echo '<div class="stamp_box">
                                    <div class="stamp_img">
                                      <img src="'.$datam[2].'" alt="スタンプイメージ">
                                    </div>
                                    <h3 class="stamp_title">'.$datam[1].'</h3>
                                    <p class="stamp_price">'.$datam[3].'pt</p>
                                  </div>';
                          }         
                    }
                
                ?>
            </main>
        </div>
        <?php include('footer.html'); ?>
</body>
</html>