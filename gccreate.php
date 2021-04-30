<?php
    require 'dbconnect.php';
    require 'session.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="none,noindex,nofollow">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gccreate.css">
    <title>TAMARIBA | グループ作成</title>
</head>
<body>
    <?php include('header.php'); ?>
        <div class="wrapper">
            <div class="title_menu">
                <h2>グループ作成</h2>
                <p><a href="gcsearch.php">グループ一覧</a></p>
                <p style="right:160px;"><a href="gc_list.php">グループ管理</a></p>
            </div>
            <main>
                <div>
                    <form action="gcsend.php" method="POST">
                        <h3>グループチャット名</h3><input class="t" type="text" name="gc_title" maxlength = "40" required><br>
                        <h3 class="border">紹介コメント</h3><textarea type="text" name="gc_body" maxlength="255" required></textarea><br>
                        <button type="submit" name="submit">作成</button>
                    </form>
                </div>
                <div class="view_area">
                
                </div>
            </main>
        </div>
        <?php include('footer.html'); ?>
</body>
</html>