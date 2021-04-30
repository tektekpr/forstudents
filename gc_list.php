<?php
require 'dbconnect.php';
require 'session.php';
/*$dsn = 'mysql:host=localhost;dbname=ph24;charset=utf8mb4';
$db_user = 'root';
$db_password = '';
*/
$u_ID_box = $_SESSION['u_ID'];
try{
    //DB接続オブジェクト
    //PDO…PHP Data Object
    //$pdo = new PDO($dsn, $db_user, $db_password);
    //let logo = getElementById('id');

    //PDOの設定変更
    /*$pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
    $pdo->setAttribute(
        PDO::ATTR_EMULATE_PREPARES,
        false
    );*/

    //SQL文作成
    // $sql = "SELECT id, password FROM kadai05_users WHERE id=:id";
    $sql = "SELECT * FROM gc where g_deleted_at IS NULL AND u_id = $u_ID_box";
    //$sql = "SELECT * FROM qa where q_solved_at IS NULL";

    //プリペアードステートメントの設定と取得
    $prestmt = $db->prepare($sql);

    //SQL実行
    $prestmt->execute();

    //抽出結果取得
    $gc = $prestmt->fetchALL(PDO::FETCH_ASSOC);
}catch(PDOException $error){
    //エラー時の処理を書く
    // echo $error->getMessage();
    // echo $error->getCode();
    if($gc['g_id'] === ""){
        //ここに表示させたいメッセージを入力する
        // $_SESSION['error'] = '質問は投稿されていません';
        // unset($_SESSION['error']);
    }
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
    <link rel="stylesheet" href="css/qa_list.css">
    <title>TAMARIBA | グループチャット管理</title>
    <script>
    function pardon(abc) {
        var result = confirm('選択したグループチャットを削除します。よろしいですか？');

        if(result) {
            location.href = "gcdeleted.php?id=" + abc;
        }
        else {
            alert('キャンセルしました');
        }
    }
    </script>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="wrapper">
        <div class="title_menu">
            <h2>グループチャット管理</h2>
            <p><a href="gc.php">チャット作成</a></p>
            <p style="right:160px;"><a href="gcsearch.php">チャット一覧</a></p>
        </div>
        <main>
            <!-- ここでセッションエラーに履いてなかったら値をしまう -->
            <?php if(isset($_SESSION['error'])){ echo $_SESSION['error']; } ?>
            <?php foreach($gc as $gcs){ ?>
                <div class="qa_box_wrapper">
                    <div class="qa_box1">
                        <a href="gc.php?g_id=<?php echo $gcs['g_id'] ?>">
                            <h3><?php echo $gcs['g_title'];  ?></h3>
                        </a>


                        <div class="option">
                            <p><a onClick="pardon(<?php echo $gcs['g_id']; ?>)">削除</a></p>
                        </div>
                    </div>
                    <!-- 他に表示させたい内容がるなら上のh2をコピーして値を変えてください -->

                </div>
            <?php } ?>
        </main>    
    </div>
    <?php include('footer.html'); ?>
</body>
</html>