<?php
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
    <link rel="stylesheet" href="css/support.css">
    <title>TAMARIBA | サポートへ連絡</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="wrapper">
        <h2>サポートへの連絡</h2>
        <p class="subtitle">サービス向上のため不具合やトラブルなどございましたら以下のフォームからの送信をお願いします。</p>
        <form class="form_wrapper" action="support.php" method="post">
            <p>題名<input style="width:400px;" type="text" name="title" required></p>
            <p>問題の種類
            <select name="type" id="">
                <option value="1">サイトのバグや不具合</option>
                <option value="2">ユーザとの対人トラブル</option>
                <option value="3">悪質なスレなどの不適切な作成物</option>
                <option value="4">その他</option>
            </select></p>
            <p style="margin-bottom: 2px;">詳細</p>
            <textarea rows="10" cols="100;" name="text" required></textarea><br>
            <input class="button" type="submit" value="送信する">
        </form>
    </div>
    <?php include('footer.html'); ?>
</body>
</html>