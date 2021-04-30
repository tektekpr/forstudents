<?php
    require 'dbconnect.php';
    require 'session.php';
    $data = [];

    if (isset($_GET['g_id'])) {
        $id = $_GET['g_id'];
        $sql = "SELECT * FROM gc WHERE g_id = $id AND g_deleted_at IS NULL";
        $gcs = $db->query($sql);
        $gc = $gcs->fetch();


        $sql = "SELECT * FROM gctalk WHERE g_id = $id AND gt_deleted_at IS NULL";
        $stamp = $db->query($sql);
        $data = $stamp->fetchAll();
        $data=array_reverse($data);
    }else{
        header('Location: gcsearch.php');
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
    <link rel="stylesheet" href="css/gc.css">
    <title>TAMARIBA | グループチャット</title>
</head>
<body>
    <?php include('header.php'); ?>
        <div class="wrapper">
            <div class="title_menu">
                <h2><?php echo $gc['g_title'] ?></h2>
                <p><a href="gccreate.php">グループ作成</a></p>
                <p style="right:160px;"><a href="gcsearch.php">グループ一覧</a></p>
            </div>
            <main>
                <p class="g_about"><?php echo $gc['g_about'] ?></p>
                <div>
                    <form action="gcpost.php" method="POST">
                        <textarea class="text" type="text" name="gt_body" value="" maxlength="255" required></textarea><br>
                        <!-- 部屋関連などの送信 -->
                        <input type="hidden" name="id" value="<?php echo $_GET['g_id']; ?>">
                        <button type="submit" name="submit">投稿</button>
                    </form>
                </div>
                <div class="view_area">
                <?php if(isset($data)){ ?>
                <?php foreach($data as $datas){ ?>
                    <div class="answer">
                        <div class="inner_answer">
                            <img src="images/usericon.svg" alt="icon">
                            <div class="inner_answer_data">
                                <p class="a"><a href="userpage.php?id=<?php echo $datas['u_ID'] ?>">
                                <?php
                                $sql_4 = "SELECT u_username FROM users WHERE u_ID=:u_id";
                                $prestmt = $db->prepare($sql_4);
                                $prestmt->bindValue(':u_id', $datas['u_ID']);//登録
                                $prestmt->execute();
                                $user = $prestmt->fetch(PDO::FETCH_ASSOC);
                                echo $user['u_username'];?></p>
                                </a></p>              
                                <p class="qa_date"><?php echo $datas['gt_created_at'] ?>
                            </div>              
                        </div>
                        <p class="qa_ans_data"><?php echo $datas['gt_talk'] ?></p>

                    </div>
                <?php } ?>
                <?php } ?>
                </div>
            </main>
        </div>
        <?php include('footer.html'); ?>
</body>
</html>