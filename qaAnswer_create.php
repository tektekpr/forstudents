<?php

require 'dbconnect.php';
require 'session.php';

$url = "";
$qaAnswer = [];
$a_created_at = date("Y/m/d H:i:s");
if(isset($_POST['q_ID'])){
    $q_id = $_POST['q_ID'];
    $u_ID = $_SESSION['u_ID'];
    $a_body = $_POST['a_body'];
}else{
    header('Location: qaAnswer.php');
    exit();
}
// 
try{
    //DB接続オブジェクト
    //PDO…PHP Data Object
    /*$pdo = new PDO($dsn, $db_user, $db_password);
    //let logo = getElementById('id');

    //PDOの設定変更
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
    $pdo->setAttribute(
        PDO::ATTR_EMULATE_PREPARES,
        false
    );*/
//---------------------qaAnswerに格納
    try{
        $stmt = $db->prepare('select * from qaAnswer where q_id = ? ');
        $stmt->execute([$q_id]);
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $a_number = count($row) + 1;
    }catch(\Exception $e){
        $a_number = 1;
    }

    $stmt = $db->prepare('select * from qa where q_id = ? ');
    $stmt->execute([$q_id]);
    $qaa = $stmt->fetch(PDO::FETCH_ASSOC);

    $qaa['q_answer_count'] = $qaa['q_answer_count'] + 1;

    $stmt = $db->prepare("UPDATE qa SET q_answer_count = ?");
    $stmt->execute([$qaa['q_answer_count']]);

    //SQL文作成
    $stmt = $db->prepare("insert into qaAnswer(q_id, a_number, u_ID, a_body, a_created_at) value(?, ?, ?, ?, ?)");
    $stmt->execute([$q_id, $a_number, $u_ID, $a_body, $a_created_at]);

    /*$sql = "INSERT INTO qaAnswer (q_id, u_ID, a_body) VALUES (q_id=:q_id, u_id=:u_ID, a_body=:a_body)";

    //プリペアードステートメントの設定と取得
    $prestmt = $db->prepare($sql);

    //値の設定
    $prestmt->bindValue(':q_id', $q_id);//登録
    $prestmt->bindValue(':u_ID', $u_ID);//登録
    $prestmt->bindValue(':a_body', $a_body);//登録とログイン

    //SQL実行
    $prestmt->execute();*/

}catch(PDOException $error){
    //エラー時の処理を書く
    //echo $error->getMessage();
    //echo $error->getCode();
    // $_SESSION['error'] = 'エラー';
}
header('Location: qaAnswer.php?q_id='.$q_id.'&u_ID='.$u_ID);
?>