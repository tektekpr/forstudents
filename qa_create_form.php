<?php
    require 'session.php';

    $message = "";
    $error = "";
    if(isset($_SESSION['error'])){
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
    }
    if(isset($_SESSION['message'])){
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>
<!doctype html>
<html lang='ja'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="none,noindex,nofollow">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/qa_create_form.css">
    <title>TAMARIBA | 質問作成</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="wrapper">
        <div class="title_menu">
            <h2>質問作成</h2>
            <p><a href="#">質問管理</a></p>
            <p style="right:160px;"><a href="qa.php">質問一覧</a></p>
        </div>
        <main>
            <!-- ここでセッションエラーに履いてなかったら値をしまう -->
            <p>あなたの疑問や悩みを質問掲示板で解決しましょう！</p>
            <?php if(!is_null($error)){ echo '<p style="color:red">',$error,'</p>';} ?>
            <?php if(!is_null($message)){ echo '<p style="color:red">',$message,'</p>';} ?>
            <div>
                <form action="qa_create.php" method="POST">
                    <h3>タイトル</h3><input class="t" type="text" name="q_title" value="" maxlength = "40" required><br>
                    <h3 class="border">質問内容</h3><textarea type="text" name="q_body" value="" maxlength="255" required></textarea><br>
                    <button type="submit" name="submit">投稿</button>
                </form>
            </div>
        </main>
    </div>
    <?php include('footer.html'); ?>
</body>
</html>