<?php

require 'dbconnect.php';
require 'session.php';

// $error_message = "";
// if(isset($_SESSION['error'])){
//     $error_message = $_SESSION['error'];
//     unset($error_message);
// }

$t_id = '';
// if(isset($_SESSION['q_id'])){
//     $qa['q_id'] = $_SESSION['q_id'];
// }else{
//     $_SESSION['q_id'] = $_GET['q_id'];
//     $qa['q_id'] = $_SESSION['q_id'];
// }
if(isset($_GET['id'])){
    $t_id = $_GET['id'];
}


try{
//---------------------qaから問題を取ってくる
    //SQL文作成
    $sql_1 = "SELECT * FROM test WHERE t_id=:t_id";

    //プリペアードステートメントの設定と取得
    $prestmt = $db->prepare($sql_1);

    //値の設定
    $prestmt->bindValue(':t_id', $t_id);//登録とログイン

    //SQL実行
    $prestmt->execute();

    //抽出結果取得
    $test = $prestmt->fetch(PDO::FETCH_ASSOC);

//---------------------qaAnswerから問題の回答を取ってくる
    //SQL文作成
    $sql_2 = "SELECT * FROM testQuestion WHERE t_id=:t_id";

    //プリペアードステートメントの設定と取得
    $prestmt = $db->prepare($sql_2);

    //値の設定
    $prestmt->bindValue(':t_id', $t_id);//登録

    //SQL実行
    $prestmt->execute();

    //抽出結果取得
    $testQuestion = $prestmt->fetchAll();
//------------------------------------------------------------
    //SQL文作成
    for ($i=0; $i < count($testQuestion); $i++) { 
        $sql_3 = "SELECT * FROM testChoice WHERE t_id=:t_id AND t_q_id=:t_q_id" ;

        //プリペアードステートメントの設定と取得
        $prestmt = $db->prepare($sql_3);

        //値の設定
        $prestmt->bindValue(':t_id', $t_id);//登録
        $prestmt->bindValue(':t_q_id', $i+1);//登録

        //SQL実行
        $prestmt->execute();

        //抽出結果取得
        $testChoice[] = $prestmt->fetchAll();
    }
    

    //閲覧数処理
    $t_count = $test['t_count'] + 1;
    $stmt = $db->prepare("update test set t_count = ? where t_id = ?");
    $stmt->execute([$t_count,$t_id]);
    //print_r($test);
    //print_r($testQuestion);
    //print_r($testChoice);

        //username
       //SQL文作成
       $sql_3 = "SELECT u_username FROM users WHERE u_ID=:u_id";

       //プリペアードステートメントの設定と取得
       $prestmt = $db->prepare($sql_3);
   
       //値の設定
       $prestmt->bindValue(':u_id', $test['t_createuser']);//登録
   
       //SQL実行
       $prestmt->execute();
   
       //抽出結果取得
       $create_user = $prestmt->fetch(PDO::FETCH_ASSOC);

}catch(PDOException $error){
    //エラー時の処理を書く
    echo $error->getMessage();
    echo $error->getCode();
    if($qas['t_id'] === ""){
        //ここに表示させたいメッセージを入力する
        $_SESSION['error'] = 'qaAnswer.phpでのエラー';
        //下のコメントアウトはログインした最初のページを入れてね--いらなかったら消していい
        // header('Location: index.php');
        // exit();
    }
}



?>

<script>
    function ok(i,j){
        if(i==0){
            alert("正解");
        }else{
            alert("不正解");
        }
        var change2 = document.getElementById(j);
        change2.className = 'openans';
    }

    /*cnt_c = 1;
    function hide(i){
        if(i==0 && 1 < cnt_c){
            c = "counter"+cnt_c;
            document.getElementById(c).className = 'hide';
            min = cnt_c - 1;
            m = "counter" + min;
            document.getElementById(m).className = 'open';
        }if (i==1 && 11>cnt_c) {
            c = "counter"+cnt_c;
            document.getElementById(c).className = 'hide';
            plus = cnt_c + 1;
            p = "counter" + plus;
            document.getElementById(p).className = 'open';
        } else {
            console.log("hello");
        }
    }*/
    function hide($i){
    //console.log("hello");
    var change = document.querySelector('.open');
    change.className = 'hide';
    c = "counter" + $i;
    var change2 = document.getElementById(c);
    change2.className = 'open';
  }
</script>
<!doctype html>
<html lang='ja'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="none,noindex,nofollow">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/qaanswer.css">
    <link rel="stylesheet" href="css/testlook.css">
    <title>TAMARIBA | テスト画面</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="wrapper">
        <div class="title_menu">
            <h2>テスト画面</h2>
            <p><a href="testnewmake.php">テスト作成</a></p>
            <p style="right:160px;"><a href="testserch.php">テスト一覧</a></p>
        </div>
        <main>
        <div class="">
            <h3><?php echo $test['t_title'] ?></h3>
            <div class="qa_user_data">
                <p>作成者:<a href="userpage.php?id=<?php echo $test['t_createuser'] ?>"><?php echo $create_user['u_username'] ?></a></p>
                <p><?php 
                $t_created_at = explode(' ', $test['t_created_at']);
                echo '作成日:'.$t_created_at[0]; ?></p>
                <p><?php echo '閲覧数:'.$test['t_count'] ?></p>
            </div>
            <div class="inner_main">
                <?php
                    for ($i=0; $i < count($testQuestion); $i++) {
                        $n = $i+1;
                        echo "<div";
                        if ($i>0) {
                            echo " class='hide'";
                        }else{
                            echo " class='open'";
                        }
                        
                        echo " id='counter".$n."'><h4>問題".$n."</h4>";
                        echo "<div class='mainarea'><p class='inner_mainarea'>".$testQuestion[$i][2]."</p>";
                        $j = 0; 
                        while(true){
                            if(empty($testChoice[$i][$j][1])){
                                break;
                            }
                            $h=$j+1;
                            if($h==$testQuestion[$i][3]){
                                echo "<p class='choice_ans' onclick='ok(0,".$n.")'><span>".$h."</span>".$testChoice[$i][$j][3]."<br>";
                            }else{
                                echo "<p class='choice_ans' onclick='ok(1,".$n.")'><span>".$h."</span>".$testChoice[$i][$j][3]."<br>";
                            }                     
                            $j += 1;
                        }
                        echo "<div class='kaisetsu' id = ".$n."><div class='inner_kaisetsu'><h4>解説</h4>";
                        echo "<p>".$testQuestion[$i][4]."</p></div></div></div></div>";
                    }
                    echo "<div class='change_qus'>";
                    for($i=0; $i < count($testQuestion); $i++){
                        $k = $i+1;
                        echo "<a href='#' onclick='hide(".$k.")'>".$k."</a>";
                    }
                    echo "</div>";
                ?>
            </div>
        </div>    
        </main>
    </div>
    <?php include('footer.html'); ?>
</body>
</html>