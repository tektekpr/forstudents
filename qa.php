<?php
require 'dbconnect.php';
require 'session.php';
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
    $sql = "SELECT * FROM qa where q_deleted_at IS NULL";
    //$sql = "SELECT * FROM qa where q_solved_at IS NULL";

    //プリペアードステートメントの設定と取得
    $prestmt = $db->prepare($sql);

    //SQL実行
    $prestmt->execute();

    //抽出結果取得
    $qas = $prestmt->fetchALL(PDO::FETCH_ASSOC);
    $qas=array_reverse($qas);
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
if (isset($_POST['sort'])) {
    $sort=$_POST['sort'];
    if($sort==1){
      $qas=array_reverse($qas);
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
    <link rel="stylesheet" href="css/qa.css">
    <link rel="stylesheet" href="css/testserch.css">
    <title>TAMARIBA | 質問掲示板</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="wrapper">
        <div class="title_menu">
            <h2>質問掲示板</h2>
            <p><a href="qa_create_form.php">質問作成</a></p>
            <p style="right:160px;"><a href="qa_list.php">質問管理</a></p>
        </div>
        <form class="sort" action="qa.php" method="post">
        <select class="" name="sort">
            <?php
              #ソート内容の取得


              #取得結果による現在のソート
              if ($sort==1) {
                echo '<option value="1">古い順</option><option value="0">新しい順</option>';
              }
              elseif($sort==0){
                echo '<option value="0">新しい順</option><option value="1">古い順</option>';
              }
            ?>

        </select>
        <input type="submit" value="ソートする">
      </form>
        <main>

            <!-- ここでセッションエラーに履いてなかったら値をしまう -->
            <?php if(isset($_SESSION['error'])){ echo $_SESSION['error']; } ?>
            <?php foreach($qas as $qa){ ?>
                <div class="qa_box_wrapper">
                    <a href="qaAnswer.php?q_id=<?php echo $qa['q_id'] ?>&u_ID=<?php echo $qa['u_ID'] ?>">
                    <div class="qa_box1">
                        <h3><?php echo $qa['q_title']; ?></h3>
                        <p>
                            <?php
                                if(empty($qa['q_solved_at'])){
                                    echo '(未解決)';
                                }else{
                                    echo '(解決済み)';
                                }
                            ?>
                        </p>
                    </div>
                    <div class="qa_box2">
                        <p><?php echo $qa['q_count'].'回閲覧'; ?></p>
                        <P><?php echo $qa['q_created_at'];?></P>
                    </div>
                    
                    <!-- 他に表示させたい内容がるなら上のh2をコピーして値を変えてください -->
                    </a>
                </div>
            <?php } ?>
        </main>    
    </div>
    <?php include('footer.html'); ?>
</body>
</html>