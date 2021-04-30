<?php
require 'dbconnect.php';
require 'session.php';

$u_ID_box = $_SESSION['u_ID'];
/*$dsn = 'mysql:host=localhost;dbname=ph24;charset=utf8mb4';
$db_user = 'root';
$db_password = '';
*/
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
    $sql = "SELECT * FROM qa where q_deleted_at IS NULL AND u_ID = $u_ID_box";
    //$sql = "SELECT * FROM qa where q_solved_at IS NULL";

    //プリペアードステートメントの設定と取得
    $prestmt = $db->prepare($sql);

    //SQL実行
    $prestmt->execute();

    //抽出結果取得
    $qas = $prestmt->fetchALL(PDO::FETCH_ASSOC);
}catch(PDOException $error){
    //エラー時の処理を書く
    // echo $error->getMessage();
    // echo $error->getCode();
    if($qas['q_id'] === ""){
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
    <title>TAMARIBA | 質問管理</title>
    <script>
        function pardon(abc) {
            var result = confirm('該当の項目を削除します。\n削除した場合二度と復元できなくなります。続行しますか？');
            
            if(result) {
                location.href = "qa_deleted.php?id=" + abc;
            }
            else {
                alert('削除を取り消しました。');
            }
        }
        function solved(abc) {
            var result = confirm('該当の項目を解決済みに変更しますか？');
            
            if(result) {
                location.href = "qa_solved.php?id=" + abc;
            }
            else {
                alert('キャンセルしました。');
            }
        }
    </script>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="wrapper">
        <div class="title_menu">
            <h2>質問管理</h2>
            <p><a href="qa_create_form.php">質問作成</a></p>
            <p style="right:160px;"><a href="qa.php">質問一覧</a></p>
        </div>
        <main>
            <!-- ここでセッションエラーに履いてなかったら値をしまう -->
            <?php if(isset($_SESSION['error'])){ echo $_SESSION['error']; } ?>
            <?php foreach($qas as $qa){ ?>
                <div class="qa_box_wrapper">
                    
                        <div class="qa_box1">
                        <a href="qaAnswer.php?q_id=<?php echo $qa['q_id'] ?>&u_ID=<?php echo $qa['u_ID'] ?>">
                            <h3><?php echo $qa['q_title'];  ?></h3>
                        </a>
                            <div class="option">
                                <p class="a_left"onclick="solved(<?php echo $qa['q_id']?>)">解決済みに変更</p>
                                <p onclick="pardon(<?php echo $qa['q_id']?>)">削除</p>
                            </div>
                        </div>

                </div>
            <?php } ?>
        </main>    
    </div>
    <?php include('footer.html'); ?>
</body>
</html>