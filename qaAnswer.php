<?php

require 'dbconnect.php';
require 'session.php';

// $error_message = "";
// if(isset($_SESSION['error'])){
//     $error_message = $_SESSION['error'];
//     unset($error_message);
// }

$qa = [];
// if(isset($_SESSION['q_id'])){
//     $qa['q_id'] = $_SESSION['q_id'];
// }else{
//     $_SESSION['q_id'] = $_GET['q_id'];
//     $qa['q_id'] = $_SESSION['q_id'];
// }
if(isset($_GET['q_id'])){
    $qa['q_id'] = $_GET['q_id'];
    //質問した人のユーザーID
    $qa['u_ID'] = $_GET['u_ID'];
}


try{
//---------------------qaから問題を取ってくる
    //SQL文作成
    $sql_1 = "SELECT * FROM qa WHERE q_id=:q_id";

    //プリペアードステートメントの設定と取得
    $prestmt = $db->prepare($sql_1);

    //値の設定
    $prestmt->bindValue(':q_id', $qa['q_id']);//登録とログイン

    //SQL実行
    $prestmt->execute();

    //抽出結果取得
    $qa = $prestmt->fetch(PDO::FETCH_ASSOC);

//---------------------qaAnswerから問題の回答を取ってくる
    //SQL文作成
    $sql_2 = "SELECT * FROM qaAnswer WHERE q_id=:q_id and a_deleted_at IS NULL";

    //プリペアードステートメントの設定と取得
    $prestmt = $db->prepare($sql_2);

    //値の設定
    $prestmt->bindValue(':q_id', $qa['q_id']);//登録

    //SQL実行
    $prestmt->execute();

    //抽出結果取得
    $qaAnswers = $prestmt->fetchAll(PDO::FETCH_ASSOC);
    $qaAnswers=array_reverse($qaAnswers);

    //閲覧数処理
    $q_count = $qa['q_count'] + 1;
    $stmt = $db->prepare("update qa set q_count = ? where q_id = ?");
    $stmt->execute([$q_count,$qa['q_id']]);

    //username
       //SQL文作成
       $sql_3 = "SELECT u_username FROM users WHERE u_ID=:u_id";

       //プリペアードステートメントの設定と取得
       $prestmt = $db->prepare($sql_3);
   
       //値の設定
       $prestmt->bindValue(':u_id', $qa['u_ID']);//登録
   
       //SQL実行
       $prestmt->execute();
   
       //抽出結果取得
       $create_user = $prestmt->fetch(PDO::FETCH_ASSOC);


}catch(PDOException $error){
    //エラー時の処理を書く
    echo $error->getMessage();
    echo $error->getCode();
    if($qas['q_id'] === ""){
        //ここに表示させたいメッセージを入力する
        $_SESSION['error'] = 'qaAnswer.phpでのエラー';
        //下のコメントアウトはログインした最初のページを入れてね--いらなかったら消していい
        // header('Location: index.php');
        // exit();
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
    <link rel="stylesheet" href="css/qaanswer.css">
    <title>TAMARIBA | 質問画面</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="wrapper">
        <div class="title_menu">
            <h2>質問画面</h2>
            <p><a href="qa_create_form.php">質問作成</a></p>
            <p style="right:160px;"><a href="qa.php">質問一覧</a></p>
        </div>
        <main>
            <!-- ここで質問内容を出力 -->
            <div>
                <h3><?php echo $qa['q_title'] ?></h3>
                <div class="qa_user_data">
                    <p>作成者:<a href="userpage.php?id=<?php echo $qa['u_ID'] ?>"><?php echo $create_user['u_username'] ?></a></p>
                    <p><?php echo '作成日:'.$qa['q_created_at'] ?></p>
                    <p><?php echo '回答数:'.$qa['q_answer_count'] ?></p>
                </div>
                <p class="qa_body"><?php echo $qa['q_body'] ?></p>
            </div>
            <!-- 回答入力フォーム -->
            <div class="qa_form">
                <h3>アンサー</h3>
                <div class="inner_qa_form">
                    <form action="qaAnswer_create.php" method="POST">
                    <input type="hidden" name="q_ID" value="<?php echo $qa['q_id'] ?>">
                    <input type="hidden" name="u_ID" value="<?php echo $_SESSION['u_ID'] ?>">
                    <textarea class="ans_text" type="text" name="a_body" value="" maxlength="255" required></textarea>
                    <button type="submit">回答する</button>
                    </form>
                </div>
            </div>
            <!-- 質問に対する回答を出力 -->

            <?php if(isset($qaAnswers)){ ?>
            <?php foreach($qaAnswers as $qaAnswer){ ?>
                <div class="answer">
                    <div class="inner_answer">
                        <img src="images/usericon.svg" alt="icon">
                        <div class="inner_answer_data">
                            <p class="a"><a href="userpage.php?id=<?php echo $qaAnswer['u_ID'] ?>">
                            <?php
                            $sql_4 = "SELECT u_username FROM users WHERE u_ID=:u_id";
                            $prestmt = $db->prepare($sql_4);
                            $prestmt->bindValue(':u_id', $qaAnswer['u_ID']);//登録
                            $prestmt->execute();
                            $answer_user = $prestmt->fetch(PDO::FETCH_ASSOC);
                            echo $answer_user['u_username'];?></p>
                            </a></p>              
                            <p class="qa_date"><?php echo $qaAnswer['a_created_at'] ?>
                        </div>              
                    </div>
                    <p class="qa_ans_data"><?php echo $qaAnswer['a_body'] ?></p>

                </div>
            <?php } ?>
            <?php } ?>
        </main>
    </div>
    <?php include('footer.html'); ?>
</body>
</html>